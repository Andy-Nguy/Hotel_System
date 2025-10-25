<?php

namespace App\Http\Controllers\Api\Checkout;

use App\Http\Controllers\Controller;
use App\Models\DichVu;

class ServiceController extends Controller
{
    public function index()
    {
        $data = DichVu::query()
            ->orderBy('TenDichVu')
            ->get(['IDDichVu','TenDichVu','TienDichVu','HinhDichVu']);

        return response()->json(['success' => true, 'data' => $data]);
    }
}