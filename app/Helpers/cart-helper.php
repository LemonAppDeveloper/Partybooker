<?php

use App\Email_templates;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helper;
use Illuminate\Support\Facades\DB;
use App\User;
use Square\Models\Money;
use Square\Models\RefundPaymentRequest;
use Square\SquareClient;

/**
 * This function is used to add a product/plan to cart
 * If type of product is there then quantity is required 
 * @param array $rquest
 */
function addToCart($request)
{
    $response_array = array('status' => false, 'message' => null, 'data' => null);
    $validator = Validator::make($request->all(), [
        'id' => 'required',
        'type' => 'required|in:product,plan',
        'quantity' => 'required_if:type,product',
        'event_id' => 'required'
    ], [
        'event_id.required' => 'Choose a party to book an event',
    ]);
    // Check validation failure
    if ($validator->fails()) {
        $response_array['message'] = $validator->errors()->first();
    } else {
        $eventCount = DB::table('events')->where('id_user', Auth()->id())->count();
        if ($eventCount === 0) {
            $response_array['status'] = false;
            $response_array['message'] = 'You haven’t created a party yet, would you like to create one?';
        } else {

            if (!$request->request_from == 'mobile') {
                $id = my_decrypt($request->id);
            } else {
                $id = $request->id;
            }
            $id_vendor = getVendorIdFromPlanProduct($request->type, $id);

            if ($request->type == 'plan') {
                delete_data('cart', array('where' => array('id_vendor_plans' => $id, 'id_users' => Auth::id())));
            } else {
                delete_data('cart', array('where' => array('id_vendor_product' => $id, 'id_users' => Auth::id())));
            }
            $data = array(
                'id_users' => Auth::id(),
                'id_vendor' => $id_vendor,
                'id_event' => $request->event_id,
                'id_vendor_plans' => $request->type == 'plan' ? $id : null,
                'id_vendor_product' => $request->type == 'product' ? $id : null,
                'quantity' => !empty($request->quantity) ? $request->quantity : 1,
                'cart_status' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            );
            $helper = new Helper();
            $helper->insert_data('cart', $data);
            $response_array['status'] = true;
            $response_array['message'] = 'Cart updated successfully.';
            $response_array['data']['redirect_url'] = route('cart') . '/' . my_encrypt($request->event_id);
        }
    }
    return $response_array;
}

/**
 * This function is used to remove a product/plan from cart
 * @param array $rquest
 */
function removeFromCart($request)
{
    $response_array = array('status' => false, 'message' => null, 'data' => null);
    $validator = Validator::make($request->all(), [
        'action' => 'required'
    ]);
    // Check validation failure
    if ($validator->fails()) {
        $response_array['message'] = $validator->errors()->first();
    } else {
        if ($request->action == 'remove') {
            $request->id = is_array($request->id) ? $request->id : explode(',', $request->id);
            foreach ($request->id as $id) {
                if (!$request->request_from == 'mobile') {
                    $id = my_decrypt($id);
                }
                delete_data('cart', array('where' => array('id' => $id, 'id_users' => Auth::id())));
            }

            $response_array['status'] = true;
            $response_array['message'] = 'Cart updated successfully.';
        } else {
            $response_array['message'] = 'Something went wrong.';
        }
    }
    return $response_array;
}

/**
 * This function is used to add the plan/product to shortlist page
 * @param array $request
 */
function addToShortlist($request) //Here shortlist means pending/heckout
{
    $response_array = array('status' => false, 'message' => null, 'data' => null);
    $validator = Validator::make($request->all(), [
        'id.*' => 'required',
    ]);
    // Check validation failure
    if ($validator->fails()) {
        $response_array['message'] = $validator->errors()->first();
    } else {
        foreach ($request->id as $id) {
            if (!$request->request_from == 'mobile') {
                $id = my_decrypt($id);
            }
            update_data('cart', array('cart_status' => 1), array('where' => array('id' => $id, 'id_users' => Auth::id())));
        }

        $response_array['status'] = true;
        $response_array['message'] = 'Cart updated successfully.';
    }
    return $response_array;
}

/**
 * This function is used to add selected plan or product to confirm stage
 * @param array $request
 */
