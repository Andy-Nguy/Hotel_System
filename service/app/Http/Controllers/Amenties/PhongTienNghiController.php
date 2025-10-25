<?php

namespace App\Http\Controllers\Amenties;

use App\Http\Controllers\Controller;
use App\Models\Amenties\Phong;
use App\Models\Amenties\TienNghiPhong;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PhongTienNghiController extends Controller
{
    public function getAssigned(Request $request)
    {
        $idPhong = $request->input('IDPhong');

        $assigned = DB::table('TienNghiPhong')
            ->join('TienNghi', 'TienNghiPhong.IDTienNghi', '=', 'TienNghi.IDTienNghi')
            ->select('TienNghi.IDTienNghi', 'TienNghi.TenTienNghi')
            ->where('TienNghiPhong.IDPhong', $idPhong)
            ->get();

        return response()->json($assigned);
    }

    public function show($phongId)
    {
        Log::debug('Fetching amenities for Phong ID: ' . $phongId);

        $phong = Phong::find($phongId);
        if (!$phong) {
            return response()->json(['success' => false, 'message' => 'Room not found'], 404);
        }

        // Use DB joins instead of a missing relation
        $tienNghis = DB::table('TienNghiPhong as tnp')
            ->join('TienNghi as tn', 'tnp.IDTienNghi', '=', 'tn.IDTienNghi')
            ->where('tnp.IDPhong', $phongId)
            ->orderBy('tn.TenTienNghi')
            ->get(['tn.IDTienNghi', 'tn.TenTienNghi']);

        return response()->json(['success' => true, 'data' => $tienNghis]);
    }

    public function update(Request $request, $phongId)
    {
        Log::info('Starting update for Phong ID: ' . $phongId, ['request' => $request->all()]);

        $phong = Phong::find($phongId);
        if (!$phong) {
            return response()->json(['success' => false, 'message' => 'Room not found'], 404);
        }

        // Prevent assigning/removing amenities when the room is currently in use
        // Consider the room FREE only when TrangThai is null/empty or equals any variant of "Trống"
        // Accept common variants: "Trống", "trong", "phòng trống"
        $status = $phong->TrangThai;
        $isFree = is_null($status) || $status === '' || $status === 'Phòng trống';
        // KẾT THÚC SỬA LOGIC

        if (!$isFree) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể gán/bỏ tiện nghi khi phòng không ở trạng thái Trống.'
            ], 400);
        }

        // Allow clearing all amenities: require the key to be present, but it may be an empty array
        $validated = $request->validate([
            'tien_nghi_ids' => 'present|array',
            'tien_nghi_ids.*' => 'string|exists:TienNghi,IDTienNghi',
        ]);

        $newTienNghiIds = array_values(array_unique($validated['tien_nghi_ids'] ?? []));
        Log::debug('New TienNghi IDs (unique): ', $newTienNghiIds);

        // Current IDs via DB (no relation)
        $currentTienNghiIds = DB::table('TienNghiPhong')
            ->where('IDPhong', $phongId)
            ->pluck('IDTienNghi')
            ->toArray();

        Log::debug('Current TienNghi IDs: ', $currentTienNghiIds);

        $idsToAdd = array_diff($newTienNghiIds, $currentTienNghiIds);
        $idsToRemove = array_diff($currentTienNghiIds, $newTienNghiIds);
        Log::debug('IDs to add: ', $idsToAdd);
        Log::debug('IDs to remove: ', $idsToRemove);

        DB::beginTransaction();
        try {
            if (!empty($idsToRemove)) {
                DB::table('TienNghiPhong')
                    ->where('IDPhong', $phongId)
                    ->whereIn('IDTienNghi', $idsToRemove)
                    ->delete();
            }

            if (!empty($idsToAdd)) {
                $insertData = [];
                foreach ($idsToAdd as $tid) {
                    // Generate a string primary key for the join table. Use UUIDs to guarantee uniqueness.
                    $insertData[] = [
                        'IDTienNghiPhong' => (string) Str::uuid(),
                        'IDPhong' => $phongId,
                        'IDTienNghi' => $tid
                    ];
                }
                TienNghiPhong::insert($insertData);
                Log::debug('Inserted ' . count($insertData) . ' new TienNghiPhong records');
            }

            $freshTienNghis = DB::table('TienNghiPhong as tnp')
                ->join('TienNghi as tn', 'tnp.IDTienNghi', '=', 'tn.IDTienNghi')
                ->where('tnp.IDPhong', $phongId)
                ->orderBy('tn.TenTienNghi')
                ->get(['tn.IDTienNghi', 'tn.TenTienNghi']);

            DB::commit();
            return response()->json(['success' => true, 'data' => $freshTienNghis]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update TienNghiPhong: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to update amenities: ' . $e->getMessage()
            ], 500);
        }
    }
}
