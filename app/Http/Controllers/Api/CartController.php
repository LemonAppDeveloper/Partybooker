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
use DB;

class CartController extends Controller
{
    public $_helper;

    public function __construct()
    {
        $this->_helper = new Helper();
    }

    /**
     * This function is used to add to cart
     */
       public function get(Request $request) 
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);

        $party_info = getMyParty(Auth::id());
      
        $default_event = null;
        if (isset($request->id) && $request->id != '') {
            $id = $request->id;
            $default_event = getEventDetail($id);
        }
        
          
        if (empty($default_event)) {
            $default_event = isset($party_info[0]->id) ? getEventDetail($party_info[0]->id) : null;
        }

        if (!empty($default_event)) {  
            $eveny_id = $default_event->id;
           
            $cart_info = getCart(Auth::id(), $eveny_id);
          
            $response_array['status'] = true;
            $response_array['data'] = array(
                'cart_info' => $cart_info,
                'party_info' => $party_info,
                'default_event' => $default_event,
            );
        } else {
            $response_array['message'] = 'You have not created any event yet. Please create one and proceed to book.';
        }
        return response()->json($response_array);
    }

    /**
     * This function is used to add to cart
     */
    public function add(Request $request)
    {
        $request->request_from = 'mobile';
        $response_array = addToCart($request);
        return response()->json($response_array);
    }

    /**
     * This function is used to remove from the cart list
     */
    public function remove(Request $request)
    {
        $request->request_from = 'mobile';
        $response_array = removeFromCart($request);
        return response()->json($response_array);
    }

    /**
     * This function is used to add to shortlist
     */
    public function addToShortlist(Request $request)
    {
        $request->request_from = 'mobile';
        $response_array = addToShortlist($request);
        return response()->json($response_array);
    }

    /**
     * This function is used to add to confirm
     */
    public function addToConfirm(Request $request)
    {
        $request->request_from = 'mobile';
        $response_array = addToConfirm($request);
        return response()->json($response_array);
    }

    /**
     * This function is used to confirm booking
     */
    public function confirmBooking(Request $request)
    {
        $request->request_from = 'mobile';
        $response_array = confirmBooking($request);
        return response()->json($response_array);
    }

    /**
     * This function is used to add to cancel booking
     */
    public function cancelBooking(Request $request)
    {
        $request->request_from = 'mobile';
        $request->id = !is_array($request->id) ? explode(',', $request->id) : $request->id;
        $response_array = cancelBooking($request);
        return response()->json($response_array);
    }


    /**
     * This function is related with the squareup payment gateway to generate the token for a payment
     */
    public function paymentToken(Request $request)
    {
        $request->request_from = 'mobile';
        $response_array = paymentToken($request);
        return response()->json($response_array);
    }
}
