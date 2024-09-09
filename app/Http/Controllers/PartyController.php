<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;
use App\Event;
use App\Helpers\Helper;
use Illuminate\Support\Facades\DB;

class PartyController extends Controller
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
     * This function is used to retrieve planned party list
     */
    public function planned(Request $request)
    {
        $booking_list = getPlannedParty(array('id_users' => Auth::id()));
        return view('setting.party-planned', compact('booking_list'));
    }

    /**
     * This function is used to retrieve previous party list
     */
    public function previous(Request $request)
    {
        $booking_list = getBookingList((object) array('id_users' => Auth::id(), 'type' => 'user', 'record_type' => 'prev', 'with_detail' => 1));
        return view('setting.party-previous', compact('booking_list'));
    }
}
