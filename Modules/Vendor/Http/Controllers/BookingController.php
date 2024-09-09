<?php

namespace Modules\Vendor\Http\Controllers;

use App\Email_templates;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Helpers\Helper;
use App\Notification;
use App\VendorAvailability;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use \CarbonPeriod;
use App\User;
use Mail;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $booking_info = getBookingList((object) $request->all());
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
        return view('vendor::booking.index', compact('booking_info', 'filter_data', 'calendar_event'));
    }
    /**
     * This function is used to view booking information
     */
    public function bookingInfo(Request $request)
    {
        if ($request->ajax()) {
            $response_array = array('status' => false, 'message' => null, 'data' => null);
            $id_user_booking = my_decrypt($request->id);
            $booking_info = getBookingInfo($id_user_booking);
            if (!empty($booking_info)) {
                $response_array['status'] = true;
                $response_array['data']['html'] = view('vendor::booking.booking-info', compact('booking_info'))->render();
            } else {
                $response_array['message'] = 'Details not available.';
            }
            return response()->json($response_array);
        }
    }
    /**
     * This function is used to change the booking status
     */
    public function changeBookingStatus(Request $request)
    {
        if ($request->ajax()) {            
            $response_array = array('status' => false, 'message' => null, 'data' => null);
            $helper = new Helper();
            if (in_array($request->status, array_keys(getBookingStatus()))) {
                $id_user_booking = my_decrypt($request->id);
                $booking_info = getBookingInfo($id_user_booking);
                if (!empty($booking_info)) {
                    if (Auth::user()->hasRole('Vendor')) {
                        update_vendor_specific_booking_status($id_user_booking, AUth::id(), $request->status);
                    } else {
                        update_data('user_booking', ['booking_status' => $request->status], array('where' => array('id' => $id_user_booking)));   
                        update_data('user_booking_info', ['item_status' => $request->status], array('where' => array('id_user_booking' => $id_user_booking)));   
                    }                    
                    
                    // for notification
                    $vendorName = $booking_info['booking_info']->details[0]->vendor_info[0]->name;
                    $bookingNumber = $bookingNumber = $booking_info['booking_info']->booking_number;
                    $userId = $booking_info['user_info']->id;
                    $get_user_details = User::where('id', $userId)->get();
                    $email_to = $get_user_details[0]['email'];
                    $get_name = $get_user_details[0]['name'];
                    $get_event_title = $booking_info['event_info']->event_title;
                    $get_event_location = $booking_info['event_info']->event_location;
                    $get_event_date = $booking_info['event_info']->event_date;
                    $get_event_to_date = $booking_info['event_info']->event_to_date;
                    $get_event_time = $booking_info['event_info']->event_time;
                    $get_event_to_time = $booking_info['event_info']->event_to_time;
                    $notification_push_status = $get_user_details[0]['notification_push_status'];
                    $notification_token = $get_user_details[0]['notification_token'];
                    $device_type = $get_user_details[0]['notification_device_type'];
                    $notificationText = '';
                    if ($request->status == 2) {
                        $notification_body = "Booking is accepted by " . $vendorName;
                        $notificationText = 'Booking is accepted by ' . $vendorName . ', booking #' . $bookingNumber;
                        insert_data('notifications', array(
                            'id_user' => $userId,
                            'notification' => $notificationText,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ));
                        if ($notification_push_status == 1) {
                            $helper->sendPushNotification($notification_token, $notificationText, $notification_body);
                        } else {
                            $response_array['message'] = 'Push notification not sent. Notification push status is disabled.';
                        }
                        $get_mail_temp = Email_templates::where('slug', 'booking-confromation')->first();
                        $email_subject = $get_mail_temp['subject'];
                        $email_content = $get_mail_temp['email_content'];
                        $email_content = str_replace("#NAME#", $get_name, $email_content);
                        $email_content = str_replace("#BOOKING_ID#", $bookingNumber, $email_content);
                        $email_content = str_replace("#EVENT_NAME#", $get_event_title, $email_content);
                        $email_content = str_replace("#EVENT_LOCATION#", $get_event_location, $email_content);
                        $email_content = str_replace("#EVENT_DATE#", $get_event_date, $email_content);
                        $email_content = str_replace("#EVENT_TO_DATE#", $get_event_to_date, $email_content);
                        $email_content = str_replace("#EVENT_TIME#", $get_event_time, $email_content);
                        $email_content = str_replace("#EVENT_TO_TIME#", $get_event_to_time, $email_content);
                        try {
                            Mail::send('mail.common', ['email_content' => $email_content], function ($message) use ($email_to, $email_subject) {
                                $message->to($email_to)->subject($email_subject);
                            });
                        } catch (Exception $ex) {
                            // Error message
                            return back()->with('error', $ex->getMessage());
                        }
                    } elseif ($request->status == 3) {
                        //for refund API call 
                        $payment_details = DB::table('payment_token')->where('id', $booking_info['booking_info']->id_payment_token)->get();
                        $paymentData = json_decode($payment_details[0]->payment_info, true);
                        $paymentId = $paymentData['payment']['id'];
                        $amount = $paymentData['payment']['amount_money']['amount'];
                        $currency = $paymentData['payment']['amount_money']['currency'];
                        $refund = refundPayment($paymentId, $amount, $currency);
                    
                        $notification_body = "Booking is rejected by " . $vendorName;
                        $notificationText = 'Booking is rejected by ' . $vendorName . ', booking #' . $bookingNumber;
                        insert_data('notifications', array(
                            'id_user' => $userId,
                            'notification' => $notificationText,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ));
                        if ($notification_push_status == 1) {
                            $helper->sendPushNotification($notification_token, $notificationText, $notification_body);
                        } else {
                            $response_array['message'] = 'Push notification not sent. Notification push status is disabled.';
                        }
                        $get_mail_temp = Email_templates::where('slug', 'booking-rejected')->first();
                        $email_subject = $get_mail_temp['subject'];
                        $email_content = $get_mail_temp['email_content'];
                        $email_content = str_replace("#NAME#", $get_name, $email_content);
                        try {
                            Mail::send('mail.common', ['email_content' => $email_content], function ($message) use ($email_to, $email_subject) {
                                $message->to($email_to)->subject($email_subject);
                            });
                        } catch (Exception $ex) {
                            // Error message
                            return back()->with('error', $ex->getMessage());
                        }
                    }
              
                    $response_array['status'] = true;
                    $response_array['message'] = 'Status updated successfully.';
                } else {
                    $response_array['message'] = 'Details not available.';
                }
            } else {
                $response_array['message'] = 'Invalid details.';
            }
            return response()->json($response_array);
        }
    }
    /**
     * This function is used to exporting booking list
     */
    public function export(Request $req)
    {
        $booking_info = getBookingList();
        // Create the headers.
        $header_args = array('Order ID', 'Customer Name', 'Party Name (Title)', 'Amount',  'Status', 'Date');
        // Prepare the content to write it to CSV file.
        $data = array();
        if (isset($booking_info['row_count']) && $booking_info['row_count'] > 0) {
            foreach ($booking_info['data'] as $value) {
                $temp = array();
                $temp[] = $value->booking_number;
                $temp[] = $value->name;
                $temp[] = $value->event_title;
                $temp[] = format_number($value->total_amount, true);
                $temp[] = getBookingStatus($value->booking_status);
                $temp[] = format_datetime($value->from_date);
                $data[] = $temp;
            }
        }

        if (file_exists('PartyBookr-Booking.csv')) {
            @unlink('PartyBookr-Booking.csv');
        }
        // Start the output buffer.
        ob_start();
        // Set PHP headers for CSV output.
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=PartyBookr-Booking.csv');
        // Clean up output buffer before writing anything to CSV file.
        ob_end_clean();
        // Create a file pointer with PHP.
        $output = fopen('php://output', 'w');
        // Write headers to CSV file.
        fputcsv($output, $header_args);
        // Loop through the prepared data to output it to CSV file.
        foreach ($data as $data_item) {
            fputcsv($output, $data_item);
        }
        // Close the file pointer with PHP with the updated output.
        fclose($output);
        exit;
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('vendor::booking.create');
    }
    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }
    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('vendor::booking.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('vendor::booking.edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
    /**
     * This function is used to store sechedule
     */
    public function addSechedule(Request $request)
    {
        if ($request->id > 0) {
            $save = VendorAvailability::find($request->id);
        } else {
            $save = new VendorAvailability();
        }
        $save->id_vendor = Auth::user()->id;
        $save->title = $request->title;
        $from_date = explode(' to ', $request->from_date);
        $to_date = $from_date[1];
        $from_date = $from_date[0];
        $save->from_date = Carbon::createFromFormat('Y-m-d', $from_date)->format('Y-m-d');
        $save->to_date = Carbon::createFromFormat('Y-m-d', $to_date)->format('Y-m-d');
        $save->from_time = $request->from_time;
        $save->to_time = $request->to_time;
        if ($request->id > 0) {
            $save->update();
            $message = 'schedule updated successfully.';
        } else {
            $save->save();
            $message = 'schedule created successfully.';
        }
        if ($request->ajax()) {
            return response()->json(array('status' => true, 'message' => $message, 'data' => null));
        }
        return view('my_party');
    }
    /**
     * This function is used to listing sechedule
     */
    public function secheduleList(Request $request)
    {
        if ($request->ajax()) {
            $responseArray =  array('status' => true, 'message' => '', 'data' => null);
            $data = VendorAvailability::where('id_vendor', Auth::id())->get();
            $responseArray['data'] = view('vendor::booking.sechedule-listing', compact('data'))->render();
            return response()->json($responseArray);
        }
    }
    /**
     * This function is used to listing my sechedule
     */
    public function mySchedule(Request $request)
    {
        $settings = $request->all();
        $booking_info = getBookingList($settings);
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
        $dates = array();
        $availability = DB::table('vendor_availabilities')->where('id_vendor', Auth::id())->get();
        if (count($availability) > 0) {
            foreach ($availability as $available) {
                $dates = array_merge(get_dates_between_two_dates($available->from_date, $available->to_date), $dates);
            }
        }
        $available_dates = array_unique($dates);
        return view('vendor::my-schedule', compact('booking_info', 'filter_data', 'calendar_event', 'available_dates'));
    }
    /**
     * This function is used to set default time
     */
    public function makeDefaultTime(Request $request)
    {
        $id = $request->id;
        DB::table('vendor_availabilities')->where('id_vendor', Auth::id())->update(['is_active' => 0]);
        DB::table('vendor_availabilities')->where('id_vendor', Auth::id())->where('id', $id)->update(['is_active' => 1]);
        return response()->json(array('status' => true, 'message' => null, 'data' => null));
    }
}
