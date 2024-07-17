<?php

namespace App\Http\Controllers;

use App\Models\AccessLog;
use App\Models\Message;
use App\Models\Mission;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index () {
        $accessLog = AccessLog::where('user_id', auth()->id())->whereBetween('created_at', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])->count();
        $lastAccess = AccessLog::where('user_id', auth()->id())->orderBy('created_at', 'desc')->first();
        if ($lastAccess === null) {
            $new_mission = Mission::whereIn('user_id', [0, auth()->id()])->count();
        } else {
            $new_mission = Mission::whereIn('user_id', [0, auth()->id()])->where('created_at', '>', $lastAccess->created_at)->count();
        }
        AccessLog::create([
            'user_id' => auth()->id(),
        ]);
        $team_mission = Mission::where('user_id', 0)->where('start_date', '<=', date('Y-m-d'))->where('due_date', '>=', date('Y-m-d'))->orderBy('created_at', 'desc')->get();
        $your_mission = Mission::where('user_id', auth()->id())->where('start_date', '<=', date('Y-m-d'))->where('due_date', '>=', date('Y-m-d'))->orderBy('created_at', 'desc')->get();
        $data = [
            'access_log' => $accessLog,
            'start_of_day' => now('Asia/Tokyo')->startOfDay(),
            'end_of_day' => now('Asia/Tokyo')->endOfDay(),
            'user' => auth()->user(),
            'team_mission' => $team_mission,
            'your_mission' => $your_mission,
            'new_mission' => $new_mission,
        ];
        return view('index', $data);
    }

    public function mypage () {

    }
}
