<?php

namespace Modules\Vendor\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\{User};
use Illuminate\Support\Facades\Hash;
use Auth;
use App\Helpers\Helper;
use Validator;

class VendorController extends Controller
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
    public function index(Request $request)
    {
        $path = url('/uploads/vendor-gallery/') . '/';
        $sql = 'SELECT id,CONCAT("' . $path . '",name) AS image_url,name FROM vendor_gallery WHERE id_users = "' . Auth::user()->id . '" ORDER BY id DESC LIMIT 3';
        $images = $this->_helper->get_data_with_sql($sql);
        $settings = (object) $request->all();
        $settings->order_by = ' ub.id ';
        $booking_info = getBookingList($settings);
        $filter_data = $request->all();
        return view('vendor::index', compact('images', 'booking_info', 'filter_data'));
    }
    
    /**
     * this function use to display customer breakdown data.
     * @return array
     */
    public function getCustomerBreakdown(Request $request)
    {
        $response_array['status'] = true;
        $response_array['data'] = getCustomerBreakdown($request->customer_breakdown_time, Auth::id());
        return response()->json($response_array);
    }
    
     /**
     * this function use to display earing graph data.
     * @return array
     */
    public function getEarningGraph(Request $request)
    {
        $response_array['status'] = true;
        $response_array['data'] = getEarningGraph($request->timeline, $request->id_plan, Auth::id());
        return response()->json($response_array);
    }
    
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('vendor::create');
    }
    
    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }
    
    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('vendor::show');
    }
    
    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('vendor::edit');
    }
    
    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }
    
    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
    /**
     * this function use to diplay vendor profile
     */
    public function profile()
    {
        $user = Auth::user();
        $customer_reviews = getVendorReviews(array('id_vendor' => $user->id));
        return view('vendor::profile', compact('user', 'customer_reviews'));
    }
    /**
     * this function use to diplay vendor profile
     */
    public function profileOld()
    {
        $user = Auth::user();
        $customer_reviews = getVendorReviews(array('id_vendor' => $user->id));
        return view('vendor::profile-old', compact('user', 'customer_reviews'));
    }
    /**
     * this function use to update vendor profile
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required'
        ]);
        if (($request->has('lat') && is_null($request->lat)) || ($request->has('lng') && is_null($request->lng))) {
                $response_array = array(
                    'status' => false, 'message' => 'Kindly select the loaction from the dropdown'
                );
                return response()->json($response_array);
        }
        
        $id = $request->user_id;
        $id = Auth::user()->id;
        $updprofile = User::find($id);
        if ($request->hasFile('profile_image')) {
            $profile_image = $request->file('profile_image');
            $imageName = time() . '-profile.' . $profile_image->getClientOriginalExtension();
            $path = public_path() . '/uploads/profile/';
            $profile_image->move($path, $imageName);
            if (!empty($updprofile->profile_image) && file_exists($path . $updprofile->profile_image)) {
                @unlink($path . $updprofile->profile_image);
            }
            $updprofile->profile_image = $imageName;
        }
        $updprofile->name = $request->name;
        $updprofile->email = $request->email;
        $updprofile->location = $request->location;
        
        $updprofile->latitude = $request->lat;
        $updprofile->longitude = $request->lng;
       
   
        $updprofile->save();
        if ($request->id_category > 0) {
            $helper = new Helper();
            $sql = 'SELECT id FROM vendor WHERE id_users = "' . Auth::user()->id . '"';
            $info = $helper->get_data_with_sql($sql);
            if ($info['row_count'] > 0) {
                $helper->update_data('vendor', array('id_category' => $request->id_category), array('where' => array('id_users' => Auth::user()->id)));
            } else {
                $helper->insert_data('vendor', array('id_category' => $request->id_category, 'id_users' => Auth::user()->id, 'created_at' => now(), 'updated_at' => now()));
            }
        }
        if (!empty($request->id_sub_category) && is_array($request->id_sub_category)) {
            $helper = new Helper();
            $subCategoryString = implode(',', $request->id_sub_category);
            $sql = 'SELECT id FROM vendor WHERE id_users = "' . Auth::user()->id . '"';
            $info = $helper->get_data_with_sql($sql);
    
            if ($info['row_count'] > 0) {
                $helper->update_data('vendor', ['id_sub_category' => $subCategoryString], ['where' => ['id_users' => Auth::user()->id]]);
            } else {
                $helper->insert_data('vendor', [
                    'id_sub_category' => $subCategoryString,
                    'id_users' => Auth::user()->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        } else {
            $helper = new Helper();
            $subCategoryString = null;
            $sql = 'SELECT id FROM vendor WHERE id_users = "' . Auth::user()->id . '"';
            $info = $helper->get_data_with_sql($sql);
            if ($info['row_count'] > 0) {
                $helper->update_data('vendor', ['id_sub_category' => $subCategoryString], ['where' => ['id_users' => Auth::user()->id]]);
            }
        }
        $response_array = array(
            'status' => true, 'message' => 'Profile updated succesfully.'
        );
        return response()->json($response_array);
    }
     /**
     * this function use to update description.
     */
    public function updateDescription(Request $request)
    {
        $request->validate([
            'description' => 'required'
        ]);
        $helper = new Helper();
        $sql = 'SELECT id,description FROM vendor WHERE id_users = "' . Auth::user()->id . '"';
        $info = $helper->get_data_with_sql($sql);
        if ($info['row_count'] > 0) {
            $helper->update_data('vendor', array('description' => $request->description, 'updated_at' => now()), array('where' => array('id_users' => Auth::user()->id)));
        } else {
            $helper->insert_data('vendor', array('description' => $request->description, 'id_users' => Auth::user()->id, 'created_at' => now(), 'updated_at' => now()));
        }
        $response_array = array(
            'status' => true, 'message' => 'Description updated succesfully.'
        );
        return response()->json($response_array);
    }

     /**
     * this function use to update vendor attributes for vendor profile.
     */
    public function updateVendorAttributes(Request $request)
    {
        $request->validate([
            'description' => 'required'
        ]);
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
        $response_array = array(
            'status' => true, 'message' => 'Profile updated succesfully.'
        );
        return response()->json($response_array);
    }
    /**
     * this function use to update password for vendor profile.
     */
    public function changePassword(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'password' => 'required|confirmed|min:4',
            'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!\Hash::check($value, $user->password)) {
                    return $fail(__('The current password is incorrect.'));
                }
            }],
        ]);
        $response_array = array('status' => false, 'message' => null, 'data' => null);
        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();
        $response_array['status'] = true;
        $response_array['message'] = 'Password updated successfully.';
        return response()->json($response_array);
    }
    
    /**
     * this function use to update plan management for vendor profile.
     */
    public function addUpdatePlan(Request $request)
    {
        $request->validate([
            'plan_name' => 'required',
            'plan_description' => 'required',
            'plan_amount' => 'required',
        ]);
        $is_update_request = false;
        if (!empty($request->id) && my_decrypt($request->id) > 0) {
            $conditions = array(
                'table' => 'vendor_plans',
                'where' => array('id' => my_decrypt($request->id))
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
            'plan_title' => !empty($request->plan_title) ? $request->plan_title : '',
            'plan_sub_title' => !empty($request->plan_sub_title) ? $request->plan_sub_title : '',
            'plan_description' => $request->plan_description,
            'plan_amount' => floatval($request->plan_amount),
            'is_enable' => $request->is_enable,
        );

        $plan_image = array();
        if ($request->hasFile('plan_image')) {
            $files = $request->file('plan_image');
            foreach ($files as $file) {
                $imageName = time() . rand(1111, 9999) . '.' . $file->getClientOriginalExtension();
                $path = public_path() . '/uploads/plan/';
                $file->move($path, $imageName);
                $plan_image[] = $imageName;
            }
        }
        $data['updated_at'] = now();
        if ($is_update_request == true) {
            $id_vendor_plan = $info->id;
            $this->_helper->update_data('vendor_plans', $data, array('where' => array('id' => $info->id)));
            $message = 'Record updated succesfully.';
        } else {
            $data['created_at'] = now();
            $id_vendor_plan = $this->_helper->insert_data('vendor_plans', $data);
            $message = 'Record added succesfully.';
        }
        if ($id_vendor_plan > 0 && !empty($plan_image)) {
            foreach ($plan_image as $image_name) {
                $data = array(
                    'id_vendor_plan' => $id_vendor_plan,
                    'image_name' => $image_name,
                    'created_at' => now()
                );
                $this->_helper->insert_data('vendor_plan_image', $data);
            }
        }
        $response_array = array(
            'status' => true, 'message' => $message
        );
        return response()->json($response_array);
    }

    /**
     * This function is used to get Plan information
     */
    public function getPlan(Request $request)
    {
        $user = Auth::user();
        $settings = $request->all();
        $settings['id_users'] = $user->id;
        $vendor_plans = getVendorPlans($settings);
        $response_array = array('status' => true, 'data' => null, 'message' => null);
        $html = view('vendor::plan.list', compact('user', 'vendor_plans'))->render();
        $response_array['data'] = array('html' => $html);
        return response()->json($response_array);
    }

    /**
     * This function is used to deletePlan
     */
    public function deletePlan(Request $request)
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        // Check validation failure
        if ($validator->fails()) {
            $response_array['message'] = $validator->errors()->first();
        } else {
            $user = Auth::user();
            $id = my_decrypt($request->id);
            $response_array = deletePlan($id, $user->id);
        }
        return response()->json($response_array);
    }

    /**
     * This function is used to get Plan information
     */
    public function getPlanDetail(Request $request)
    {
        $user = Auth::user();
        $response_array = array('status' => true, 'data' => null, 'message' => null);
        $settings = $request->all();
        $settings['id_users'] = $user->id;
        $settings['id'] = my_decrypt($request->id);
        $settings['limit'] = 1;
        $vendor_plan = getVendorPlans($settings);
        $html = view('vendor::plan.detail', compact('user', 'vendor_plan'))->render();
        $response_array['data'] = array('html' => $html);
        return response()->json($response_array);
    }

    public function deletePlanImage(Request $request)
    {
        $id = my_decrypt($request->id);
        $sql = 'SELECT id,image_name FROM vendor_plan_image WHERE id = "' . $id . '" ';
        $info = $this->_helper->get_data_with_sql($sql);
        if ($info['row_count'] > 0) {
            $info = $info['data'][0];
            $path = public_path() . '/uploads/plan/';
            if (file_exists($path . $info->image_name)) {
                @unlink($path . $info->image_name);
            }
            $this->_helper->delete_data('vendor_plan_image', array('where' => array('id' => $info->id)));
        }
        $response_array = array(
            'status' => true, 'message' => 'Image removed succesfully.'
        );
        return response()->json($response_array);
    }

    
}
