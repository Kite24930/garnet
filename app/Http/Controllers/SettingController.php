<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Group;
use App\Models\Rank;
use App\Models\Task;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function show() {
        $data = [];
        return view('settings.settings', $data);
    }

    public function rank() {
        $rank = Rank::all();
        $data = [
            'rank' => $rank
        ];
        return view('settings.rank', $data);
    }

    public function rankStore(Request $request) {
        try {
            foreach($request->ranks as $rank) {
                Rank::updateOrCreate([
                    'id' => $rank->id
                ], [
                    'name' => $rank->name,
                    'eng_name' => $rank->eng_name,
                    'icon' => $rank->icon,
                ]);
            }
            return redirect()->route('setting.rank')->with('success', 'Rank added successfully');
        } catch (\Exception $e) {
            return redirect()->route('setting.rank')->with('error', 'Rank added failed');
        }
    }

    public function category() {
        $categories = Category::all();
        $data = [
            'categories' => $categories,
        ];
        return view('settings.category', $data);
    }

    public function categoryStore(Request $request) {
        try {
            foreach($request->categories as $category) {
                Category::updateOrCreate([
                    'id' => $category->id
                ], [
                    'name' => $category->name,
                    'eng_name' => $category->eng_name,
                    'icon' => $category->icon,
                ]);
            }
            return redirect()->route('setting.category')->with('success', 'Category added successfully');
        } catch (\Exception $e) {
            return redirect()->route('setting.category')->with('error', 'Category added failed');
        }
    }

    public function task() {
        $ranks = Rank::all();
        $categories = Category::all();
        $groups = Group::all();
        $tasks = Task::all();
        $data = [
            'ranks' => $ranks,
            'categories' => $categories,
            'groups' => $groups,
            'tasks' => $tasks,
        ];
        return view('settings.task', $data);
    }

    public function taskNew() {
        $ranks = Rank::all();
        $categories = Category::all();
        $groups = Group::all();
        $data = [
            'ranks' => $ranks,
            'categories' => $categories,
            'groups' => $groups,
        ];
        return view('settings.task_new', $data);
    }

    public function taskStore(Request $request) {
        try {
            Task::create([
                'name' => $request->name,
                'eng_name' => $request->eng_name,
                'icon' => $request->icon,
                'rank_id' => $request->rank_id,
                'category_id' => $request->category_id,
                'group_id' => $request->group_id,
            ]);
            return redirect()->route('setting.task')->with('success', 'Task added successfully');
        } catch (\Exception $e) {
            return redirect()->route('setting.task')->with('error', 'Task added failed');
        }
    }

    public function taskUpdate(Request $request, $task) {
        try {
            $target = Task::find($task);
            $target->update([
                'name' => $request->name,
                'eng_name' => $request->eng_name,
                'icon' => $request->icon,
                'rank_id' => $request->rank_id,
                'category_id' => $request->category_id,
                'group_id' => $request->group_id,
            ]);
            return redirect()->route('setting.task')->with('success', 'Task updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('setting.task')->with('error', 'Task updated failed');
        }
    }
}
