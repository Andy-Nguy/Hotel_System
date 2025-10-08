<?php

namespace App\Http\Controllers\Amenties;

use App\Http\Controllers\Controller;
use App\Models\Amenties\TienNghi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TienNghiController extends Controller
{
    // GET /api/tien-nghi
    public function index()
    {
        $data = TienNghi::orderBy('IDTienNghi')->get(['IDTienNghi', 'TenTienNghi']);
        return response()->json(['success' => true, 'data' => $data]);
    }

    // POST /api/tien-nghi
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'TenTienNghi' => 'required|string|max:100|unique:TienNghi,TenTienNghi',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $tienNghi = TienNghi::create($validator->validated());
        return response()->json(['success' => true, 'data' => $tienNghi]);
    }

    // PUT /api/tien-nghi/{id}
    public function update(Request $request, TienNghi $tienNghi)
    {
        $validator = Validator::make($request->all(), [
            'TenTienNghi' => [
                'required', 'string', 'max:100',
                Rule::unique('TienNghi', 'TenTienNghi')->ignore($tienNghi->IDTienNghi, 'IDTienNghi'),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $tienNghi->update($validator->validated());
        return response()->json(['success' => true, 'data' => $tienNghi]);
    }

    // DELETE /api/tien-nghi/{id}
    public function destroy(TienNghi $tienNghi)
    {
        $tienNghi->phongs()->detach();
        $tienNghi->delete();

        return response()->json(['success' => true]);
    }
}
