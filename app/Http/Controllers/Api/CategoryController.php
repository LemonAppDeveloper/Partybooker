<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\device_tokens;
use App\Helpers\Helper;
use App\User;
use App\Cms_pages;
use App\Category;
use App\Site_settings;
use Illuminate\Support\Facades\Validator;
use Hash;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * This function is used to get category based on settings
     */
     public function category(Request $request)
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);
        $httpCode = 200;
        $message = '';
        if ($request->action == 'get') {
            $path = asset(env('CATEGORY_PATH')) . '/';
            $data =  Category::select('id', 'category_name', Category::raw('CONCAT("' . $path . '",category_icon) AS category_icon'))->where('is_enable', 1)->orderBy('category_name', 'ASC')->get();
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
     * This function is used to get sub category based on settings
     */
   public function subCategory() 
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);
        $helper = new Helper;
        $sub_categories = $helper->getSubCategory();
        $response_array['status'] = true;
        $response_array['data'] = $sub_categories;
        return response()->json($response_array);
    }
}
