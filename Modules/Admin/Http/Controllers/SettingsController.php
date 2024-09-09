<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\User;
use App\Site_settings;
use App\Email_templates;
use App\Cms_pages;
use App\Faq;
use App\Helpers\Helper;

class SettingsController extends Controller
{
    public $_helper;

    public function __construct()
    {
        $this->_helper = new Helper();
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $users = array();
        return view('admin::settings.index', compact('users'));
    }
    /**
     * this function is use to store notification management for admin setting. 
     */
    public function notification(Request $request)
    {
        if ($request->ajax()) {
            $response_array = array('status' => false, 'message' => null, 'data' => null);
            $request->validate([
                'id' => 'required|numeric|exists:email_templates,id',
                'subject' => 'required|max:255',
                'email_content' => 'required',
            ]);
            $data = array(
                'subject' => $request->subject,
                'email_content' => $request->email_content,
            );
            Email_templates::where('id', $request->id)->update($data);
            $response_array['status'] = true;
            $response_array['message'] = 'Template updated successfully.';
            return response()->json($response_array);
        }
        $data = array();
        $data['email_templates_info'] = Email_templates::get();
        $helper = new Helper();
        $data['keys'] = $helper->getEmailKeys();
        return view('admin::settings.notification', compact('data'));
    }
    /**
     * this function is use to listing notification management for admin setting. 
     */
    public function notificationList(Request $request)
    {
        if ($request->ajax()) {
            $response_array = array('status' => false, 'message' => null, 'data' => null);
            $response_array['status'] = true;
            $data = array();
            $data['email_templates_info'] = Email_templates::get();
            $data['id'] = isset($request->id) ? $request->id : 0;
            $response_array['data']['html'] = view('admin::settings.notification-list', compact('data'))->render();
            return response()->json($response_array);
        }
    }
   /**
     * this function is use to update cms management for admin setting. 
     */
    public function cms(Request $request)
    {
        if ($request->ajax()) {
            $response_array = array('status' => false, 'message' => null, 'data' => null);
            $request->validate([
                'id' => 'required|numeric|exists:cms_pages,id',
                'title' => 'required|max:255',
                'description' => 'required',
            ]);
            $data = array(
                'title' => $request->title,
                'description' => $request->description,
            );
            Cms_pages::where('id', $request->id)->update($data);
            $response_array['status'] = true;
            $response_array['message'] = 'Page updated successfully.';
            return response()->json($response_array);
        }
        $data = array();
        $data['cms_pages_info'] = Cms_pages::get();
        return view('admin::settings.cms', compact('data'));
    }
    /**
     * this function is use to listing cms management for admin setting. 
     */
    public function cmsList(Request $request)
    {
        if ($request->ajax()) {
            $response_array = array('status' => false, 'message' => null, 'data' => null);
            $response_array['status'] = true;
            $data = array();
            $data['cms_pages_info'] = Cms_pages::get();
            $data['id'] = isset($request->id) ? $request->id : 0;
            $response_array['data']['html'] = view('admin::settings.cms-list', compact('data'))->render();
            return response()->json($response_array);
        }
    }
    /**
     * this function is use to update faq management for admin setting. 
     */
    public function faq(Request $request)
    {
        if ($request->ajax()) {
            $response_array = array('status' => false, 'message' => null, 'data' => null);
            $request->validate([
                'question' => 'required|max:255',
                'answer' => 'required',
            ]);
            $data = array(
                'question' => $request->question,
                'answer' => $request->answer,
            );
            if ($request->id > 0) {
                Faq::where('id', $request->id)->update($data);
                $response_array['message'] = 'Faq updated successfully.';
            } else {
                Faq::create($data);
                $response_array['message'] = 'Faq added successfully.';
            }
            $response_array['status'] = true;
            return response()->json($response_array);
        }
        $data = array();
        $data['faq_info'] = Faq::get();
        return view('admin::settings.faq', compact('data'));
    }
    /**
     * this function is use to listing faq management for admin setting. 
     */
    public function faqList(Request $request)
    {
        if ($request->ajax()) {
            $response_array = array('status' => false, 'message' => null, 'data' => null);
            $response_array['status'] = true;
            $data = array();
            $data['faq_info'] = Faq::get();
            $data['id'] = isset($request->id) ? $request->id : 0;
            $response_array['data']['html'] = view('admin::settings.faq-list', compact('data'))->render();
            return response()->json($response_array);
        }
    }
    /**
     * this function is use to update general for admin setting. 
     */
    public function general(Request $request)
    {
        if ($request->ajax()) {
            $response_array = array('status' => false, 'message' => null, 'data' => null);
            $request->validate([
                'time_zone' => 'required',
                'currency' => 'required',
            ]);
            Site_settings::where('setting_key', 'time_zone')->update(['setting_value' => $request->time_zone]);
            Site_settings::where('setting_key', 'currency')->update(['setting_value' => $request->currency]);
            Site_settings::where('setting_key', 'order_prefix')->update(['setting_value' => $request->order_prefix]);
            Site_settings::where('setting_key', 'order_suffix')->update(['setting_value' => $request->order_suffix]);
            $response_array['status'] = true;
            $response_array['message'] = 'Settings updated successfully.';
            return response()->json($response_array);
        }
        $data = array(
            'time_zone' => Site_settings::select('setting_value')->where('setting_key', 'time_zone')->get()->pluck('setting_value')[0],
            'currency' => Site_settings::select('setting_value')->where('setting_key', 'currency')->get()->pluck('setting_value')[0],
            'order_prefix' => Site_settings::select('setting_value')->where('setting_key', 'order_prefix')->get()->pluck('setting_value')[0],
            'order_suffix' => Site_settings::select('setting_value')->where('setting_key', 'order_suffix')->get()->pluck('setting_value')[0],
        );
        return view('admin::settings.general', compact('data'));
    }
    /**
     * this function is use to delete faq for admin setting. 
     */
    public function faqDelete(Request $request)
    {
        $this->_helper->delete_data('faqs', array('where' => array('id' => $request->id)));
        $response_array = array(
            'status' => true, 'message' => 'Record deleted successfully.'
        );
        return response()->json($response_array);
    }
}