function addToConfirm($request)
{
    $response_array = array('status' => false, 'message' => null, 'data' => null);
    $validator = Validator::make($request->all(), [
        'id.*' => 'required'
    ]);
    // Check validation failure
    if ($validator->fails()) {
        $response_array['message'] = $validator->errors()->first();
    } else {
        foreach ($request->id as $id) {
            if (!$request->request_from == 'mobile') {
                $id = my_decrypt($id);
            }
            update_data('cart', array('cart_status' => 3), array('where' => array('id' => $id, 'id_users' => Auth::id())));
        }
        $response_array['status'] = true;
        $response_array['message'] = 'Cart updated successfully.';
    }
    return $response_array;
}

/**
 * This function is used to confirm the booking
 * @param array $request
 */
function confirmBooking($request)
{
    $response_array = array('status' => false, 'message' => null, 'data' => null);
    $helper = new Helper();
    $validator = Validator::make($request->all(), [
        'id_events' => 'required',
    ]);
    // Check validation failure
    if ($validator->fails()) {
        $response_array['message'] = $validator->errors()->first();
    } else {
        //Mapping selected product from the cart
        $request->id_cart = is_array($request->id_cart) ? $request->id_cart : explode(',', $request->id_cart);
        if (!$request->request_from == 'mobile') {
            $id_cart = array();
            foreach ($request->id_cart as $id_cart_temp) {
                $id_cart[] = my_decrypt($id_cart_temp);
            }
        } else {
            $id_cart = $request->id_cart;
        }
        if (!$request->request_from == 'mobile') {
            $id_events = my_decrypt($request->id_events);
        } else {
            $id_events = $request->id_events;
        }
        $info = select_data(array('table' => 'events', 'where' => array('id_user' => Auth::id(), 'id' => $id_events)));

        if ($info['row_count'] > 0) {
            $event_info = $info['data'][0];
            $cart_info = getCart(AUth::id(), $id_events);
            if (isset($cart_info['shortlist']) && !empty($cart_info['shortlist'])) {
                $user_booking_info = array();
                $total_amount = 0;
                foreach ($cart_info['shortlist'] as $value) {
                    if (in_array($value->id, $id_cart)) {
                        $total_amount_info = 0;
                        if (isset($value->plan_info) && !empty($value->plan_info)) {
                            $total_amount +=  $value->plan_info[0]->plan_amount;
                            $total_amount_info +=  $value->plan_info[0]->plan_amount;
                        } else if (isset($value->product_info) && !empty($value->product_info)) {
                            $total_amount +=  $value->product_info[0]->price * $value->quantity;
                            $total_amount_info +=  $value->product_info[0]->price * $value->quantity;
                        }

                        $user_booking_info[$value->id_vendor][] = array(
                            'id_vendor' => $value->id_vendor,
                            'id_vendor_plans' => $value->id_vendor_plans,
                            'plan_info' => isset($value->plan_info) && !empty($value->plan_info) ? json_encode($value->plan_info[0]) : null,
                            'id_vendor_product' => $value->id_vendor_product,
                            'product_info' => isset($value->product_info) && !empty($value->product_info) ? json_encode($value->product_info[0]) : null,
                            'quantity' => $value->quantity,
                            'total_amount' => $total_amount_info
                        );
                        delete_data('cart', array('where' => array('id_users' => Auth::id(), 'id' => $value->id)));
                    }
                }

                $booking_number = rand(11111, 99999);

                foreach ($user_booking_info as $id_vendor => $value) {

                    $booking_data = array(
                        'id_users' => Auth::id(),
                        'booking_number' => $booking_number,
                        'cardholder_name' => $request->cardholder_name,
                        'card_number' => !empty($request->card_number) ? my_encrypt($request->card_number) : null,
                        'expiry_date' => !empty($request->expiry_date) ? my_encrypt($request->expiry_date) : null,
                        'cvv' => !empty($request->cvv) ? my_encrypt($request->cvv) : null,
                        'id_events' => $event_info->id,
                        'from_date' => $event_info->event_date,
                        'to_date' => $event_info->event_to_date,
                        'total_amount' => $total_amount,
                        'id_payment_token' => $request->id_payment_token,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    );
                    $id_user_booking = insert_data('user_booking', $booking_data);

                    $total_amount_info = 0;
                    foreach ($value as $value_info) {
                        $value_info['id_user_booking'] = $id_user_booking;
                        insert_data('user_booking_info', $value_info);
                        $total_amount_info += $value_info['total_amount'];
                        $vendor_id = $value_info['id_vendor'];
                    }
                    update_data('user_booking', ['total_amount' => $total_amount_info], array('where' => array('id' => $id_user_booking)));
                }
                $user_id = DB::table('user_booking')->where('id', $id_user_booking)->value('id_users');
                $booking_no = DB::table('user_booking')->where('id', $id_user_booking)->value('booking_number');
                $event_id = DB::table('user_booking')->where('id', $id_user_booking)->value('id_events');
                $user = User::where('id', $user_id)->get()->first();
                $email_to = $user->email;
                $get_name = $user->name;
                $event_title = DB::table('events')->where('id', $event_id)->value('event_title');
                $event_location = DB::table('events')->where('id', $event_id)->value('event_location');
                $event_date = DB::table('events')->where('id', $event_id)->value('event_date');
                $event_to_date = DB::table('events')->where('id', $event_id)->value('event_to_date');
                $event_time = DB::table('events')->where('id', $event_id)->value('event_time');
                $event_to_time = DB::table('events')->where('id', $event_id)->value('event_to_time');

                // notification for Vendor
                $user_name = Auth::user()->name;
                $get_vendor_details = User::where('id', $vendor_id)->get();
                $vendor_email = $get_vendor_details[0]['email'];
                $notification_push_status = $get_vendor_details[0]['notification_push_status'];
                $notification_token = $get_vendor_details[0]['notification_token'];
                $device_type = $get_vendor_details[0]['notification_device_type'];

                $notificationText = '';
                $notification_body = "Great news! You've just received a booking from a customer " . $booking_no . ". Please review the details and prepare accordingly. click here to view details";
                $notificationText = 'Booking request by ' . $user_name;
                insert_data('notifications', array(
                    'id_user' => $vendor_id,
                    'notification' => $notificationText,
                    'created_at' => now(),
                    'updated_at' => now(),
                ));
                if ($notification_push_status == 1) {
                    $helper->sendPushNotification($notification_token, $notificationText, $notification_body);
                } else {
                    $response_array['message'] = 'Push notification not sent. Notification push status is disabled.';
                }

                //send mail for User
                $get_mail_temp = Email_templates::where('slug', 'booked-event')->first();
                $email_subject = $get_mail_temp['subject'];
                $email_content = $get_mail_temp['email_content'];
                $email_content = str_replace("#NAME#", $get_name, $email_content);
                $email_content = str_replace("#EVENT_NAME#", $event_title, $email_content);
                $email_content = str_replace("#EVENT_DATE#", $event_date, $email_content);
                $email_content = str_replace("#EVENT_TO_DATE#", $event_to_date, $email_content);
                $email_content = str_replace("#EVENT_TIME#", $event_time, $email_content);
                $email_content = str_replace("#EVENT_TO_TIME#", $event_to_time, $email_content);
                $email_content = str_replace("#EVENT_LOCATION#", $event_location, $email_content);

                try {
                    Mail::send('mail.common', ['email_content' => $email_content], function ($message) use ($email_to, $email_subject) {
                        $message->to($email_to)->subject($email_subject);
                    });
                } catch (Exception $ex) {
                    // Error message
                    return back()->with('error', $ex->getMessage());
                }

                //send mail for Vendor
                $ven_mail_temp = Email_templates::where('slug', 'received-new-booking')->first();
                $ven_email_subject = $ven_mail_temp['subject'];
                $ven_email_content = $ven_mail_temp['email_content'];
                $ven_email_content = str_replace("#BOOKING_NUMBER#", $booking_no, $ven_email_content);
                $ven_email_content = str_replace("#EVENT_NAME#", $event_title, $ven_email_content);
                $ven_email_content = str_replace("#EVENT_DATE#", $event_date, $ven_email_content);
                $ven_email_content = str_replace("#EVENT_TO_DATE#", $event_to_date, $ven_email_content);
                $ven_email_content = str_replace("#EVENT_TIME#", $event_time, $ven_email_content);
                $ven_email_content = str_replace("#EVENT_TO_TIME#", $event_to_time, $ven_email_content);
                $ven_email_content = str_replace("#EVENT_LOCATION#", $event_location, $ven_email_content);

                try {
                    Mail::send('mail.common', ['email_content' => $ven_email_content], function ($message) use ($vendor_email, $ven_email_subject) {
                        $message->to($vendor_email)->subject($ven_email_subject);
                    });
                } catch (Exception $ex) {
                    // Error message
                    return back()->with('error', $ex->getMessage());
                }
                $response_array['status'] = true;
                $response_array['message'] = 'Your booking successful.';
                $response_array['data'] = array('redirect_url' => route('party-confirmed', my_encrypt($id_user_booking)));
            } else {
                $response_array['message'] = 'Your cart is empty.';
            }
        } else {
            $response_array['message'] = 'Something went wrong.';
        }
    }
    return $response_array;
}

