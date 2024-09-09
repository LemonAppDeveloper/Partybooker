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
use Illuminate\Support\Facades\Crypt;

class VendorController extends Controller
{
    public $_helper;

    public function __construct()
    {
        $this->_helper = new Helper();
    }

    /**
     * Used to get vendor based on filter
     */
    public function get(Request $request)
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);

        try {
            $id_category = isset($request->id_category) ? $request->id_category : '';
            if(empty($id_category)) {
                $id_category = isset($request->category) ? $request->category : '';
            }
            $settings = array(
                // 'limit' => 50,
                'id_category' => $id_category,
                'sort_by' => isset($request->sort_by) ? $request->sort_by : '',
                'rating' => isset($request->rating) ? $request->rating : '',
                'search' => isset($request->search) ? $request->search : '',
                'id_user' => Auth::check() ? Auth::user()->id : null,
                'id_event' => isset($request->id_event) ? $request->id_event : '',
                'location_filter_ignore' => isset($request->location_filter_ignore) ? $request->location_filter_ignore : '',
            );
            $vendor_info = getVendors($settings);
            $helper = new Helper();
            $response_array['status'] =  !empty($vendor_info) ? true : false;
            $response_array['message'] = '';
            $response_array['data'] = array('vendor_info' => $vendor_info);
            return response()->json($response_array);
        } catch (\Exception $e) {
            $response_array['message'] = $e->getMessage();
            return response()->json($response_array);
        }
    }

    /**
     * Used to get vendor details
     */
    public function detail(Request $request)
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required'
            ]);

            if ($validator->fails()) {
                $response_array['status'] = false;
                $response_array['message'] = $validator->errors()->first();
                return response()->json($response_array);
            }

            $settings = array(
                'id' => $request->id,
                'id_user' => Auth::check() ? Auth::user()->id : 0,
                'location_filter_ignore' => 1
            );
            
            $encryptedId = Crypt::encrypt($request->id);
           
            $routeUrl = route('vendor.gallery', ['id' => $encryptedId]);
           
            $vendor_detail = getVendors($settings);

             
            if (!empty($vendor_detail)) {
                $vendor_detail = $vendor_detail[0];

                $response_array['status'] = true;

                $vendor_gallery = getVendorGallery(array('id' => $vendor_detail->id));
                if ($vendor_gallery['row_count'] > 0) {
                    $vendor_gallery = $vendor_gallery['data'];
                } else {
                    $vendor_gallery = null;
                }
                $vendor_plans = getVendorPlans(array('id_users' => $vendor_detail->id, 'is_enable' => 1));
                $vendor_review = getVendorReviews(array('id_vendor' => $vendor_detail->id, 'is_enable' => 1));
                $vendor_product = getVendorProduct(array('id_users' => $vendor_detail->id, 'is_enable' => 1));
                $vendor_attribute = getVendorAttributes(array('id_vendor' => $vendor_detail->id));
                $vendor_faq = getVendorFaq(array('vendor_id' => $vendor_detail->id));
                $vendor_cms = getVendorCms(array('vendor_id' => $vendor_detail->id));

                $response_array['data'] = array('info' => $vendor_detail, 'vendor_gallery' => $vendor_gallery, 'vendor_plans' => $vendor_plans, 'vendor_review' => $vendor_review, 'vendor_product' => $vendor_product, 'vendor_attribute' => $vendor_attribute, 'vendor_faq' => $vendor_faq, 'vendor_cms' => $vendor_cms, 'url' => $routeUrl);
            } else {
                $response_array['message'] = 'Detail not available.';
            }
            return response()->json($response_array);
        } catch (\Exception $e) {
            $response_array['message'] = $e->getMessage();
            return response()->json($response_array);
        }
    }

    /**
     * Used to get plans
     */
    public function getPlan(Request $request)
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);
        $user = Auth::user();
        $settings = $request->all();
        $settings['id_users'] = $user->id;
        $plan_info = getVendorPlans($settings);
        if (!empty($plan_info)) {
            $response_array['status'] = true;
            $response_array['data']['plan_info'] = getVendorPlans($settings);
        } else {
            $response_array['message'] = 'Plan details not available.';
        }
        return response()->json($response_array);
    }

    /**
     * Used to add/update the plan
     */
    public function addUpdatePlan(Request $request)
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);
        $validator = Validator::make($request->all(), [
            'plan_name' => 'required',
            'plan_title' => 'required',
            'plan_sub_title' => 'required',
            'plan_description' => 'required',
            'plan_amount' => 'required|numeric',
            'is_enable' => 'required',
            'device_type' => 'required'
        ]);

        // Check validation failure
        if ($validator->fails()) {
            $response_array['message'] = $validator->errors()->first();
        } else {
            $is_update_request = false;
            if ($request->id > 0) {
                $conditions = array(
                    'table' => 'vendor_plans',
                    'where' => array('id' => $request->id)
                );
                $info = $this->_helper->select_data($conditions);
                if ($info['row_count'] > 0) {
                    $is_update_request = true;
                    $info = $info['data'][0];
                }
            }

            $data = array(
                'id_users' => Auth::user()->id,
                'plan_name' => $request->plan_name,
                'plan_title' => $request->plan_title,
                'plan_sub_title' => $request->plan_sub_title,
                'plan_description' => $request->plan_description,
                'plan_amount' => floatval($request->plan_amount),
                'is_enable' => $request->is_enable,
            );

            if ($request->hasFile('plan_image')) {
                $plan_image = $request->file('plan_image');
                $imageName = time() . '-profile.' . $plan_image->getClientOriginalExtension();
                $path = public_path() . '/uploads/plan/';
                $plan_image->move($path, $imageName);
                if ($is_update_request == true && !empty($info->plan_image) && file_exists($path . $info->plan_image)) {
                    @unlink($path . $info->plan_image);
                }
                $data['plan_image'] = $imageName;
            }
            $data['updated_at'] = now();
            if ($is_update_request == true) {
                $this->_helper->update_data('vendor_plans', $data, array('where' => array('id' => $info->id)));
                $message = 'Record updated succesfully.';
                $response_array['status'] = true;
                $response_array['message'] = $message;
            } else {
                $data['created_at'] = now();
                $this->_helper->insert_data('vendor_plans', $data);
                $message = 'Record added succesfully.';
                $response_array['status'] = true;
                $response_array['message'] = $message;
            }
        }
        return response()->json($response_array);
    }

    /**
     * Used to delete a plans
     */
    public function deletePlan(Request $request)
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
            'device_type' => 'required'
        ]);

        // Check validation failure
        if ($validator->fails()) {
            $response_array['message'] = $validator->errors()->first();
        } else {
            try {
                $user = Auth::user();
                $response_array = deletePlan($request->id, $user->id);
            } catch (Exception $e) {
                $response_array['message'] = $e->getMessage();
                $response_array['message'] = 'Something went wrong from API';
            }
        }
        return response()->json($response_array);
    }

    /**
     * Used to update the description
     */
    public function updateDescription(Request $request)
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);
        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'device_type' => 'required'
        ]);

        // Check validation failure
        if ($validator->fails()) {
            $response_array['message'] = $validator->errors()->first();
        } else {

            $user = Auth::user();
            try {
                $helper = new Helper();
                $sql = 'SELECT id,description FROM vendor WHERE id_users = "' . Auth::user()->id . '"';
                $info = $helper->get_data_with_sql($sql);
                if ($info['row_count'] > 0) {
                    $helper->update_data('vendor', array('description' => $request->description, 'updated_at' => now()), array('where' => array('id_users' => Auth::user()->id)));
                } else {
                    $helper->insert_data('vendor', array('description' => $request->description, 'id_users' => Auth::user()->id, 'created_at' => now(), 'updated_at' => now()));
                }

                $helper->delete_data('vendor_attributes', array('where' => array('id_users' => Auth::user()->id)));
                if (isset($request->attribute_name) && !empty($request->attribute_name)) {
                    $data = array();
                    foreach ($request->attribute_name as $key => $value) {
                        $helper->insert_data('vendor_attributes', array(
                            'id_users' => Auth::user()->id,
                            'attribute_name' => $request->attribute_name[$key],
                            'quantity' => $request->quantity[$key],
                            'created_at' => now(),
                        ));
                    }
                }

                $response_array['status'] = true;
                $response_array['message'] = 'Profile updated succesfully.';
            } catch (Exception $e) {
                $response_array['message'] = $e->getMessage();
                $response_array['message'] = 'Something went wrong from API';
            }
        }
        return response()->json($response_array);
    }

    /**
     * Used to get vendor reviews
     */
    public function getVendorReviews(Request $request)
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);
        $validator = Validator::make($request->all(), [
            'device_type' => 'required',
            'id_vendor' => 'required'
        ]);

        // Check validation failure
        if ($validator->fails()) {
            $response_array['message'] = $validator->errors()->first();
        } else {
            // $user = Auth::user();
            try {
                $customer_reviews = getVendorReviews(array('id_vendor' => $request->id_vendor));
                if (!empty($customer_reviews)) {
                    $response_array['status'] = true;
                    $response_array['data'] = array('review_info' => $customer_reviews);
                } else {
                    $response_array['message'] = 'Reviews not available.';
                }
            } catch (Exception $e) {
                $response_array['message'] = $e->getMessage();
                $response_array['message'] = 'Something went wrong from API';
            }
        }
        return response()->json($response_array);
    }

    /**
     * This function is submit review on vendor
     */
    public function submitReview(Request $request)
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);

        $myfile = fopen("logs.txt", "a") or die("Unable to open file!");
        $txt = "submitReview() " . json_encode($request->all());
        fwrite($myfile, $txt);
        $txt = "\n";
        fwrite($myfile, $txt);
        $txt = "files: " . json_encode($_FILES);
        fwrite($myfile, $txt);
        fclose($myfile);

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'send_as' => 'required',
            'rating' =>  'required|numeric|lt:6|gt:0',
            'review' => 'required|max:255',
            'device_type' => 'required|in:1,2',
        ]);
        // Check validation failure
        if ($validator->fails()) {
            $response_array['message'] = $validator->errors()->first();
        } else {

            $user = Auth::user();

            $id_vendor = $request->id;
            $full_name = $request->send_as == 'anonymous' ? 'Anonymous' : Auth::user()->name;
            $id_user = $request->send_as == 'anonymous' ? null : Auth::user()->id;

            $review_image = array();
            for ($i = 0; $i <= 5; $i++) {
                if ($request->hasFile('review_image_' . $i)) {
                    $file = $request->file('review_image_' . $i);
                        $imageName = time() . rand(1111, 9999) . '.' . $file->getClientOriginalExtension();
                        $path = public_path() . '/uploads/review/';
                        $file->move($path, $imageName);
                        $review_image[] = $imageName;
                } else {
                    break;
                }
            }

            try {
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
            } catch (Exception $e) {
                $response_array['message'] = $e->getMessage();
            }
        }
        return response()->json($response_array);
    }

    /**
     * This function is used to retrieve the favorite list
     */
    public function getMyFavorite(Request $request)
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);
        $info = getMyFavorite();
        if (!empty($info)) {
            $response_array['status'] = true;
            $response_array['data'] = $info;
        } else {
            $response_array['message'] = 'Favorite list is empty.';
        }
        return response()->json($response_array);
    }
}
