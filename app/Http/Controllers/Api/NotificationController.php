<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\device_tokens;
use App\Helpers\Helper;
use App\User;
use App\Cms_pages;
use App\Faq;
use App\Site_settings;
use Exception;
use Illuminate\Support\Facades\Validator;
use Hash;
use Illuminate\Validation\Rule;
use DB;

class NotificationController extends Controller
{
    public $_helper;

    public function __construct()
    {
        $this->_helper = new Helper();
    }

    /**
     * This function is used to update the notification preferences
     */
    public function update(Request $request)
    {
        DB::table('users')->where('id', Auth::id())->update([$request->name => $request->value]);
        $response_array = array('status' => true, 'message' => 'Status updated successfully.', 'data' => null);
        return response()->json($response_array);
    }

    /**
     * This function is used to get the listing of sent notificaiton
     */
    public function get()
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);
        $message = '';
        $data =  DB::table('notifications')->select('id', 'notification', 'is_read', 'created_at')->where('id_user', Auth::id())->orderBy('id', 'DESC')->get();
        if (empty($data) || count($data) == 0) {
            $message = 'Details not available.';
            $data = null;
            $response_array['message'] = $message;
        } else {
            $response_array['status'] = true;
            foreach ($data as &$value) {
                $value->created_at = get_time_ago($value->created_at);
            }
            $response_array['data'] = $data;
        }
        return response()->json($response_array);
    }

    /**
     * This function is used to mark the notification as read
     */
    public function detail(Request $request)
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);
        $message = '';
        DB::table('notifications')->where('id', $request->id)->update(['is_read' => 1]);
        $data =  DB::table('notifications')->select('id', 'notification', 'is_read', 'created_at')->where('id_user', Auth::id())->where('id', $request->id)->orderBy('id', 'DESC')->first();
        if (empty($data)) {
            $message = 'Details not available.';
            $data = null;
            $response_array['message'] = $message;
        } else {
            $response_array['status'] = true;
            $data->created_at = get_time_ago($data->created_at);
            $response_array['data'] = $data;
        }
        return response()->json($response_array);
    }

    public function sendNotification(Request $request)
    {

        $get_user_details = User::where('id', $request->user_id)->get();
        $notification_push_status = $get_user_details[0]['notification_push_status'];
        $notification_token = $get_user_details[0]['notification_token'];
        $device_type = $get_user_details[0]['notification_device_type'];
        $notification_title = "Test Send Push Notification";
        $notification_body = "Test Body Massage";

        if ($notification_push_status == 1) {
            $response = $this->sendPushNotification($notification_token, $notification_title, $notification_body);
            return response()->json(['message' => 'Push notification sent successfully', 'response' => $response]);
        } else {
            return response()->json(['message' => 'Push notification not sent. Notification push status is disabled.']);
        }
    }
}
