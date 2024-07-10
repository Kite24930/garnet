<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Group;
use App\Models\Item;
use App\Models\Rank;
use App\Models\Task;
use App\Models\TaskView;
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

    public function group() {
        $groups = Group::all();
        $data = [
            'groups' => $groups,
        ];
        return view('settings.group', $data);
    }

    public function groupStore(Request $request) {
        try {
            $groups = $request->input('groups');
            foreach($groups as $group) {
                Group::updateOrCreate([
                    'id' => $group['id']
                ], [
                    'name' => $group['name'],
                    'eng_name' => $group['eng_name'],
                ]);
            }
            return redirect()->route('setting.group')->with('success', 'Group added successfully');
        } catch (\Exception $e) {
            return redirect()->route('setting.group')->with('error', 'Group added failed')->with('message', $e->getMessage())->with('request', $request->all());
        }
    }

    public function item() {
        $items = Item::all();
        $data = [
            'items' => $items,
        ];
        return view('settings.item', $data);
    }

    public function itemStore(Request $request) {
        try {
            $items = $request->input('items');
            foreach($items as $item) {
                Item::updateOrCreate([
                    'id' => $item['id']
                ], [
                    'name' => $item['name'],
                ]);
            }
            return redirect()->route('setting.item')->with('success', 'Item added successfully');
        } catch (\Exception $e) {
            return redirect()->route('setting.item')->with('error', 'Item added failed')->with('message', $e->getMessage())->with('request', $request->all());
        }
    }

    public function task() {
        $tasks = TaskView::orderBy('category_id')->orderBy('group_id')->orderBy('item_id')->orderBy('rank_id')->get();
        $data = [
            'tasks' => $tasks,
        ];
        return view('settings.task', $data);
    }

    public function taskNew() {
        $ranks = Rank::all();
        $categories = Category::all();
        $groups = Group::all();
        $items = Item::all();
        $data = [
            'ranks' => $ranks,
            'categories' => $categories,
            'groups' => $groups,
            'items' => $items,
        ];
        return view('settings.task_new', $data);
    }

    public function taskStore(Request $request) {
        try {
            Task::create([
                'rank_id' => $request->rank_id,
                'category_id' => $request->category_id,
                'group_id' => $request->group_id,
                'item_id' => $request->item_id,
                'text' => $request->text,
            ]);
            return redirect()->route('setting.task')->with('success', 'Task added successfully');
        } catch (\Exception $e) {
            return redirect()->route('setting.task')->with('error', 'Task added failed')->with('message', $e->getMessage())->with('request', $request->all());
        }
    }

    public function taskEdit($task) {
        $ranks = Rank::all();
        $categories = Category::all();
        $groups = Group::all();
        $items = Item::all();
        $target = Task::find($task);
        $data = [
            'ranks' => $ranks,
            'categories' => $categories,
            'groups' => $groups,
            'items' => $items,
            'target' => $target,
        ];
        return view('settings.task_edit', $data);
    }

    public function taskUpdate(Request $request, $task) {
        try {
            $target = Task::find($task);
            $target->update([
                'rank_id' => $request->rank_id,
                'category_id' => $request->category_id,
                'group_id' => $request->group_id,
                'item_id' => $request->item_id,
                'text' => $request->text,
            ]);
            return redirect()->route('setting.task')->with('success', 'Task updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('setting.task')->with('error', 'Task updated failed');
        }
    }

    public function taskDestroy($task) {
        try {
            Task::destroy($task);
            return redirect()->route('setting.task')->with('success', 'Task deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('setting.task')->with('error', 'Task deleted failed');
        }
    }
}