/**
 * This function is use to refund payment when reject booking
 * @param array $id_cart
 */
function refundPayment($paymentId, $amount, $currency = 'USD', $reason = 'Refund')
{
    $client = new  SquareClient([
        'accessToken' => env('SQUARE_ACCESS_TOKEN'), // Use environment variable for access token
        'environment' => env('SQUARE_ENVIRONMENT', 'sandbox'), // Use environment variable, default to 'sandbox'
    ]);
    $amountMoney = new Money();
    $amountMoney->setAmount($amount); // Ensure the amount is in the smallest currency unit
    $amountMoney->setCurrency($currency);
    $body = new RefundPaymentRequest(uniqid(), $amountMoney);
    $body->setPaymentId($paymentId);
    $body->setReason($reason);
    $apiResponse = $client->getRefundsApi()->refundPayment($body);
    if ($apiResponse->isSuccess()) {
        return $apiResponse->getResult();
    } else {
        return $apiResponse->getErrors();
    }
}

/**
 * This function is used to confirm the booking
 * @param array $request
 */
function cancelBooking($request)
{
    $response_array = array('status' => false, 'message' => null, 'data' => null);
    $validator = Validator::make($request->all(), [
        'id' => 'required',
    ]);
    // Check validation failure
    if ($validator->fails()) {
        $response_array['message'] = $validator->errors()->first();
    } else {

        $selected_bookings = array();
        if (is_array($request->id)) {
            foreach ($request->id as $id) {
                $id = $request->request_from == 'mobile' ? $id : my_decrypt($id);
                $selected_bookings[] = $id;
                update_data('user_booking', array('booking_status' => 4), array('where' => array('id' => $id)));
            }
        } else {
            $id = $request->request_from == 'mobile' ? $request->id : my_decrypt($request->id);
            $selected_bookings[] = $id;
            update_data('user_booking', array('booking_status' => 4), array('where' => array('id' => $id)));
        }
        foreach ($selected_bookings as $id) {
            $id_payment_token = DB::table('user_booking')->where('id', $id)->value('id_payment_token');
            $payment_details = DB::table('payment_token')->where('id', $id_payment_token)->get();
            $paymentData = json_decode($payment_details[0]->payment_info, true);
            $paymentId = $paymentData['payment']['id'];
            $amount = $paymentData['payment']['amount_money']['amount'];
            $currency = $paymentData['payment']['amount_money']['currency'];
            $refund = refundPayment($paymentId, $amount, $currency);

            $user_id = DB::table('user_booking')->where('id', $id)->value('id_users');
            $event_id = DB::table('user_booking')->where('id', $id)->value('id_events');
            if (!empty($user_id)) {
                $user = User::where('id', $user_id)->get()->first();
                $email_to = $user->email;
                $get_name = $user->name;
                $event_title = DB::table('events')->where('id', $event_id)->value('event_title');
                $event_location = DB::table('events')->where('id', $event_id)->value('event_location');
                $event_date = DB::table('events')->where('id', $event_id)->value('event_date');
                $event_to_date = DB::table('events')->where('id', $event_id)->value('event_to_date');
                $event_time = DB::table('events')->where('id', $event_id)->value('event_time');
                $event_to_time = DB::table('events')->where('id', $event_id)->value('event_to_time');

                $get_mail_temp = Email_templates::where('slug', 'booking-rejected')->first();
                $email_subject = $get_mail_temp['subject'];
                $email_content = $get_mail_temp['email_content'];
                $email_content = str_replace("#NAME#", $get_name, $email_content);
                $email_content = str_replace("#EVENT_NAME#", $event_title, $email_content);
                $email_content = str_replace("#EVENT_DATE#", $event_date, $email_content);
                $email_content = str_replace("#EVENT_TO_DATE#", $event_to_date, $email_content);
                $email_content = str_replace("#EVENT_TIME#", $event_time, $email_content);
                $email_content = str_replace("#EVENT_TO_TIME#", $event_to_time, $email_content);
                $email_content = str_replace("#EVENT_LOCATION#", $event_location, $email_content);

                try {
                    Mail::send('mail.common', ['email_content' => $email_content], function ($message) use ($email_to, $email_subject) {
                        $message->to($email_to)->subject($email_subject);
                    });
                } catch (Exception $ex) {
                    // Error message 
                }
            }
        }
        $response_array['status'] = true;
        $response_array['message'] = 'Booking cancelled successfully.';
    }
    return $response_array;
}

