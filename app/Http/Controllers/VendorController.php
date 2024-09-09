<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Auth;
use App\Event;
use App\Helpers\Helper;
use App\VendorCms;
use App\VendorFaq;
use Illuminate\Support\Facades\DB;
//use Mail;

class VendorController extends Controller
{
    /**
     * This function is used to get gallery
     */
    public function gallery(Request $request, $id)
    {
        $id = my_decrypt($id);
        $location_filter_ignore = session('location_filter_ignore');
        $info = getVendors(array('id' => $id, 'id_user' => Auth::check() ? Auth::user()->id : 0, 'detail' => 1,'location_filter_ignore' => $location_filter_ignore,'request_from'=>'cart'));
        if (empty($info)) {
            return redirect()->back();
        }
        $faqs = VendorFaq::where('vendor_id', $id)->get();
        $policy = VendorCms::where('vendor_id', $id)->where('slug', 'privacy-policy')->first();
        $termsCondition = VendorCms::where('vendor_id', $id)->where('slug', 'terms-condition')->first();
        return view('vendor-gallery', compact('info', 'faqs', 'policy', 'termsCondition'));
    }

    /**
     * This function is used to submit a review on vendor
     */
    public function submitReview(Request $request)
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'send_as' => 'required',
            'rating' =>  'required|numeric|lt:6|gt:0',
            'review' => 'required|max:255'
        ]);
        // Check validation failure
        if ($validator->fails()) {
            $response_array['message'] = $validator->errors()->messages();
        } else {
            $id_vendor = my_decrypt($request->id);
            $full_name = $request->send_as == 'anonymous' ? 'Anonymous' : Auth::user()->name;
            $id_user = $request->send_as == 'anonymous' ? null : Auth::user()->id;

            $review_image = array();
            if ($request->hasFile('review_image')) {
                $files = $request->file('review_image');
                foreach ($files as $file) {
                    $imageName = time() . rand(1111, 9999) . '.' . $file->getClientOriginalExtension();
                    $path = public_path() . '/uploads/review/';
                    $file->move($path, $imageName);
                    $review_image[] = $imageName;
                }
            }
            $data = array(
                'id_vendor' => $id_vendor,
                'id_user' => $id_user,
                'full_name' => $full_name,
                'rating' => $request->rating,
                'review' => $request->review,
                'review_image' => implode(',', $review_image),
                'review_status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            );
            $helper = new Helper();
            $helper->insert_data('vendor_reviews', $data);
            $response_array['status'] = true;
            $response_array['message'] = 'Review submitted successfully.';
        }
        return response()->json($response_array);
    }

    /**
     * This function is used to get plan
     */
    public function getPlanView(Request $request)
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        // Check validation failure
        if ($validator->fails()) {
            $response_array['message'] = $validator->errors()->first();
        } else {
            $settings = array(
                'id' => my_decrypt($request->id),
                'is_enable' => 1
            );
            $vendor_id = DB::table('vendor_plans')->where('id', $settings['id'])->get();
            $get_van_category = DB::table('vendor')->where('id_users', $vendor_id[0]->id_users)->get('id_sub_category');
            $vendorInfo = DB::table('users')->where('id', $vendor_id[0]->id_users)->get()->first();

            $info = getVendorPlans($settings);
            if (!empty($info)) {
                $info = $info[0];
                $distance = 50;
                $vendorInfo->latitude = empty($vendorInfo->latitude) ? 12.879721 : $vendorInfo->latitude;
                $vendorInfo->longitude = empty($vendorInfo->longitude) ? 121.7740 : $vendorInfo->longitude;

                $sql_vendor = "SELECT id,latitude,longitude,(6371 * acos( cos(radians(" . $vendorInfo->latitude . "))*cos(radians(latitude))*cos(radians(longitude) - radians(" . $vendorInfo->longitude . ") ) + sin(radians(" . $vendorInfo->latitude . "))*sin(radians(latitude)) ) ) As distance FROM events HAVING distance <= " . $distance . " ";
                $near_by_event_id = array();
                $near_by_event = get_data_with_sql($sql_vendor);
                if ($near_by_event['row_count'] > 0) {
                    foreach ($near_by_event['data']  as $value) {
                        $near_by_event_id[] = $value->id;
                    }
                }
                if (!empty($near_by_event_id)) {
                    $events = DB::table('events')->where('id_user', Auth::id())->whereIn('id', $near_by_event_id)->whereDate('event_date', '>=', date('Y-m-d'))->get();
                } else {
                    $events = DB::table('events')->where('id_user', Auth::id())->whereDate('event_date', '>=', date('Y-m-d'))->get();
                }
                $view = view('vendor.plan-view', compact('info', 'events'))->render();
                $response_array['status'] = true;
                $response_array['data'] = array('html' => $view);
            } else {
                $response_array['message'] = 'Plan details not available.';
            }
        }
        return response()->json($response_array);
    }

    /**
     * This function is used to get product detail
     */
    public function getProductView(Request $request)
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        // Check validation failure
        if ($validator->fails()) {
            $response_array['message'] = $validator->errors()->first();
        } else {
            $settings = array(
                'id' => my_decrypt($request->id),
                'product_status' => 1
            );
            $vendor_id = DB::table('vendor_product')->where('id', $settings['id'])->get();
            $get_van_category = DB::table('vendor')->where('id_users', $vendor_id[0]->id_users)->get('id_sub_category');
            $vendorInfo = DB::table('users')->where('id', $vendor_id[0]->id_users)->get()->first();

            $info = getVendorProduct($settings);
            if (!empty($info)) {
                $info = $info[0];
                $distance = 50;
                $vendorInfo->latitude = empty($vendorInfo->latitude) ? 12.879721 : $vendorInfo->latitude;
                $vendorInfo->longitude = empty($vendorInfo->longitude) ? 121.7740 : $vendorInfo->longitude;
                $sql_vendor = "SELECT id,latitude,longitude,(6371 * acos( cos(radians(" . $vendorInfo->latitude . "))*cos(radians(latitude))*cos(radians(longitude) - radians(" . $vendorInfo->longitude . ") ) + sin(radians(" . $vendorInfo->latitude . "))*sin(radians(latitude)) ) ) As distance FROM events HAVING distance <= " . $distance . " ";
                $near_by_event_id = array();
                $near_by_event = get_data_with_sql($sql_vendor);
            
                if ($near_by_event['row_count'] > 0) {
                    foreach ($near_by_event['data']  as $value) {
                        $near_by_event_id[] = $value->id;
                    }
                }
                if (!empty($near_by_event_id)) {
                    $events = DB::table('events')->where('id_user', Auth::id())->whereIn('id', $near_by_event_id)->whereDate('event_date', '>=', date('Y-m-d'))->get();
                } else {
                    $events = DB::table('events')->where('id_user', Auth::id())->whereDate('event_date', '>=', date('Y-m-d'))->get();
                }
                $view = view('vendor.product-view', compact('info', 'events'))->render();
                $response_array['status'] = true;
                $response_array['data'] = array('html' => $view);
            } else {
                $response_array['message'] = 'Product details not available.';
            }
        }
        return response()->json($response_array);
    }


    /**
     * This function is used to share vendor profile
     */
    public function ShareWidget($id)
    {
        $shareComponent = \Share::page(
            url('/vendor/gallery/' . my_encrypt($id)),
            'PartyBookr - Vendor'
        )->facebook()->twitter()->linkedin()->telegram()->whatsapp()->reddit();

        // Render the share component view and return its HTML content
        $shareComponentHtml = View::make('share_component', compact('shareComponent'))->render();

        // Return the HTML content of the share component
        return response()->json(['shareComponentHtml' => $shareComponentHtml]);
    }
}
