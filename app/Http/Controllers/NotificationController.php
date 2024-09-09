<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;
use App\Event;
use App\Helpers\Helper;
use DB;
use App\User;

class NotificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * This function is used to show the notification configuration page
     */
    public function index()
    {
        $user = Auth::user();
        $user = User::find($user->id);
        return view('setting.notification', compact('user'));
    }

    /**
     * This function is used to update the notification configuration settings
     */
    public function update(Request $request)
    {
        DB::table('users')->where('id', Auth::id())->update([$request->name => $request->value]);
        $response_array = array('status' => true, 'message' => 'Status updated successfully.', 'data' => null);
        return response()->json($response_array);
    }
    
    public function markAsRead()
    {
        $status_update = DB::table('notifications')
            ->where('id_user', Auth::id())
            ->update(['is_read' => 1]);
    
        if ($status_update) {
            return response()->json(['success' => true, 'message' => 'Notifications marked as read']);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to mark notifications as read']);
        }
    }
}