/**
 * This function is used to get booking status & Payment status both are same
 * @param string status
 */
function getBookingStatus($status = '')
{
    $array = array(
        1 => 'Pending',
        2 => 'Confirmed',
        3 => 'Rejected',
        4 => 'Cancelled',
        5 => 'Completed'
    );
    if ($status != '') {
        return $array[$status];
    } else {
        return $array;
    }
}

/**
 * This function is used to get booking status & Payment status both are same
 * @param string status
 */
function getBookingStatusColor($status = '')
{
    $array = array(
        1 => '#F64D47',
        2 => '#04D833',
        3 => '#F64D47',
        4 => '#F64D47',
        5 => '#F64D47',
    );
    if ($status != '') {
        return $array[$status];
    } else {
        return $array;
    }
}

/**
 * This function is used to get booking info & event details, vendor plan and product
 * @param string status
 */
function getBookingInfo($id)
{
    $sql = 'SELECT * FROM user_booking WHERE id = "' . $id . '" ';
    $info = get_data_with_sql($sql);
    if ($info['row_count'] > 0) {
        $booking_info = $info['data'][0];
        $booking_info->details = array();
        $event_info = getEventDetail($booking_info->id_events);
        $user_info = getUser($booking_info->id_users);
        $sql = 'SELECT * FROM user_booking_info WHERE id_user_booking = "' . $id . '" ';
        $info = get_data_with_sql($sql);
        if ($info['row_count'] > 0) {
            foreach ($info['data'] as &$value) {
                $value->vendor_info = getVendors(array('id' => $value->id_vendor, 'request_from' => 'cart'));
                $value->bank_info = DB::table('bank_details')->where('vendor_id', $value->id_vendor)->get();
                $value->plan_info = !empty($value->id_vendor_plans) ? getVendorPlans(array('id' => $value->id_vendor_plans)) : null;
                $value->product_info = !empty($value->id_vendor_product) ? getVendorProduct(array('id' => $value->id_vendor_product)) : null;
            }
            unset($value);
            $booking_info->details = $info['data'];
        }
        return array('booking_info' => $booking_info, 'event_info' => $event_info, 'user_info' => $user_info);
    } else {
        return false;
    }
}
/**
 * This function is used to get booking details admin and vendor panel
 * @param string status
 */
