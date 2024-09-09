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

class ProductController extends Controller
{
    public $_helper;

    public function __construct()
    {
        $this->_helper = new Helper();
    }

    /**
     * This function is used to get the product list
     */
    public function getProduct(Request $request)
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);
        $user = Auth::user();
        $settings = $request->all();
        $settings['id_users'] = $user->id;
        $info = getVendorProduct($settings);
        if (!empty($info)) {
            $response_array['status'] = true;
            $response_array['data']['info'] = $info;
        } else {
            $response_array['message'] = 'Product details not available.';
        }
        return response()->json($response_array);
    }

    /**
     * This function is used to add/update the product
     */
    public function addUpdateProduct(Request $request)
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'quantity' => 'required|numeric',
            'description' => 'required',
            'price' => 'required|numeric',
            'product_status' => 'required|in:1,2',
            'device_type' => 'required'
        ]);

        // Check validation failure
        if ($validator->fails()) {
            $response_array['message'] = $validator->errors()->first();
        } else {
            $is_update_request = false;
            if (!empty($request->id) && my_decrypt($request->id) > 0) {
                $conditions = array(
                    'table' => 'vendor_product',
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
                'title' => $request->title,
                'quantity' => $request->quantity,
                'description' => $request->description,
                'price' => $request->price,
                'product_status' => $request->product_status,
            );

            $product_image = array();
            if ($request->hasFile('product_image')) {
                $files = $request->file('product_image');
                foreach ($files as $file) {
                    $imageName = time() . rand(1111, 9999) . '.' . $file->getClientOriginalExtension();
                    $path = public_path() . '/uploads/product/';
                    $file->move($path, $imageName);
                    $product_image[] = $imageName;
                }
            }


            $data['updated_at'] = now();
            if ($is_update_request == true) {
                $id_vendor_product = $info->id;
                $this->_helper->update_data('vendor_product', $data, array('where' => array('id' => $info->id)));
                $message = 'Record updated succesfully.';
            } else {
                $data['created_at'] = now();
                $id_vendor_product = $this->_helper->insert_data('vendor_product', $data);
                $message = 'Record added succesfully.';
            }

            if ($id_vendor_product > 0 && !empty($product_image)) {
                foreach ($product_image as $image_name) {
                    $data = array(
                        'id_vendor_product' => $id_vendor_product,
                        'image_name' => $image_name,
                        'created_at' => now()
                    );
                    $this->_helper->insert_data('vendor_product_image', $data);
                }
            }
            $response_array['status'] = true;
            $response_array['message'] = $message;
        }
        return response()->json($response_array);
    }

    /**
     * This function is used to delete the product
     */
    public function deleteProduct(Request $request)
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
                $response_array = deleteProduct($request->id, $user->id);
            } catch (Exception $e) {
                $response_array['message'] = $e->getMessage();
                $response_array['message'] = 'Something went wrong from API';
            }
        }
        return response()->json($response_array);
    }
}
