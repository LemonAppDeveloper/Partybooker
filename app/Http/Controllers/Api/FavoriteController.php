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

class FavoriteController extends Controller
{
    public $_helper;

    public function __construct()
    {
        $this->_helper = new Helper();
    }

    /**
     * This function is used as toggle, add/remove the favorite list
     */
    public function updateFavorite(Request $request)
    {
        $response_array = updateFavorite($request);
        return response()->json($response_array);
    }

    /**
     * This function is used as toggle, add/remove the favorite list
     */
    public function removeFavorite(Request $request)
    {
        $request->type = 'remove';
        $request->request_from = 'mobile';
        $request->id = explode(',', $request->id);
        $response_array = updateFavorite($request);
        return response()->json($response_array);
    }
    /**
     * This function is used my favorite list
     */
    public function getMyFavorite(Request $request)
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);

        $helper = new Helper();
        $category = $helper->getCategory();

        $settings = array();
        if (!empty($request->id_category)) {
            $settings['id_category'] = $request->id_category;
        }
        $response_array['status'] = true;

        $info = getMyFavorite($settings);
        if (!empty($info)) {
        } else {
            $response_array['message'] = 'Favorite list is empty.';
        }
        $response_array['data'] = array(
            'category' => $category,
            'favorite_info' => !empty($info) ? $info : null
        );
        return response()->json($response_array);
    }
    /**
     * This function is used my favorite to cart
     */
    public function favoriteToCart(Request $request)
    {
        $request->request_from = 'mobile';
        $response_array = favoriteToCart($request);
        return response()->json($response_array);
    }
}
