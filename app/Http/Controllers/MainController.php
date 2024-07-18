<?php

namespace App\Http\Controllers;

use App\Models\AccessLog;
use App\Models\Message;
use App\Models\MessageView;
use App\Models\Mission;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $unread_messages = Message::where('user_id', auth()->id())->where('is_read', 0)->count();
        $data = [
            'access_log' => $accessLog,
            'start_of_day' => now('Asia/Tokyo')->startOfDay(),
            'end_of_day' => now('Asia/Tokyo')->endOfDay(),
            'user' => auth()->user(),
            'team_mission' => $team_mission,
            'your_mission' => $your_mission,
            'new_mission' => $new_mission,
            'unread_messages' => $unread_messages,
        ];
        return view('index', $data);
    }

    public function mypage () {
        $unread_messages = Message::where('user_id', auth()->id())->where('is_read', 0)->count();
        $data = [
            'user' => auth()->user(),
            'messages' => Message::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get(),
            'unread_messages' => $unread_messages,
        ];
        return view('mypage.mypage', $data);
    }

    public function messages () {
        $unread_messages = MessageView::where('user_id', auth()->id())->where('is_read', 0)->get();
        $read_messages = MessageView::where('user_id', auth()->id())->where('is_read', 1)->get();
        $data = [
            'user' => auth()->user(),
            'unread_messages' => $unread_messages,
            'read_messages' => $read_messages,
        ];
        return view('mypage.messages', $data);
    }

    public function messageView ($message) {
        Message::find($message)->update([
            'is_read' => 1,
            'read_at' => now()
        ]);
        $message = MessageView::where('id', $message)->first();
        $data = [
            'user' => auth()->user(),
            'message' => $message,
        ];
        return view('mypage.message_view', $data);
    }

    public function messageList () {
        $messages = MessageView::where('sent_from', auth()->id())->orderBy('created_at', 'desc')->get();
        $data = [
            'user' => auth()->user(),
            'messages' => $messages,
        ];
        return view('mypage.message_list', $data);
    }

    public function messageSend () {
        $data = [
            'users' => User::all(),
        ];
        return view('mypage.message_send', $data);
    }

    public function messageStore (Request $request) {
        try {
            DB::beginTransaction();
            foreach ($request->users as $user_id) {
                $message[] = Message::create([
                    'user_id' => $user_id,
                    'title' => $request->title,
                    'message' => $request->message,
                    'sent_from' => auth()->id(),
                ]);
            }
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => $message,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send message',
                'error' => $e->getMessage(),
                'request' => $request->all(),
            ]);
        }
    }

    public function messageEdit ($message) {
        $data = [
            'user' => auth()->user(),
            'message' => MessageView::find($message),
        ];
        return view('mypage.message_edit', $data);
    }

    public function messageUpdate (Request $request, $message) {
        try {
            $message = Message::find($message);
            $message->update([
                'title' => $request->title,
                'message' => $request->message,
            ]);
            return response()->json([
                'status' => 'success',
                'message' => $message,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update message',
                'error' => $e->getMessage(),
                'request' => $request->all(),
            ]);
        }
    }

    public function messageDestroy (Message $message) {
        try {
            $message->delete();
            return redirect()->route('message.list');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete message');
        }
    }

    public function getVapidKey () {
        return response()->json([
            'vapid_kay' => env('VAPID_KEY'),
        ]);
    }

    public function registerNotificationToken(Request $request) {
        try {
            $user = auth()->user();
            $isExist = Notification::where('user_id', $user->id)->where('token', $request->token)->exists();
            if (!$isExist) {
                Notification::create([
                    'user_id' => $user->id,
                    'token' => $request->token,
                ]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Notification token registered successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Notification token already registered',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Notification token registration failed',
                'error' => $e->getMessage(),
            ]);
        }
    }
}
