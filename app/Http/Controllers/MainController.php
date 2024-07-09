<?php

namespace App\Http\Controllers;

use App\Models\AccessLog;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index () {
        $accessLog = AccessLog::where('user_id', auth()->id())->whereBetween('created_at', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])->count();
        AccessLog::create([
            'user_id' => auth()->id(),
        ]);
        $data = [
            'access_log' => $accessLog,
            'start_of_day' => now('Asia/Tokyo')->startOfDay(),
            'end_of_day' => now('Asia/Tokyo')->endOfDay(),
        ];
        return view('index', $data);
    }
}
