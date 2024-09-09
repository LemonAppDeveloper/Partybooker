<?php

namespace Modules\Vendor\Http\Controllers;

use App\BankDetails;
use App\VendorCms;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\User;
use App\Site_settings;
use App\Email_templates;
use App\Cms_pages;
use App\Faq;
use App\Helpers\Helper;
use App\VendorFaq;
use Illuminate\Support\Facades\Auth;
use Laravel\Ui\Presets\React;

class ConfigrationController extends Controller
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
        return view('vendor::settings.index', compact('users'));
    }
    /**
     * this function is use to update notification for vendor side.
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
        return view('vendor::settings.notification', compact('data'));
    }
   /**
     * this function is use to lsiting notification for vendor side.
     * @return Renderable
     */
    public function notificationList(Request $request)
    {
        if ($request->ajax()) {
            $response_array = array('status' => false, 'message' => null, 'data' => null);
            $response_array['status'] = true;
            $data = array();
            $data['email_templates_info'] = Email_templates::get();
            $data['id'] = isset($request->id) ? $request->id : 0;
            $response_array['data']['html'] = view('vendor::settings.notification-list', compact('data'))->render();
            return response()->json($response_array);
        }
    }
   /**
     * this function is use to update cms for vendor side.
     */
    public function cms(Request $request)
    {
        if ($request->ajax()) {
            $response_array = array('status' => false, 'message' => null, 'data' => null);
            $request->validate([
                'title' => 'required|max:255',
                'description' => 'required',
            ]);
            $data = array(
                'vendor_id' => Auth::id(),
                'title' => $request->title,
                'description' => $request->description,
            );
            if ($request->id > 0) {
                VendorCms::where('id', $request->id)->update($data);
                $response_array['message'] = 'Cms updated successfully.';
            } else {
                VendorCms::create($data);
                $response_array['message'] = 'Cms added successfully.';
            }
            $response_array['status'] = true;
            $response_array['message'] = 'Page updated successfully.';
            return response()->json($response_array);
        }
        $data = array();
        $data['cms_pages_info'] = VendorCms::where('vendor_id',Auth::id())->get();
        return view('vendor::settings.cms', compact('data'));
    }
    /**
     * this function is use to listing cms for vendor side.
     * @return Renderable
     */
    public function cmsList(Request $request)
    {
        if ($request->ajax()) {
            $response_array = array('status' => false, 'message' => null, 'data' => null);
            $response_array['status'] = true;
            $data = array();
            $data['cms_pages_info'] = VendorCms::where('vendor_id',Auth::id())->get();
            $data['id'] = isset($request->id) ? $request->id : 0;
            $response_array['data']['html'] = view('vendor::settings.cms-list', compact('data'))->render();
            return response()->json($response_array);
        }
    }

    /**
     * this function is use to update cms for vendor side.
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
                'vendor_id' => Auth::id(),
                'question' => $request->question,
                'answer' => $request->answer,
            );
            if ($request->id > 0) {
                VendorFaq::where('id', $request->id)->update($data);
                $response_array['message'] = 'Faq updated successfully.';
            } else {
                VendorFaq::create($data);
                $response_array['message'] = 'Faq added successfully.';
            }
            $response_array['status'] = true;
            return response()->json($response_array);
        }
        $data = array();
        $data['faq_info'] = VendorFaq::where('vendor_id',Auth::id())->get();
        return view('vendor::settings.faq', compact('data'));
    }
    /**
     * this function is use to listing cms for vendor side.
     */
    public function faqList(Request $request)
    {
        if ($request->ajax()) {
            $response_array = array('status' => false, 'message' => null, 'data' => null);
            $response_array['status'] = true;
            $data = array();
            $data['faq_info'] = VendorFaq::where('vendor_id',Auth::id())->get();
            $data['id'] = isset($request->id) ? $request->id : 0;
            $response_array['data']['html'] = view('vendor::settings.faq-list', compact('data'))->render();
            return response()->json($response_array);
        }
    }
    /**
     * this function is use to listing general for vendor side.
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
        return view('vendor::settings.general', compact('data'));
    }
    /**
     * this function is use to delete faq for vendor side.
     */
    public function faqDelete(Request $request)
    {
        $this->_helper->delete_data('vendor_faqs', array('where' => array('id' => $request->id)));

        $response_array = array(
            'status' => true, 'message' => 'Record deleted successfully.'
        );
        return response()->json($response_array);
    }
    /**
     * this function is use to update bank details for vendor side.
     */
    public function bank(Request $request){
        if ($request->ajax()) {
            $response_array = array('status' => false, 'message' => null, 'data' => null);
            $request->validate([
                'bank_name' => 'required|string|max:255',  // Bank name must be a string and not exceed 255 characters
                'account_no' => 'required|digits:9',       // Account number must be exactly 9 digits
                'code' => 'required|digits:6',             // Code must be exactly 6 digits
            ]);
            $data = array(
                'vendor_id' => Auth::id(),
                'bank_name' => $request->bank_name,
                'account_no' => $request->account_no,
                'code' => $request->code,
            );
            $bankDetail = BankDetails::where('vendor_id', Auth::id())->first();
            if ($bankDetail) {
                $bankDetail->update($data);
                $response_array['status'] = true;
                $response_array['message'] = 'Bank details updated successfully.';
            } else {
                BankDetails::create($data);
                $response_array['status'] = true;
                $response_array['message'] = 'Bank details saved successfully.';
            }
            return response()->json($response_array);
        }
        $bank_data = BankDetails::where('vendor_id', Auth::id())->get();
        return view('vendor::settings.bank',compact('bank_data'));
    }
 
}
