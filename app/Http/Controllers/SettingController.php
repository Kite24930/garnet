<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Group;
use App\Models\Rank;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function show() {
        $data = [];
        return view('settings.settings', $data);
    }

    public function rank() {
        $ranks = Rank::all();
        $data = [
            'ranks' => $ranks,
        ];
        return view('settings.rank', $data);
    }

    public function rankStore(Request $request) {
        try {
            $ranks = $request->input('ranks');
            foreach($ranks as $rank) {
                if ($request->hasFile('icon_'.$rank['id'])) {
                    $icon = $request->file('icon_'.$rank['id']);
                    Storage::disk('public')->put('icons/'.$icon->getClientOriginalName(), file_get_contents($icon));
                }
                Rank::updateOrCreate([
                    'id' => $rank['id']
                ], [
                    'name' => $rank['name'],
                    'eng_name' => $rank['eng_name'],
                    'icon' => $rank['icon'],
                ]);
            }
            return response()->json(['status' => 'success', 'success' => 'Rank added successfully', 'request' => $request->all(), 'ranks' => Rank::all()]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'error' => 'Rank added failed', 'message' => $e->getMessage(), 'request' => $request->all(), 'ranks' => Rank::all()]);
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
            $categories = $request->input('categories');
            foreach($categories as $category) {
                Category::updateOrCreate([
                    'id' => $category['id']
                ], [
                    'name' => $category['name'],
                    'eng_name' => $category['eng_name'],
                ]);
            }
            return redirect()->route('setting.category')->with('success', 'Category added successfully');
        } catch (\Exception $e) {
            return redirect()->route('setting.category')->with('error', 'Category added failed')->with('message', $e->getMessage())->with('request', $request->all());
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
