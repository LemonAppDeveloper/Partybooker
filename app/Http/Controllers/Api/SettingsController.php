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
use Illuminate\Support\Facades\Validator;
use Hash;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    /**
     * This function is used to get general settings
     */
    public function general(Request $request)
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);
        $httpCode = 200;
        $message = '';
        $data = array(
            'version_info' => array(
                'ios_version' => 1.0,
                'ios_update_text' => 'New application has been updated. Would you like to update?',
                'ios_force_update_required' => 1,
                'android_version' => 1.0,
                'android_update_text' => 'New application has been updated. Would you like to update?',
                'android_force_update_required' => 1,
            )
        );
        if ($request->action == 'get') {
            $data['general'] =  Site_settings::select('id', 'setting_key', 'setting_value')->get();
            $response_array['status'] = true;
            $response_array['data'] = $data;
        } else {
            $message = 'Details not available.';
            $data = null;
            $response_array['message'] = $message;
        }
        return response()->json($response_array);
    }

    /**
     * Used to get faq
     */
    public function faq(Request $request)
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);
        $httpCode = 200;
        $message = '';
        if ($request->action == 'get') {
            $data =  Faq::select('id', 'question', 'answer')->where('is_enable', 1)->get();
            if (empty($data) || count($data) == 0) {
                $message = 'Details not available.';
                $data = null;
                $response_array['message'] = $message;
            } else {
                $response_array['status'] = true;
                $response_array['data'] = $data;
            }
        } else {
            $message = 'Details not available.';
            $data = null;
            $response_array['message'] = $message;
        }
        return response()->json($response_array);
    }

    /**
     * Used to get CMS
     */
    public function cms(Request $request)
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);
        $httpCode = 200;
        $message = '';
        if ($request->action == 'get') {
            $data =  Cms_pages::select('id', 'title', 'slug', 'description')->where('is_enable', 1)->get();
            if (empty($data) || count($data) == 0) {
                $message = 'Details not available.';
                $response_array['message'] = $message;
                $data = null;
            } else {
                $response_array['status'] = true;
                $response_array['data'] = $data;
            }
        } else {
            $message = 'Details not available.';
            $data = null;
            $response_array['message'] = $message;
        }
        return response()->json($response_array);
    }
}
