<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Group;
use App\Models\Item;
use App\Models\Rank;
use App\Models\Result;
use App\Models\ResultView;
use App\Models\Task;
use App\Models\TaskCountView;
use App\Models\TaskView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EntryController extends Controller
{
    //

    public function show() {
        $ranks = Rank::all();
        $categories = Category::all();
        $groups = Group::all();
        $items = Item::all();
        $tasks = TaskView::orderBy('category_id')->orderBy('group_id')->orderBy('item_id')->orderBy('rank_id')->get();
        $task_counts = TaskCountView::all();
        $data = [
            'ranks' => $ranks,
            'categories' => $categories,
            'groups' => $groups,
            'items' => $items,
            'tasks' => $tasks,
            'task_counts' => $task_counts
        ];
        return view('entry.entry', $data);
    }

    public function store(Request $request) {
        try {
            DB::beginTransaction();
            Result::where('date', $request->date)->where('user_id', auth()->id())->delete();
            foreach($request->tasks as $task) {
                Result::create([
                    'date' => $request->date,
                    'task_id' => $task,
                    'user_id' => auth()->id(),
                ]);
            }
            DB::commit();
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function result($date) {
        $results = ResultView::where('date', $date)->where('user_id', auth()->id())->orderBy('rank_id', 'desc')->get();
        $rank_counts = ResultView::select('rank_id', DB::raw('count(*) as count'))->where('date', $date)->where('user_id', auth()->id())->groupBy('rank_id')->orderBy('rank_id', 'desc')->get();
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
            'results' => $results,
            'rank_counts' => $rank_counts,
            'get_rank' => $get_rank,
        ];
        return view('entry.result', $data);
    }
}
