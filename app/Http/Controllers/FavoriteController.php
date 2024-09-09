<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;
use App\Event;
use App\Helpers\Helper;
//use Mail;

class FavoriteController extends Controller
{
    /**
     * This function is used to retrieve a favorite list
     */
    public function index(Request $request, $id_category = null)
    {
        $helper = new Helper();
        $category = $helper->getCategory();
        $settings = array();
        if (!empty($id_category)) {
            $settings['id_category'] = my_decrypt($id_category);
        }
        $getMyFavorite = getMyFavorite($settings);
        $party_info = getMyParty(Auth::id());
        return view('setting.favorite', compact('category', 'getMyFavorite', 'id_category', 'party_info'));
    }

    /**
     * This function is used to update the favorite list
     */
    public function updateFavorite(Request $request)
    {
        $response_array = updateFavorite($request);
        return response()->json($response_array);
    }

    /**
     * This function is used to add to cart from favorite list
     */
    public function favoriteToCart(Request $request)
    {
        $response_array = favoriteToCart($request);
        return response()->json($response_array);
    }
}
