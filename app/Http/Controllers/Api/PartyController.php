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
use Illuminate\Support\Facades\DB;

class PartyController extends Controller
{
    public $_helper;

    public function __construct()
    {
        $this->_helper = new Helper();
    }

    /**
     * This notificaiton is used to get planned party
     */
    public function planned(Request $request)
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);
        $booking_list = getPlannedParty(array('id_users' => Auth::id()));
        if (!empty($booking_list['row_count'])) {
            $response_array['status'] = true;
            $response_array['data'] = $booking_list['data'];
        } else {
            $response_array['data'] = 'Party details not available.';
        }
        return response()->json($response_array);
    }
    /**
     * This function is used to get previous party
     */
    public function previous(Request $request)
    {
        $booking_list = getBookingList((object) array('id_users' => Auth::id(), 'type' => 'user', 'record_type' => 'prev', 'with_detail' => 1));
        $response_array = array('status' => false, 'message' => null, 'data' => null);
        if (!empty($booking_list['row_count'])) {
            $response_array['status'] = true;
            $response_array['data'] = $this->formateResponse($booking_list['data']);
        } else {
            $response_array['data'] = 'Party details not available.';
        }
        return response()->json($response_array);
    }

    /**
     * This function is used to format the response to access the data
     */
    private function formateResponse($data)
    {

        $helper = new Helper();

        $temp = array();
        foreach ($data as $info) {

            if (isset($info->event_info->event_category) && is_numeric($info->event_info->event_category)) {
                $category_info = $helper->getCategory($info->event_info->event_category);
                $category_name = !empty($category_info) ? $category_info[0]->category_name : $info->event_info->event_category;
            } else {
                $category_name = $info->event_info->event_category;
            }

            $temp[] = array(
                'id' => $info->id,
                'event_id'=>  isset($info->event_info->id) ? $info->event_info->id : '',
                'event_title' => isset($info->event_info->event_title) ? $info->event_info->event_title : '',
                'booking_status' => isset($info->booking_status) && $info->booking_status == 2 ? 'conform' : 'pending',
                'booking_status_title' => getBookingStatus($info->booking_status),
                'booking_status_color' => $info->booking_status_color,
                'booking_number' => $info->booking_number,
                'vendor_name' => isset($info->booking_info->details[0]->vendor_info[0]->name) ? $info->booking_info->details[0]->vendor_info[0]->name : '',
                'date_time' => (isset($info->booking_info->from_date) ? $info->booking_info->from_date : '') . ' - ' . (isset($info->booking_info->to_date) ? $info->booking_info->to_date : ''),
                'category' => isset($info->event_info->event_category) ? $info->event_info->event_category : '',
                'category_name' => isset($category_name) ? $category_name : '',
                'amount' => env('CURRENCY_SYMBOL') . $info->total_amount,
                'payment_status' => isset($info->payment_status) ? $info->payment_status : null,
                'payment_status_title' => isset($info->payment_status) && $info->payment_status == 2 ? 'Paid' : getBookingStatus($info->payment_status),
                'payment_status_color' => $info->payment_status_color,
            );
        }
        return $temp;
    }
}