function getBookingList($settings = null)
{
    $sub_query = '';
    if (isset($settings->search) && strlen(trim($settings->search)) > 0) {
        $sub_query .= ' AND (u.name LIKE "%' . $settings->search . '%" OR u.email LIKE "%' . $settings->search . '%" OR ub.booking_number LIKE "%' . $settings->search . '%"  OR e.event_title LIKE "%' . $settings->search . '%" ) ';
    }
    if (isset($settings->payment_status) && !empty($settings->payment_status) && in_array($settings->payment_status, array_values(array_keys(getBookingStatus())))) {
        $sub_query .= ' AND ub.payment_status = "' . intval($settings->payment_status) . '" ';
    }
    if (isset($settings->booking_status) && !empty($settings->booking_status) && in_array($settings->booking_status, array_values(array_keys(getBookingStatus())))) {
        $sub_query .= ' AND ub.booking_status = "' . intval($settings->booking_status) . '" ';
    }
    if (isset($settings->onlyConfirm) && !empty($settings->onlyConfirm) && in_array($settings->onlyConfirm, array_values(array_keys(getBookingStatus())))) {
        $sub_query .= ' AND ub.booking_status = 5 AND ub.mark_as_paid != 1'; // AND ub.to_date < now()
    }
    if (isset($settings->onlyPaid) && !empty($settings->onlyPaid) && in_array($settings->onlyPaid, array_values(array_keys(getBookingStatus())))) {
        $sub_query .= ' AND ub.mark_as_paid = 1';
    }
    if (isset($settings->onlyConfirmAndPending) && !empty($settings->onlyConfirmAndPending)) {
        $sub_query .= ' AND ub.booking_status IN (1,2)'; // AND ub.to_date < now()
    }
    if (isset($settings->id_users) && !empty($settings->id_users)) {
        $sub_query .= ' AND ub.id_users = "' . intval($settings->id_users) . '" ';
    }
    if (isset($settings->record_type) && $settings->record_type == 'prev') {
        $sub_query .= ' AND ub.from_date < "' . date('Y-m-d') . '" ';
    }
    if (isset($settings->record_type) && $settings->record_type == 'next') {
        $sub_query .= ' AND ub.from_date >= "' . date('Y-m-d') . '" ';
    }
    if (isset($settings->filter_option) && strlen(trim($settings->filter_option)) > 0 && in_array($settings->filter_option, array('with_product', 'only_package'))) {
        if ($settings->filter_option == 'with_product') {
            $sub_query .= ' AND ubi.id_vendor_product > 0 ';
        } else if ($settings->filter_option == 'only_package') {
            $sub_query .= ' AND ubi.id_vendor_product IS NULL ';
        } else if ($settings->filter_option == 'only_product') {
            $sub_query .= ' AND ubi.id_vendor_plan IS NULL ';
        }
    }
    if (isset($settings->id_event) && $settings->id_event > 0) {
        $sub_query .= ' AND e.id = "' . $settings->id_event . '" ';
    }

    $order_by = '';
    if (isset($settings->order_by) && !empty($settings->order_by)) {
        $order_by = ' ORDER BY ' . $settings->order_by . ' DESC';
    }

    if (isset($settings->type) && $settings->type == 'user') {
        $sql = 'SELECT ub.*,e.event_title,u.name,u.email FROM user_booking ub,events e,users u,user_booking_info ubi WHERE ub.id_users = u.id AND ub.id_events = e.id AND ubi.id_user_booking = ub.id ' . $sub_query . ' GROUP BY ubi.id_user_booking ' . $order_by;
    } else if (isset($settings->type) && $settings->type == 'admin') {
        $sql = 'SELECT ub.*, e.event_title, u.name, u.email 
        FROM user_booking ub
        JOIN events e ON ub.id_events = e.id
        JOIN users u ON ub.id_users = u.id
        JOIN user_booking_info ubi ON ubi.id_user_booking = ub.id
        ' . $sub_query . '
        GROUP BY ubi.id_user_booking
        ORDER BY ub.created_at DESC';
    } else {
        $sql = 'SELECT ub.*,e.event_title,u.name,u.email FROM user_booking ub,events e,users u,user_booking_info ubi WHERE ub.id_users = u.id AND ub.id_events = e.id AND ubi.id_user_booking = ub.id AND ub.id IN (SELECT id_user_booking FROM user_booking_info WHERE id_vendor = "' . Auth::id() . '" ) ' . $sub_query . ' GROUP BY ub.booking_number ' . $order_by;
    }
    if (isset($settings->with_detail) && $settings->with_detail == 1) {
        $info =  get_data_with_sql($sql);
        if (isset($info['row_count']) && $info['row_count'] > 0) {
            foreach ($info['data'] as &$value) {
                $value->booking_info = getBookingInfo($value->id);
                $value->event_info = getBookingInfo($value->id)['event_info'];
                $value->booking_info = getBookingInfo($value->id)['booking_info'];
                $value->booking_status_color = getBookingStatusColor($value->booking_status);
                $value->payment_status_color = getBookingStatusColor($value->payment_status);
            }
            unset($value);
        }
        return $info;
    } else {
        $info = get_data_with_sql($sql);
        if (isset($info['row_count']) && $info['row_count'] > 0) {
            foreach ($info['data'] as &$value) {
                $value->booking_status_color = getBookingStatusColor($value->booking_status);
                $value->payment_status_color = getBookingStatusColor($value->payment_status);
            }
            unset($value);
        }
        return $info;
    }
}

