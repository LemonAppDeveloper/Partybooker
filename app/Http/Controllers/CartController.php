<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;
use App\Event;
use App\User;
use App\Helpers\Helper;
use DB;

class CartController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * THis function is used to show the cart page with cart and party details
     */
    public function index(Request $request, $id = '')
    {
        $party_info = getMyParty(Auth::id(), true);
        $helper = new Helper();
       
        $default_event = null;
        if ($id != '') {
            $id = my_decrypt($id);
            $default_event = getEventDetail($id);
        }
        if (empty($default_event)) {
            $default_event = isset($party_info[0]->id) ? getEventDetail($party_info[0]->id) : null;
        }
        if (empty($default_event)) {
            return redirect(route('discover'));
        }
        $event_category = $default_event->category;
        $get_vendor = DB::table('vendor')->select('users.name')->join('users', 'users.id', '=', 'vendor.id_users')->whereRaw('FIND_IN_SET(?, vendor.id_sub_category)', [$event_category])->get();
        $event_id = $default_event->id;
        $cart_info = getCart(Auth::id(), $event_id); 
        return view('cart/index', compact('party_info', 'default_event', 'cart_info'));
    }

    /**
     * This function is used to add product/plan in the cart
     */
    public function add(Request $request)
    {
        $response_array = addToCart($request);
        return response()->json($response_array);
    }

    /**
     * This function is used to remove product/plan in the cart
     */
    public function remove(Request $request)
    {
        $response_array = removeFromCart($request);
        return response()->json($response_array);
    }

    /**
     * This function is used to add to shortlist
     */
    public function addToShortlist(Request $request)
    {
        $response_array = addToShortlist($request);
        return response()->json($response_array);
    }

    /**
     * This function is used to add to Confirm
     */
    public function addToConfirm(Request $request)
    {
        $response_array = addToConfirm($request);
        return response()->json($response_array);
    }

    /**
     * This function is used to confirm the booking
     */
    public function confirmBooking(Request $request)
    {
        $response_array = confirmBooking($request);
        return response()->json($response_array);
    }


    /**
     * This function is used to add to shortlist
     */
    public function cancelBooking(Request $request)
    {
        $response_array = cancelBooking($request);
        return response()->json($response_array);
    }

    /**
     * This function is used to confirm the party
     */
    public function partyConfirmed(Request $request, $id)
    {
        $id = my_decrypt($id);
        $booking_info = getBookingInfo($id);
        return view('cart.party-confirmed', compact('booking_info'));
    }

    /**
     * This function is related with the squareup payment gateway to generate the token for a payment
     */
    public function paymentToken(Request $request)
    {
        $response_array = paymentToken($request);
        return response()->json($response_array);
    }
}
