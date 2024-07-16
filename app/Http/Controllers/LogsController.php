<?php

namespace App\Http\Controllers;

use App\Models\Rank;
use App\Models\ResultView;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogsController extends Controller
{
    public function show($year = null, $month = null, $user = null) {
        if ($year === null || $month === null) {
            $year = date('Y');
            $month = date('m');
        }
        if ($user === null) {
            $user = auth()->id();
        }
        $start_of_month = Carbon::create($year, $month, 1);
        $end_of_month = $start_of_month->copy()->endOfMonth();

        $prev_month = $start_of_month->copy()->subMonth();
        $next_month = $start_of_month->copy()->addMonth();

        $start_of_calendar = $start_of_month->copy()->startOfWeek(Carbon::MONDAY);
        $end_of_calendar = $end_of_month->copy()->endOfWeek(Carbon::SUNDAY);

        $dates = [];

        $current_date = $start_of_calendar->copy();
        while ($current_date->lte($end_of_calendar)) {
            $result_counts = ResultView::where('date', $current_date->format('Y-m-d'))->where('user_id', $user)->count();
            if ($result_counts === 0) {
                $dates[] = [
                    'date' => $current_date->format('Y-m-d'),
                    'rank' => null,
                    'results' => [],
                ];
                $current_date->addDay();
                continue;
            }
            $results = ResultView::where('date', $current_date->format('Y-m-d'))->where('user_id', $user)->orderBy('rank_id', 'desc')->get();
            $rank_counts = ResultView::select('rank_id', DB::raw('count(*) as count'))->where('date', $current_date->format('Y-m-d'))->where('user_id', $user)->groupBy('rank_id')->orderBy('rank_id', 'desc')->get();
            $target_rank = 1;
            $addition = 0;
            foreach($rank_counts as $rank_count) {
                $judging = $addition + $rank_count->count;
                if ($judging > 1) {
                    $target_rank = $rank_count->rank_id;
                    break;
                }
                $addition += $rank_count->count;
            }
            $get_rank = Rank::find($target_rank);
            $dates[] = [
                'date' => $current_date->format('Y-m-d'),
                'rank' => $get_rank,
                'results' => $results,
            ];
            $current_date->addDay();
        }

        $weekdays = ['月', '火', '水', '木', '金', '土', '日'];

        $data = [
            'year' => $year,
            'month' => $month,
            'dates' => $dates,
            'prev_month' => $prev_month,
            'next_month' => $next_month,
            'weekdays' => $weekdays,
            'user' => User::find($user),
            'users' => User::all(),
        ];
        return view('logs.logs', $data);
    }

    public function view($log, $user) {
        $results = ResultView::where('date', $log)->where('user_id', $user)->orderBy('rank_id', 'desc')->get();
        $rank_counts = ResultView::select('rank_id', DB::raw('count(*) as count'))->where('date', $log)->where('user_id', $user)->groupBy('rank_id')->orderBy('rank_id', 'desc')->get();
        $target_rank = 1;
        $addition = 0;
        foreach($rank_counts as $rank_count) {
            $judging = $addition + $rank_count->count;
            if ($judging > 1) {
                $target_rank = $rank_count->rank_id;
                break;
            }
            $addition += $rank_count->count;
        }
        $get_rank = Rank::find($target_rank);
        $data = [
            'user' => User::find($user),
            'results' => $results,
            'rank_counts' => $rank_counts,
            'get_rank' => $get_rank,
            'date' => $log,
        ];
        return view('logs.log-view', $data);
    }
}
