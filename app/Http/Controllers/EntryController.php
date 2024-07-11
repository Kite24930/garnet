<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Group;
use App\Models\Item;
use App\Models\Rank;
use App\Models\TaskView;
use Illuminate\Http\Request;

class EntryController extends Controller
{
    //

    public function show() {
        $ranks = Rank::all();
        $categories = Category::all();
        $groups = Group::all();
        $items = Item::all();
        $tasks = TaskView::orderBy('category_id')->orderBy('group_id')->orderBy('item_id')->orderBy('rank_id')->get();
        $data = [
            'ranks' => $ranks,
            'categories' => $categories,
            'groups' => $groups,
            'items' => $items,
            'tasks' => $tasks
        ];
        return view('entry.entry', $data);
    }

    public function store(Request $request) {

    }
}