/**
 * This function is used to get selected shortlisted product/plan information
 * @param array $id_cart
 */
function getCartShortlistTotal($id_cart = array())
{
    $event_id = null;
    $sql = 'SELECT id_event FROM cart WHERE id IN (' . implode(',', $id_cart) . ') ';
    $info = get_data_with_sql($sql);
    if (isset($info['row_count']) && $info['row_count'] > 0) {
        $info = $info['data'][0];
        $event_id = $info->id_event;
    }
    $cart_info = getCart(AUth::id(), $event_id);
    $total_amount = 0;
    if (isset($cart_info['shortlist']) && !empty($cart_info['shortlist'])) {
        foreach ($cart_info['shortlist'] as $value) {
            if (in_array($value->id, $id_cart)) {
                if (isset($value->plan_info) && !empty($value->plan_info)) {
                    $total_amount +=  $value->plan_info[0]->plan_amount;
                } else if (isset($value->product_info) && !empty($value->product_info)) {
                    $total_amount +=   $value->product_info[0]->price * $value->quantity;
                }
            }
        }
    }
    return $total_amount;
}
/**
 * This function is create payment token for product/plan
 * @param array $id_cart
 */
function paymentToken($request)
{
    $response_array = array('status' => false, 'message' => null, 'data' => null);
    $validator = Validator::make($request->all(), [
        'sourceId' => 'required',
    ]);
    // Check validation failure
    if ($validator->fails()) {
        $response_array['message'] = $validator->errors()->first();
    } else {
        $request->verificationToken = isset($request->verificationToken) ? $request->verificationToken : rand(11111, 99999);
        $request->id_cart = is_array($request->id_cart) ? $request->id_cart : explode(',', $request->id_cart);
        if (!$request->request_from == 'mobile') {
            $id_cart = array();
            foreach ($request->id_cart as $id_cart_temp) {
                $id_cart[] = my_decrypt($id_cart_temp);
            }
        } else {
            $id_cart = $request->id_cart;
        }
        $total_amount = getCartShortlistTotal($id_cart);
        if ($total_amount > 0) {
            $data = array(
                'amount_money' => array(
                    'amount' => intval($total_amount) * 100,
                    'currency' => env('SQUARE_CURRENCY')
                ),
                "idempotency_key" => generate_idempotency_key(),
                "source_id" => $request->sourceId
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, env('SQUARE_URL'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            $headers = array();
            $headers[] = 'Square-Version: ' . env('SQUARE_API_VERSION');
            $headers[] = 'Authorization: Bearer ' . env('SQUARE_ACCESS_TOKEN');
            $headers[] = 'Content-Type: application/json';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                $response_array['message'] = 'Error:' . curl_error($ch);
            } else {
                $result = json_decode($result, true);
                if ($result) {
                    $payment_status = isset($result['payment']['status']) ? $result['payment']['status'] : '';
                    if ($payment_status == 'COMPLETED') {
                        $payment_token = array(
                            'id_users' => Auth::id(),
                            'source_id' => $request->sourceId,
                            'verification_token' => $request->verificationToken,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                            'payment_status' => 1,
                            'payment_info' => json_encode($result)
                        );
                        $payment_token_id = insert_data('payment_token', $payment_token);
                        $response_array['status'] = true;
                        $response_array['message'] = 'Payment processed successfully.';
                        $response_array['data'] = array(
                            'id' => $payment_token_id
                        );
                    } else {
                        $payment_token = array(
                            'id_users' => Auth::id(),
                            'source_id' => $request->sourceId,
                            'verification_token' => $request->verificationToken,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                            'payment_status' => 2,
                            'payment_info' => json_encode($result)
                        );
                        $payment_token_id = insert_data('payment_token', $payment_token);
                        $response_array['status'] = false;
                        $response_array['message'] = 'Unable to process payment.';
                    }
                }
            }
            curl_close($ch);
        } else {
            $response_array['status'] = false;
            $response_array['message'] = 'Invalid payment amount.';
        }
    }
    echo json_encode($response_array);
    exit;
}



function get_card_last_4($id_payment_token)
{
    $sql = 'SELECT * FROM payment_token WHERE id = "' . $id_payment_token . '" ';
    $info = get_data_with_sql($sql);
    if ($info['row_count'] > 0) {
        $booking_info = $info['data'][0];
        $booking_info = !empty($booking_info->payment_info) ? json_decode($booking_info->payment_info, true) : '';
        return isset($booking_info['payment']['card_details']['card']['last_4']) ? $booking_info['payment']['card_details']['card']['last_4'] : '';
    } else {
        return null;
    }
}

function get_total_amount_from_info($booking_number)
{
    $sql = 'SELECT SUM(total_amount) AS total_amount FROM user_booking_info WHERE id_user_booking IN (SELECT id FROM user_booking WHERE booking_number = "' . $booking_number . '" ) ';
    $info = get_data_with_sql($sql);
    return $info['row_count'] > 0 ? $info['data'][0]->total_amount : 0;
}
