<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Category;
use DB;
use Validator;
use App\User;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request){
        $request->merge(['type' => 'admin']);
        $settings = (object) $request->all();
        $settings->onlyConfirmAndPending = 1;
        $booking_info = getBookingList($settings);
        //$request->merge(['onlyConfirm' => 1]);
        $settings = (object) $request->all();
        $settings->onlyConfirm = 1;
        $confirm_info = getBookingList($settings);
        //$request->merge(['onlyPaid' => 2]);
        $settings = (object) $request->all();
        $settings->onlyPaid = 2;
        $paid_info = getBookingList($settings);
        $filter_data = $request->all(); 
        $calendar_event = array();
        if ($booking_info['row_count'] > 0) {
            foreach ($booking_info['data'] as $value) {
                $calendar_event[] = array(
                    'title' => $value->event_title,
                    'start' => $value->from_date,
                    'end' => $value->to_date,
                );
            }
        }
        return view('admin::booking.index', compact('booking_info','confirm_info','paid_info', 'filter_data', 'calendar_event'));
    }
    /**
     * this function is use to show booking details in booking management tab.
     */
    public function bookingInfo(Request $request,$ready_to_pay='')
    {
        if ($request->ajax()) {
           if ($ready_to_pay == 1) {
                $ready_to_pay = 1;
            } else if($ready_to_pay == 2) {
                $ready_to_pay = 2;
            } else {
                $ready_to_pay = 0;
            }
            $response_array = array('status' => false, 'message' => null, 'data' => null);
            $id_user_booking = my_decrypt($request->id);
            $booking_info = getBookingInfo($id_user_booking);
            if (!empty($booking_info)) {
                $response_array['status'] = true;
                $response_array['data']['html'] = view('admin::booking.booking-info', compact('booking_info','ready_to_pay'))->render();
            } else {
                $response_array['message'] = 'Details not available.';
            }
            return response()->json($response_array);
        }
    }
    /**
     * this function is use to update as mark as paid status in booking management tab.
     */
    public function markAsPaid(Request $request){
        if ($request->ajax()) {
            $response_array = array('status' => false, 'message' => null, 'data' => null);
            $id_user_booking = my_decrypt($request->id);
            $booking_info = getBookingInfo($id_user_booking);
            if (!empty($booking_info)) {
                update_data('user_booking', ['mark_as_paid' => 1], array('where' => array('id' => $id_user_booking)));
                $response_array['status'] = true;
                $response_array['message'] = 'Mark as paid updated successfully.';
            } else {
                    $response_array['message'] = 'Details not available.';
            }
        }
        else 
        {
                $response_array['message'] = 'Invalid details.';
        }
        return response()->json($response_array);
    }
}
