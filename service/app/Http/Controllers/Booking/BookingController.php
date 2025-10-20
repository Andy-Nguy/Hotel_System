<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmation;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'IDKhachHang' => 'required|integer',
            'IDPhong' => 'required|string',
            'NgayNhanPhong' => 'required|date',
            'NgayTraPhong' => 'required|date',
            'GiaPhong' => 'required|numeric',
            'SoDem' => 'required|integer',
            'TongTien' => 'nullable|numeric',
        ]);

        // Compute TongTien if not provided
        if (!isset($validated['TongTien'])) {
            $validated['TongTien'] = $validated['GiaPhong'] * $validated['SoDem'];
        }

        // Format dates to Y-m-d
        $validated['NgayNhanPhong'] = \Carbon\Carbon::parse($validated['NgayNhanPhong'])->format('Y-m-d');
        $validated['NgayTraPhong'] = \Carbon\Carbon::parse($validated['NgayTraPhong'])->format('Y-m-d');

        // Generate IDDatPhong
        $idDatPhong = 'DP' . strtoupper(uniqid());

        // Prepare data for insert
        $data = [
            'IDDatPhong' => $idDatPhong,
            'IDKhachHang' => $validated['IDKhachHang'],
            'IDPhong' => $validated['IDPhong'],
            'NgayDatPhong' => now()->toDateString(),
            'NgayNhanPhong' => $validated['NgayNhanPhong'],
            'NgayTraPhong' => $validated['NgayTraPhong'],
            'SoDem' => $validated['SoDem'],
            'GiaPhong' => $validated['GiaPhong'],
            'TongTien' => $validated['TongTien'],
            'TienCoc' => 0,
            'TienConLai' => $validated['TongTien'],
            'TrangThai' => 1,
            'TrangThaiThanhToan' => 0,
        ];

        try {
            DB::table('DatPhong')->insert($data);

            // Determine recipient email: prefer provided Email in request, fallback to DB lookup
            $recipientEmail = $request->input('Email');
            $recipientName = null;

            if (!$recipientEmail) {
                $khachHang = DB::table('KhachHang')
                    ->where('IDKhachHang', $validated['IDKhachHang'])
                    ->select('HoTen', 'Email')
                    ->first();

                if ($khachHang) {
                    $recipientEmail = $khachHang->Email;
                    $recipientName = $khachHang->HoTen;
                }
            }

            if ($recipientEmail) {
                try {
                    Log::info('Sending booking confirmation email', [
                        'booking_id' => $idDatPhong,
                        'to' => $recipientEmail,
                    ]);

                    Mail::to($recipientEmail)->send(new BookingConfirmation($data, ['HoTen' => $recipientName, 'Email' => $recipientEmail]));

                    Log::info('Booking confirmation email sent successfully', [
                        'booking_id' => $idDatPhong,
                        'to' => $recipientEmail,
                    ]);
                } catch (\Exception $mailEx) {
                    Log::error('Failed to send booking confirmation email', [
                        'booking_id' => $idDatPhong,
                        'to' => $recipientEmail,
                        'error' => $mailEx->getMessage(),
                    ]);
                    // continue without failing the booking
                }
            } else {
                Log::warning('No recipient email found for booking', ['booking_id' => $idDatPhong]);
            }

            return response()->json([
                'status' => 'success',
                'confirmation' => $idDatPhong,
                'data' => $data,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Booking insert failed: ' . $e->getMessage(), ['data' => $data]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to save booking: ' . $e->getMessage(),
            ], 500);
        }
    }
}
