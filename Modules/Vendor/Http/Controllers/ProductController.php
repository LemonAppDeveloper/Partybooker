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

class ProductController extends Controller
{
    public $_helper;

    public function __construct()
    {
        $this->_helper = new Helper();
    }
    /**
     * this function is use to store products for vendor side.
     */
    public function addUpdateProduct(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'quantity' => 'required|numeric',
            'description' => 'required',
            'price' => 'required|numeric',
            'product_status' => 'required|in:1,2',
        ]);
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
        $response_array = array(
            'status' => true, 'message' => $message
        );
        return response()->json($response_array);
    }
   /**
     * this function is use to delete specific image of product gallery vendor side.
     */
    public function deleteProductImage(Request $request)
    {
        $id = my_decrypt($request->id);
        $sql = 'SELECT id,image_name FROM vendor_product_image WHERE id = "' . $id . '" ';
        $info = $this->_helper->get_data_with_sql($sql);
        if ($info['row_count'] > 0) {
            $info = $info['data'][0];
            $path = public_path() . '/uploads/product/';
            if (file_exists($path . $info->image_name)) {
                @unlink($path . $info->image_name);
            }
            $this->_helper->delete_data('vendor_product_image', array('where' => array('id' => $info->id)));
        }
        $response_array = array(
            'status' => true, 'message' => 'Image removed succesfully.'
        );
        return response()->json($response_array);
    }

    /**
     * This function is used to get Product information
     */
    public function getProduct(Request $request)
    {
        $user = Auth::user();
        $response_array = array('status' => true, 'data' => null, 'message' => null);
        $settings = $request->all();
        $settings['id_users'] = $user->id;
        $vendor_product = getVendorProduct($settings);
        $html = view('vendor::product.list', compact('user', 'vendor_product'))->render();
        $response_array['data'] = array('html' => $html);
        return response()->json($response_array);
    }
    /**
     * This function is used to get Product information
     */
    public function getProductDetail(Request $request)
    {
        $user = Auth::user();
        $response_array = array('status' => true, 'data' => null, 'message' => null);
        $settings = $request->all();
        $settings['id_users'] = $user->id;
        $settings['id'] = my_decrypt($request->id);
        $settings['limit'] = 1;
        $vendor_product = getVendorProduct($settings);
        $html = view('vendor::product.detail', compact('user', 'vendor_product'))->render();
        $response_array['data'] = array('html' => $html);
        return response()->json($response_array);
    }
    /**
     * This function is used to deleteProduct
     */
    public function deleteProduct(Request $request)
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
            $response_array = deleteProduct(my_decrypt($request->id), $user->id);
        }
        return response()->json($response_array);
    }
}
