<?php

use Luracast\Restler\Data\Obj;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Log;

/**
 * This function is used to delete plan
 */
function deletePlan($id, $id_users)
{
    $response_array = array('status' => false, 'message' => null, 'data' => null);
    delete_file_from_table('vendor_plans', public_path() . '/uploads/plan/', 'plan_image', array('where' => array('id' => $id, 'id_users' => $id_users)));
    delete_file_from_table('vendor_plan_image', public_path() . '/uploads/plan/', 'image_name', array('where' => array('id_vendor_plan' => $id)));
    delete_data('vendor_plans', array('where' => array('id' => $id, 'id_users' => $id_users)));
    $response_array = array('status' => true, 'message' => 'Delete successful.', 'data' => null);
    return $response_array;
}

/**
 * This function is used to get Vendors
 * @param array $settings
 */
function getVendors($settings = array())
{
 
    $limit = '';
    if (isset($settings['limit'])) {
        $limit = ' LIMIT ' . $settings['limit'];
    }
    $sub_query = '';
    if (array_key_exists('status', $settings)) {
        $sub_query .= ' AND u.status = "' . $settings['status'] . '" ';
    }
    if (array_key_exists('id', $settings)) {
        if (is_array($settings['id'])) {
            $sub_query .= ' AND u.id IN (' . implode(',', $settings['id']) . ') ';
        } else {
            $sub_query .= ' AND u.id = "' . $settings['id'] . '" ';
        }
    }
    if (array_key_exists('id_category', $settings) && $settings['id_category'] > 0) {
        $sub_query .= ' AND u.id IN (SELECT id_users FROM vendor WHERE id_category = "' . $settings['id_category'] . '" ) ';
    }
    if (array_key_exists('search', $settings) && $settings['search'] != '') {
        $sub_query .= ' AND (u.name LIKE "%' . $settings['search'] . '%" OR u.email LIKE "%' . $settings['search'] . '%") ';
    }
    $near_by_vendor_id = array();
    if (array_key_exists('id_user', $settings) && !empty($settings['id_user'])) {
        $sub_query_event = '';
        if (array_key_exists('id_event', $settings) && !empty($settings['id_event'])) {
            $sub_query_event = ' AND id = "' . intval($settings['id_event']) . '" ';
        }
        $sql_user = 'SELECT latitude,longitude FROM events WHERE id_user = "' . $settings['id_user'] . '" ' . $sub_query_event . ' ORDER BY id DESC LIMIT 1';
        $info_lat_long = get_data_with_sql($sql_user);
        if ($info_lat_long['row_count'] > 0) {
            $info_lat_long = $info_lat_long['data'][0];
            $distance = 50;
            $sql_vendor = "SELECT id,latitude,longitude,(6371 * acos( cos(radians(" . $info_lat_long->latitude . "))*cos(radians(latitude))*cos(radians(longitude) - radians(" . $info_lat_long->longitude . ") ) + sin(radians(" . $info_lat_long->latitude . "))*sin(radians(latitude)) ) ) As distance FROM users HAVING distance <= " . $distance . " ";
            $near_by_vendor = get_data_with_sql($sql_vendor);
            if ($near_by_vendor['row_count'] > 0) {
                foreach ($near_by_vendor['data']  as $value) {
                    $near_by_vendor_id[] = $value->id;
                }
            }
        }
    }
   
    $having = '';
    if (array_key_exists('rating', $settings) && $settings['rating'] > 0) {
        $having .= ' HAVING ROUND(avg_rating) = "' . $settings['rating'] . '" ';
    }
    $sort_by = 'u.created_at';
    $sort_order = 'DESC';
    if (array_key_exists('sort_by', $settings) && $settings['sort_by'] != '') {
        if ($settings['sort_by'] == 'oldest') {
            $sort_by = 'u.created_at';
            $sort_order = 'ASC';
        } else if ($settings['sort_by'] == 'most_booked') {
        } else if ($settings['sort_by'] == 'A-Z') {
            $sort_by = 'u.name';
            $sort_order = 'ASC';
        } else if ($settings['sort_by'] == 'Z-A') {
            $sort_by = 'u.name';
            $sort_order = 'DESC';
        }
    }

    $profile_path = URL::to('/') . '/uploads/profile/';

    $user_events = array();
    $apply_vendor_filter = false;
    $selected_event_info = null;
    if (Auth::check()) {
        if (array_key_exists('id_event', $settings) && !empty($settings['id_event'])) {
            $get_user_events = DB::table('events')
                ->where('id_user', Auth::id())->where('id', intval($settings['id_event']))
                ->get();
        } else {
            $get_user_events = DB::table('events')
                ->where('id_user', Auth::id())->orderBy('id', 'desc')->limit(1)
                ->get();
        }
        $selected_event_info = $get_user_events->first();
        if ($get_user_events->count() > 0) {
            $apply_vendor_filter = true;
        }
        foreach ($get_user_events  as   $val) {
            if (intval($val->category) > 0) {
                $user_events[] = $val->category;
            }
        }
    }
    $cargorized_vandor = array();
    if (!empty($user_events)) {
        $temp = array();
        foreach ($user_events as $category) {
            $temp[] = ' FIND_IN_SET(' . $category . ',id_sub_category) ';
        }
        $sql = 'SELECT id_users FROM vendor WHERE  (' . implode(' OR ', $temp) . ') ';
        $info = get_data_with_sql($sql);
        if ($info['row_count'] > 0) {
            $cargorized_vandor = array();
            foreach ($info['data']  as $value) {
                $cargorized_vandor[] = $value->id_users;
            }
        }
    }
    Log::info('$near_by_vendor_id -> ' . json_encode($near_by_vendor_id));
    Log::info('$cargorized_vandor -> ' . json_encode($cargorized_vandor));

    if (array_key_exists('request_from', $settings) && $settings['request_from'] == 'cart') {
        $apply_vendor_filter = false;
    }

    if (array_key_exists('location_filter_ignore', $settings) && ($settings['location_filter_ignore'] === true || $settings['location_filter_ignore'] === 1 || $settings['location_filter_ignore'] === '1')) {
        $apply_vendor_filter = false;
    }

    if ($apply_vendor_filter == true) {
        $id_vendor = array_intersect($near_by_vendor_id, $cargorized_vandor);
       
        $sub_query_vendor = '';
        if (!empty($id_vendor)) {
            $sub_query_vendor = ' AND id_vendor IN (' . implode(',', $id_vendor) . ') ';
        } else {
            //To show not available vendor
            $sub_query_vendor = ' AND id_vendor = 0 ';
        }

        if (!empty($selected_event_info)) {
            $sql = 'SELECT id_vendor FROM vendor_availabilities WHERE ("' . $selected_event_info->event_date . '" BETWEEN from_date AND to_date AND "' . $selected_event_info->event_to_date . '"  BETWEEN from_date AND to_date) '.$sub_query_vendor;
            Log::info('available vendor sql -> ' . $sql);
            $vendor_available = get_data_with_sql($sql);
            if ($vendor_available['row_count'] > 0) {
                $temp = array();
                foreach ($vendor_available['data'] as $data) {
                    $temp[] = $data->id_vendor;
                    Log::info('available vendor id -> ' . $data->id_vendor);
                }
                $sub_query .= ' AND id IN (' . implode(',', $temp) . ') ';
            } else {
                $sub_query .= ' AND id = 0 ';
            }
        }
    }

    $sub_select = ' ,(SELECT AVG(rating) FROM vendor_reviews WHERE id_vendor = u.id) AS avg_rating ';
    $sql = 'SELECT id,`name`,email,profile_image' . $sub_select . ' FROM users u, users_roles ur WHERE ur.user_id = u.id AND ur.role_id = "2" ' . $sub_query . ' ' . $having . ' ORDER BY ' . $sort_by . ' ' . $sort_order . ' ' . $limit;
    Log::info('vendor query: ' . $sql);
    $info = get_data_with_sql($sql);

    if ($info['row_count'] > 0) {
        $path = URL::to('/') . '/uploads/vendor-gallery/';
        foreach ($info['data'] as &$value) {

            $value->profile_image_url = $profile_path;
            if (!empty($value->profile_image)) {
                $value->profile_image_url = $profile_path . $value->profile_image;
            } else {
                $value->profile_image_url = $profile_path . 'default-profile.png';
            }

            //Getting banner URL
            $value->banner_url = asset('assets/images/default-gallery.png');
            $sql = 'SELECT CONCAT("' . $path . '",name) AS banner_url FROM vendor_gallery WHERE id_users = "' . $value->id . '" ORDER BY id ASC LIMIT 1';
            $temp = get_data_with_sql($sql);
            if ($temp['row_count'] > 0) {
                $value->banner_url = $temp['data'][0]->banner_url;
            }
            $value->banner_url = $value->profile_image_url;

            //Getting address and description
            $value->address = '';
            $value->description = '';
            $sql = 'SELECT `address`,`description` FROM vendor WHERE id_users = "' . $value->id . '" ORDER BY id ASC LIMIT 1';
            $temp = get_data_with_sql($sql);
            if ($temp['row_count'] > 0) {
                $value->address = $temp['data'][0]->address;
                $value->description = $temp['data'][0]->description;
            }

            $value->category = '';
            $value->id_category = null;
            $sql = 'SELECT `category_name`,id FROM categories WHERE id = (SELECT id_category FROM vendor WHERE id_users = "' . $value->id . '" ORDER BY id ASC LIMIT 1) ORDER BY id ASC LIMIT 1';
            $temp = get_data_with_sql($sql);
            if ($temp['row_count'] > 0) {
                $value->category = $temp['data'][0]->category_name;
                $value->id_category = $temp['data'][0]->id;
            }

            $value->timing = '';
            $sql = 'SELECT * FROM vendor_availabilities WHERE id_vendor =  "' . $value->id . '" AND is_active = 1 ORDER BY id ASC LIMIT 1';
            $temp = get_data_with_sql($sql);
            if ($temp['row_count'] > 0) {
                $value->timing =   date('h:i A', strtotime($temp['data'][0]->from_time)) . ' - ' . date('h:i A', strtotime($temp['data'][0]->to_time));
            }
            $value->is_favorite = false;

            if (isset($settings['detail']) && $settings['detail'] == 1) {
                $value->vendor_attributes = getVendorAttributes($value->id);
                $value->vendor_plan = getVendorPlans(array('id_users' => $value->id, 'is_enable' => 1));
                $value->vendor_product = getVendorProduct(array('id_users' => $value->id, 'product_status' => 1));
                $value->vendor_gallery = getVendorGallery(array('id' => $value->id));
                $value->vendor_reviews = getVendorReviews(array('is_enable' => 1, 'id_vendor' => $value->id));
            }

            if (isset($settings['with_bank']) && $settings['with_bank'] == 1) {
                $sql = 'SELECT * FROM `bank_details`  WHERE vendor_id = "' . $value->id . '" ';
                $bank_info = get_data_with_sql($sql);
                $value->bank_info = $bank_info['row_count'] > 0 ? $bank_info['data'][0] : array();
            }
        }
        unset($value);
        if (isset($settings['detail']) && $settings['detail'] == 1) {
            return $info['data'][0];
        } else {
            return $info['data'];
        }
    } else {
        return null;
    }
}

/**
 * This function is used to get event detail
 * @param int $id
 * @return array event detail
 */
function getEventDetail($id)
{
    $sql = 'SELECT * FROM events WHERE id = "' . $id . '"';
    $info = get_data_with_sql($sql);
    if ($info['row_count'] > 0) {
        $info = $info['data'][0];
        if (is_numeric($info->event_category)) {
            $helper = new Helper();
            $category_info = $helper->getCategory($info->event_category);
            $info->category_name = !empty($category_info) ? $category_info[0]->category_name : $info->event_category;
        } else {
            $info->category_name = $info->event_category;
        }
        return $info;
    } else {
        return null;
    }
}

/**
 * This function is used to getVendorGallery images
 */
function getVendorGallery($settings = array())
{
    $limit = '';
    if (isset($settings['limit']) && $settings['limit'] > 0) {
        $limit = ' LIMIT  ' . $settings['limit'];
    }
    $path = url('/uploads/vendor-gallery/') . '/';
    $sql = 'SELECT id,CONCAT("' . $path . '",name) AS image_url,name FROM vendor_gallery WHERE id_users = "' . $settings['id'] . '" ORDER BY id DESC ' . $limit;
    return get_data_with_sql($sql);
}

/**
 * This function is used to get Vendor Overview
 * @param int $id
 */
function getVendorOverview($id)
{
    $sql = 'SELECT description FROM vendor WHERE id_users = "' . $id . '" ';
    $info = get_data_with_sql($sql);
    if ($info['row_count'] > 0) {
        return isset($info['data'][0]->description) ? $info['data'][0]->description : '';
    } else {
        return '';
    }
}

/**
 * This function is used to getVendorPlans
 */
function getVendorPlans($settings = array())
{
    $path = URL::to('/') . '/uploads/plan/';

    $sub_query = '';
    $sort_by = '';

    if (isset($settings['id_users'])) {
        $sub_query .= ' AND id_users = "' . $settings['id_users'] . '" ';
    }

    if (isset($settings['id'])) {
        $sub_query .= ' AND id = "' . $settings['id'] . '" ';
    }

    if (array_key_exists('is_enable', $settings) && $settings['is_enable'] != '') {
        $sub_query .= ' AND is_enable = "' . $settings['is_enable'] . '" ';
    }
    if (array_key_exists('filter_by', $settings) && $settings['filter_by'] != '') {
        if ($settings['filter_by'] == 'price_high_to_low') {
            $sort_by = ' ORDER BY plan_amount DESC ';
        } else if ($settings['filter_by'] == 'price_low_to_high') {
            $sort_by = ' ORDER BY plan_amount ASC ';
        } else if ($settings['filter_by'] == 'old_to_new') {
            $sort_by = ' ORDER BY id ASC ';
        } else if ($settings['filter_by'] == 'new_to_old') {
            $sort_by = ' ORDER BY id DESC ';
        }
    }
    $limit = '';
    if (isset($settings['limit'])) {
        $limit = ' LIMIT ' . $settings['limit'];
    }
    $default_image = asset('vendor-assets/images/demo-product.png');
    $sql = 'SELECT id,id_users,plan_name,plan_title,plan_sub_title,plan_description,plan_amount,is_enable,IF(plan_image IS NOT NULL,CONCAT("' . $path . '",plan_image),"' . $default_image . '") AS plan_image_url FROM vendor_plans WHERE 1 = 1 ' . $sub_query . ' ' . $sort_by . $limit;
    $info = get_data_with_sql($sql);
    if ($info['row_count'] > 0) {
        $path = URL::to('/') . '/uploads/plan/';
        foreach ($info['data'] as &$value) {
            //Getting banner URL
            $value->image_url = asset('vendor-assets/images/demo-product.png');
            $sql = 'SELECT CONCAT("' . $path . '",image_name) AS image_url FROM vendor_plan_image WHERE id_vendor_plan = "' . $value->id . '" ORDER BY id DESC LIMIT 1';
            $temp = get_data_with_sql($sql);
            if ($temp['row_count'] > 0) {
                $value->image_url = $temp['data'][0]->image_url;
            }
            $value->plan_image_url = $value->image_url;

            $value->plan_image = null;
            $sql = 'SELECT CONCAT("' . $path . '",image_name) AS image_url,id FROM vendor_plan_image WHERE id_vendor_plan = "' . $value->id . '" ORDER BY id DESC';
            $temp = get_data_with_sql($sql);
            if ($temp['row_count'] > 0) {
                $value->plan_image = $temp['data'];
            }

            $value->is_favorite = isFavorite($value->id, 'plan');
        }
        unset($value);
        if (isset($settings['limit']) && $settings['limit'] == 1) {
            $info['data'] = $info['data'][0];
        }
        return $info['data'];
    } else {
        return null;
    }
}

/**
 * This function is used to getVendorReviews
 */
function getVendorReviews($settings = array())
{
    $sub_query = '';
    if (array_key_exists('is_enable', $settings) && $settings['is_enable'] != '') {
        $sub_query .= ' AND is_enable = "' . $settings['is_enable'] . '" ';
    }
    if (array_key_exists('review_status', $settings) && $settings['review_status'] != '') {
        $sub_query .= ' AND review_status = "' . $settings['review_status'] . '" ';
    }
    $limit = '';
    if (isset($settings['limit'])) {
        $limit = ' LIMIT ' . $settings['limit'];
    }

    $sort_by = '';
    if (array_key_exists('filter_by', $settings) && $settings['filter_by'] != '') {
        if ($settings['filter_by'] == 'highest') {
            $sort_by = ' ORDER BY rating DESC ';
        } else if ($settings['filter_by'] == 'latest') {
            $sort_by = ' ORDER BY created_at DESC ';
        } else if ($settings['filter_by'] == 'oldest') {
            $sort_by = ' ORDER BY created_at ASC ';
        }
    }

    $sql = 'SELECT id,full_name,rating,review,created_at FROM `vendor_reviews` WHERE id_vendor = "' . $settings['id_vendor'] . '" ' . $sort_by . ' ' . $limit;
    $info = get_data_with_sql($sql);
    if ($info['row_count'] > 0) {
        return $info['data'];
    } else {
        return null;
    }
}

/**
 * This function is used to delete event
 */
function deleteEvent($id, $id_user)
{
    return delete_data('events', array('where' => array('id' => $id, 'id_user' => $id_user)));
}


/**
 * This function is used to get vendor product
 */
function getVendorProduct($settings)
{
    $limit = '';
    if (isset($settings['limit'])) {
        $limit = ' LIMIT ' . $settings['limit'];
    }
    $sub_query = '';
    if (array_key_exists('product_status', $settings)) {
        $sub_query .= ' AND product_status = "' . $settings['product_status'] . '" ';
    }
    if (array_key_exists('id', $settings)) {
        $sub_query .= ' AND id = "' . $settings['id'] . '" ';
    }
    if (array_key_exists('id_users', $settings)) {
        $sub_query .= ' AND id_users = "' . $settings['id_users'] . '" ';
    }
    $sql = 'SELECT * FROM vendor_product WHERE 1=1 ' . $sub_query . ' ' . $limit;
    $info = get_data_with_sql($sql);
    if ($info['row_count'] > 0) {
        $path = URL::to('/') . '/uploads/product/';
        foreach ($info['data'] as &$value) {
            //Getting banner URL
            $value->image_url = asset('vendor-assets/images/demo-product.png');
            $sql = 'SELECT CONCAT("' . $path . '",image_name) AS image_url FROM vendor_product_image WHERE id_vendor_product = "' . $value->id . '" ORDER BY id DESC LIMIT 1';
            $temp = get_data_with_sql($sql);
            if ($temp['row_count'] > 0) {
                $value->image_url = $temp['data'][0]->image_url;
            }

            $value->product_image = null;
            $sql = 'SELECT CONCAT("' . $path . '",image_name) AS image_url,id FROM vendor_product_image WHERE id_vendor_product = "' . $value->id . '" ORDER BY id DESC';
            $temp = get_data_with_sql($sql);
            if ($temp['row_count'] > 0) {
                $value->product_image = $temp['data'];
            }

            $value->is_favorite = isFavorite($value->id, 'product');
        }
        unset($value);
        if (isset($settings['limit']) && $settings['limit'] == 1) {
            $info['data'] = $info['data'][0];
        }
        return $info['data'];
    } else {
        return null;
    }
}


/**
 * This function is used to delete plan
 */
function deleteProduct($id, $id_users)
{
    $response_array = array('status' => false, 'message' => null, 'data' => null);

    delete_file_from_table('vendor_product_image', public_path() . '/uploads/product/', 'image_name', array('where' => array('id_vendor_product' => $id)));
    delete_data('vendor_product', array('where' => array('id' => $id, 'id_users' => $id_users)));

    $response_array = array('status' => true, 'message' => 'Delete successful.', 'data' => null);
    return $response_array;
}


/**
 * This function is used to get vendor attributes 
 * @param int $id
 * @return array
 */
function getVendorAttributes($id)
{
    $info = select_data(array('table' => 'vendor_attributes', 'where' => array('id_users' => $id)));
    return $info['row_count'] > 0 ? $info['data'] : null;
}

/**
 * This function is used to get FAQ information
 */
function getVendorFaq($id)
{
    $faq_info = select_data(array('table' => 'vendor_faqs', 'where' => array('vendor_id' => $id)));
    return $faq_info['row_count'] > 0 ? $faq_info['data'] : null;
}

/**
 * This function is used to get vendor CMS pages information
 */
function getVendorCms($id)
{
    $cms_info = select_data(array('table' => 'vendor_cms', 'where' => array('vendor_id' => $id)));
    return $cms_info['row_count'] > 0 ? $cms_info['data'] : null;
}

/**
 * This function is used to get vendor id from vendor product/plan
 */
function getVendorIdFromPlanProduct($type, $id)
{
    if ($type == 'product') {
        $info = select_data(array('table' => 'vendor_product', 'where' => array('id' => $id)));
        return $info['row_count'] > 0 ? $info['data'][0]->id_users : null;
    } else {
        $info = select_data(array('table' => 'vendor_plans', 'where' => array('id' => $id)));
        return $info['row_count'] > 0 ? $info['data'][0]->id_users : null;
    }
}

/**
 * This function is used to get cart information
 */
function getCart($id_users, $event_id = null)
{
    $return = array(
        'pending' => null,
        'shortlist' => null,
        'confirmed' => null,
    );
    $info = select_data(array('table' => 'cart', 'where' => array('id_users' => $id_users, 'id_event' => $event_id, 'cart_status' => 1)));
    $return['pending'] = $info['row_count'] > 0 ? $info['data'] : null;
    $info = select_data(array('table' => 'cart', 'where' => array('id_users' => $id_users, 'id_event' => $event_id, 'cart_status' => 2)));
    $return['shortlist'] = $info['row_count'] > 0 ? $info['data'] : null;
    $info = select_data(array('table' => 'cart', 'where' => array('id_users' => $id_users, 'id_event' => $event_id, 'cart_status' => 3)));

    $return['confirmed'] = $info['row_count'] > 0 ? $info['data'] : null;

    $return['shortlist'] = !empty($return['shortlist']) ? formatCartData($return['shortlist']) : null;

    $pending = array();
    $return['pending'] = getBookingList((object) array('booking_status' => 1, 'id_users' => $id_users, 'type' => 'user', 'id_event' => $event_id));

    if (isset($return['pending']['row_count']) && $return['pending']['row_count'] > 0) {
        foreach ($return['pending']['data'] as $info) {
            $info = getBookingInfo($info->id);
            if (isset($info['booking_info']->details) && !empty($info['booking_info']->details)) {
                foreach ($info['booking_info']->details as $temp) {
                    $temp->price = 0;
                    if (isset($temp->plan_info) && !empty($temp->plan_info)) {
                        $temp->price =  $temp->plan_info[0]->plan_amount;
                    } else {
                        $temp->price = $temp->product_info[0]->price * $temp->quantity;
                    }
                    $temp->id = $temp->id_user_booking;
                    $pending[] = $temp;
                }
            }
        }
    }
    $return['pending'] = !empty($pending) ? $pending : null;

    $confirmed = array();
    $return['confirmed'] = getBookingList((object) array('booking_status' => 2, 'id_users' => $id_users, 'type' => 'user', 'id_event' => $event_id));
    if (isset($return['confirmed']['row_count']) && $return['confirmed']['row_count'] > 0) {
        foreach ($return['confirmed']['data'] as $info) {
            $info = getBookingInfo($info->id);
            if (isset($info['booking_info']->details) && !empty($info['booking_info']->details)) {
                foreach ($info['booking_info']->details as $temp) {
                    $temp->price = 0;
                    if (isset($temp->plan_info) && !empty($temp->plan_info)) {
                        $temp->price =  $temp->plan_info[0]->plan_amount;
                    } else {
                        $temp->price = $temp->product_info[0]->price * $temp->quantity;
                    }
                    $temp->id = $temp->id_user_booking;
                    $confirmed[] = $temp;
                }
            }
        }
    }
    $return['confirmed'] = !empty($confirmed) ? $confirmed : null;
    return $return;
}

/**
 * This function is used to format cart data
 */
function formatCartData($info)
{
    foreach ($info as &$value) {
        $value->vendor_info = getVendors(array('id' => $value->id_vendor, 'request_from' => 'cart'));
        $value->plan_info = !empty($value->id_vendor_plans) ? getVendorPlans(array('id' => $value->id_vendor_plans)) : null;
        $value->product_info = !empty($value->id_vendor_product) ? getVendorProduct(array('id' => $value->id_vendor_product)) : null;
        if (isset($value->product_info[0]->price)) {
            $value->price = $value->quantity * $value->product_info[0]->price;
        } else if (isset($value->vendor_info[0]->plan_amount)) {
            $value->price = $value->plan_amount;
        }
    }
    unset($value);
    return $info;
}

/**
 * This function is used to get customer breakdown
 */
function getCustomerBreakdown($date, $id_vendor)
{
    $date = explode('--', $date);
    $start_date = $date[0];
    $end_date = $date[1];

    $return = array(
        'total' => '--',
        'cancelled' => '--',
        'booked' => '--',
        'ongoing' => '--',
    );

    $sql = 'SELECT COUNT(id) AS total FROM user_booking WHERE `from_date` BETWEEN "' . $start_date . '" AND "' . $end_date . '" AND id IN (SELECT id_user_booking FROM user_booking_info WHERE id_vendor = "' . $id_vendor . '" )';
    $info = get_data_with_sql($sql);
    $return['total'] = $info['row_count'] > 0 && $info['data'][0]->total > 0  ?  $info['data'][0]->total : '--';

    //Cancelled
    $sql = 'SELECT COUNT(id) AS total FROM user_booking WHERE booking_status = "4" AND `from_date` BETWEEN "' . $start_date . '" AND "' . $end_date . '" AND id IN (SELECT id_user_booking FROM user_booking_info WHERE id_vendor = "' . $id_vendor . '" )';
    $info = get_data_with_sql($sql);
    $return['cancelled'] = $info['row_count'] > 0 && $info['data'][0]->total > 0  ?  $info['data'][0]->total : '--';

    //Booked/Confirmed
    $sql = 'SELECT COUNT(id) AS total FROM user_booking WHERE booking_status = "2" AND `from_date` BETWEEN "' . $start_date . '" AND "' . $end_date . '" AND id IN (SELECT id_user_booking FROM user_booking_info WHERE id_vendor = "' . $id_vendor . '" )';
    $info = get_data_with_sql($sql);
    $return['booked'] = $info['row_count'] > 0 && $info['data'][0]->total > 0  ?  $info['data'][0]->total : '--';

    //Booked/Confirmed
    $sql = 'SELECT COUNT(id) AS total FROM user_booking WHERE booking_status NOT IN (4,2,5) AND `from_date` BETWEEN "' . $start_date . '" AND "' . $end_date . '" AND id IN (SELECT id_user_booking FROM user_booking_info WHERE id_vendor = "' . $id_vendor . '" )';
    $info = get_data_with_sql($sql);
    $return['ongoing'] = $info['row_count'] > 0 && $info['data'][0]->total > 0  ?  $info['data'][0]->total : '--';

    return $return;
}

/**
 * This function is used to get the graph in the vendor panel
 */
function getEarningGraph($timeline, $id_plan = 0, $id_vendor = 0)
{
    $data = array();
    $total = 0;
    $month = 12;
    if ($timeline == 'last3') {
        $month = 3;
    } else if ($timeline == 'last6') {
        $month = 6;
    }
    $sub_select = '';
    if (intval($id_plan) > 0) {
        $sub_select = ' AND id_vendor_plans = "' . $id_plan . '" ';
    }

    for ($i = 0; $i < $month; $i++) {
        $start_date = date('Y-m-01', strtotime('-' . $i . ' month'));
        $end_date = date('Y-m-t', strtotime('-' . $i . ' month'));
        $sql = 'SELECT SUM(total_amount) AS total_amount FROM user_booking WHERE booking_status IN (5) AND mark_as_paid = 1 AND `from_date` BETWEEN "' . $start_date . '" AND "' . $end_date . '" AND id IN (SELECT id_user_booking FROM user_booking_info WHERE id_vendor = "' . $id_vendor . '" ' . $sub_select . ')';
        $info = get_data_with_sql($sql);
        $total_amount = $info['row_count'] > 0 ? floatval($info['data'][0]->total_amount) : 0;
        $total += $total_amount;

        $data[] = array(
            'day' => date('Y-M', strtotime('-' . $i . ' month')),
            'Earnings' => $total_amount,
        );
    }
    return array('graph' => $data, 'total' => format_number($total, true));
}

/**
 * This function is used to get location of the user where user register from
 */
function getCountryInfoByIp($ip)
{
    $apiKey = "ad43ee31137d48318ef4ae23a758f28d";
    $url = "https://ipgeolocation.abstractapi.com/v1/?api_key={$apiKey}&ip_address=" . $ip;
    $response = file_get_contents($url);
    if ($response) {
        $data = json_decode($response, true);
        return [
            'ip' => $data['ip'] ?? null,
            'city' => $data['city'] ?? null,
            'country' => $data['country'] ?? null,

        ];
    }
    return null;
}

/**
 * This function is used to update the favorite list
 */
function updateFavorite($request)
{
    $response_array = array('status' => false, 'message' => null, 'data' => null);
    if (!Auth::check()) {
        $response_array['message'] = 'Please login to add favorite list.';
    } else {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'type' => 'required|in:product,plan,remove',
        ]);
        // Check validation failure
        if ($validator->fails()) {
            $response_array['message'] = $validator->errors()->first();
        } else {
            $id = $request->id;
            if ($request->type == 'remove') {
                foreach ($id as $value) {
                    if ($request->request_from != 'mobile') {
                        $value = my_decrypt($value);
                    }
                    delete_data('favorite_list', array('where' => array('id_user' => Auth::id(), 'id' => $value)));
                }
                $response_array['status'] = true;
                $response_array['message'] = 'list updated successfully.';
            } else {
                if (isFavorite($id, $request->type)) {
                    if ($request->type == 'plan') {
                        delete_data('favorite_list', array('where' => array('id_user' => Auth::id(), 'id_vendor_plan' => $id)));
                    } else {
                        delete_data('favorite_list', array('where' => array('id_user' => Auth::id(), 'id_vendor_product' => $id)));
                    }
                    $response_array['status'] = true;
                    $response_array['message'] = $request->type . ' removed from favorite list.';
                    $response_array['data'] = array('is_favorite' => false);
                } else {
                    if ($request->type == 'plan') {
                        insert_data('favorite_list', array('id_user' => Auth::id(), 'id_vendor_plan' => $id, 'created_at' => now(), 'updated_at' => now()));
                    } else {
                        insert_data('favorite_list', array('id_user' => Auth::id(), 'id_vendor_product' => $id, 'created_at' => now(), 'updated_at' => now()));
                    }
                    $response_array['status'] = true;
                    $response_array['message'] = $request->type . ' added to favorite list.';
                    $response_array['data'] = array('is_favorite' => true);
                }
            }
        }
    }
    return $response_array;
}

/**
 * This function is used to add product/plan from favorite list to cart
 * 
 */
function favoriteToCart($request)
{
    $response_array = array('status' => false, 'message' => null, 'data' => null);
    if (!Auth::check()) {
        $response_array['message'] = 'Please login to proceed.';
    } else {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'id_event' => 'required',
        ]);
        // Check validation failure
        if ($validator->fails()) {
            $response_array['message'] = $validator->errors()->first();
        } else {

            if ($request->request_from == 'mobile') {
                $request->id = explode(',', $request->id);
            }

            foreach ($request->id as $id) {
                //echo "<pre>"; print_r($id); exit();
                 
                $id = $request->request_from == 'mobile' ? $id : my_decrypt($id);
                //  echo "<pre>"; print_r($request->id_event); exit();
                if (!is_numeric($request->id_event)) {
                    $id_event = my_decrypt($request->id_event);
                } else {
                    $id_event = $request->id_event;
                }
            
                $favorite_info = select_data(array('table' => 'favorite_list', 'where' => array('id' => $id)));
                    
                if ($favorite_info['row_count'] > 0) {
                  
                    $favorite_info = $favorite_info['data'][0];
                    $type = !empty($favorite_info->id_vendor_plan) ? 'plan' : 'product';
                    $id_type = $type == 'plan'  ? $favorite_info->id_vendor_plan : $favorite_info->id_vendor_product;
                  
                    $id_vendor = getVendorIdFromPlanProduct($type, $id_type);
                     
                   
                    if ($id_vendor > 0) {
                       
                        $data = array(
                            'id_users' => Auth::id(),
                            'id_vendor' => $id_vendor,
                            'id_event' => $id_event,
                            'id_vendor_plans' => $type == 'plan'  ? $favorite_info->id_vendor_plan : null,
                            'id_vendor_product' => $type == 'product'  ? $favorite_info->id_vendor_product : null,
                            'quantity' => 1,
                            'cart_status' => 2,
                            'created_at' => now(),
                            'updated_at' => now(),
                        );
                        insert_data('cart', $data);
                        
                    }
                    delete_data('favorite_list', array('where' => array('id' => $id)));
                }
            }

            $response_array['status'] = true;
            $response_array['message'] = 'Added to shortlist.';
            $response_array['data'] = null;
        }
    }
    return $response_array;
}

/**
 * This function is used to check if the product/plan available in favorite list or not
 */
function isFavorite($id, $type = 'plan')
{
    if (!Auth::check()) {
        return false;
    }
    if ($type == 'plan') {
        $info = select_data(array('table' => 'favorite_list', 'where' => array('id_user' => Auth::id(), 'id_vendor_plan' => $id)));
    } else {
        $info = select_data(array('table' => 'favorite_list', 'where' => array('id_user' => Auth::id(), 'id_vendor_product' => $id)));
    }
    if ($info['row_count'] > 0) {
        return true;
    } else {
        return false;
    }
}

/**
 * This function is used to retrieve the favorite list 
 */
function getMyFavorite($settings = array())
{
    if (!Auth::check()) {
        return false;
    }
    $info = select_data(array('table' => 'favorite_list', 'where' => array('id_user' => Auth::id())));
    if ($info['row_count'] > 0) {
        $data = array();
        foreach ($info['data'] as $key => &$value) {
            $value->plan_info = null;
            $value->product_info = null;
            $value->vendor_info = null;
            if ($value->id_vendor_plan > 0) {
                $value->plan_info = getVendorPlans(array('id' => $value->id_vendor_plan, 'is_enable' => 1));
                if (!empty($value->plan_info)) {
                    $value->plan_info = $value->plan_info[0];
                    $value->vendor_info = getVendors(array('id' => $value->plan_info->id_users, 'id_user' => Auth::check() ? Auth::user()->id : 0, 'request_from' => 'cart'));
                }
            }
            if ($value->id_vendor_product > 0) {
                $value->product_info = getVendorProduct(array('id' => $value->id_vendor_product, 'product_status' => 1));
                if (!empty($value->product_info)) {
                    $value->product_info = $value->product_info[0];
                    $value->vendor_info = getVendors(array('id' => $value->product_info->id_users, 'id_user' => Auth::check() ? Auth::user()->id : 0, 'request_from' => 'cart'));
                }
            }

            if (isset($settings['id_category']) && $settings['id_category'] > 0) {
                if (isset($value->vendor_info[0]->id_category) && $value->vendor_info[0]->id_category == $settings['id_category']) {
                } else {
                    unset($info['data'][$key]);
                }
            }
        }
        unset($value);
        return $info['data'];
    } else {
        return false;
    }
}

/**
 * This function is used to retrieve planned party 
 */
function getPlannedParty($settings = array())
{
    $booking_info = array('row_count' => 0, 'data' => array());
    $id_user = $settings['id_users'];
    $sql = 'SELECT * FROM events WHERE id_user = "' . $id_user . '" ORDER BY event_date ASC';
    $info = get_data_with_sql($sql);
    if ($info['row_count'] > 0) {
        $booking_info['row_count'] = $info['row_count'];
        foreach ($info['data'] as &$value) {
            $array = array(
                "id" => $value->id,
                'id_event' => $value->id,
                "event_title" => $value->event_title,
                "booking_status" => "",
                "booking_status_title" => "",
                "booking_status_color" => "",
                "booking_number" => "",
                "vendor_name" => "",
                "event_location" =>  $value->event_location,
                "date_time" => $value->event_date . " - " . $value->event_to_date,
                "category" => "",
                "category_name" => "",
                "amount" => "",
                "payment_status" => 2,
                "payment_status_title" => "",
                "payment_status_color" => ""
            );
            $sql = 'SELECT * FROM user_booking WHERE id_events = "' . $value->id . '" AND id_users = "' . $id_user . '" AND booking_status IN (1, 2, 3)';
            $booking_info = get_data_with_sql($sql);


            if ($booking_info['row_count'] > 0) {
                $booking_info = $booking_info['data'][0];
                $booking_info = getBookingInfo($booking_info->id);

                if (!empty($booking_info)) {
                    $event_info = $booking_info['event_info'];
                    $booking_info = $booking_info['booking_info'];
                    $booking_array = array(
                        'id' => $booking_info->id,
                        'booking_status' => isset($booking_info->booking_status) && $booking_info->booking_status == 2 ? 'conform' : 'pending',
                        'booking_status_title' => getBookingStatus($booking_info->booking_status),
                        'booking_status_color' => getBookingStatusColor($booking_info->booking_status),
                        'booking_number' => $booking_info->booking_number,
                        'vendor_name' => isset($booking_info->details[0]->vendor_info[0]->name) ? $booking_info->details[0]->vendor_info[0]->name : '',
                        'event_location' => isset($event_info->event_location) ? $event_info->event_location : '',
                        'date_time' => (isset($booking_info->from_date) ? $booking_info->from_date : '') . ' - ' . (isset($booking_info->to_date) ? $booking_info->to_date : ''),
                        'category' => isset($booking_info->event_info->event_category) ? $booking_info->event_info->event_category : '',
                        'category_name' => isset($booking_info->event_info->category_name) ? $booking_info->event_info->category_name : '',
                        'amount' => env('CURRENCY_SYMBOL') . $booking_info->total_amount,
                        'payment_status' => isset($booking_info->payment_status) ? $booking_info->payment_status : null,
                        'payment_status_title' => isset($booking_info->payment_status) && $booking_info->payment_status == 2 ? 'Paid' : getBookingStatus($booking_info->payment_status),
                        'payment_status_color' => getBookingStatusColor($booking_info->payment_status),
                    );
                    $array = array_merge($array, $booking_array);
                }
            }
            $value = (object) $array;
        }
        unset($value);
    }
    return $info;
}


function get_vendor_specific_booking_status($id_user_booking, $id_vendor)
{
    $sql = 'SELECT * FROM user_booking_info WHERE id_user_booking = "' . $id_user_booking . '" AND id_vendor = "' . $id_vendor . '" ';
    $info = get_data_with_sql($sql);
    return $info['row_count'] > 0 ? getBookingStatus($info['data'][0]->item_status) : getBookingStatus(1);
}

function get_vendor_specific_booking_amount($id_user_booking, $id_vendor)
{
    $sql = 'SELECT * FROM user_booking_info WHERE id_user_booking = "' . $id_user_booking . '" AND id_vendor = "' . $id_vendor . '" ';
    $info = get_data_with_sql($sql);
    $info =  $info['row_count'] > 0 ? $info['data'] : array();
    $total_amount = 0;
    foreach ($info as $value) {
        if (isset($value->plan_info) && !empty($value->plan_info)) {
            $plan_info =  json_decode($value->plan_info);
            $total_amount +=  isset($plan_info->plan_amount) ? $plan_info->plan_amount : 0;
        } else if (isset($value->product_info) && !empty($value->product_info)) {
            $product_info =  json_decode($value->product_info);
            $product_info->price = isset($product_info->price) ? $product_info->price : 0;
            $total_amount +=  $product_info->price * $value->quantity;
        }
    }
    return format_number($total_amount, 2);
}


function update_vendor_specific_booking_status($id_user_booking, $id_vendor, $item_status)
{

    update_data('user_booking_info', ['item_status' => $item_status], array('where' => array('id_user_booking' => $id_user_booking, 'id_vendor' => $id_vendor)));

    $sql = 'SELECT * FROM user_booking_info WHERE id_user_booking = "' . $id_user_booking . '" ';
    $info = get_data_with_sql($sql);
    $total_booking_item =  $info['row_count'];

    $sql = 'SELECT * FROM user_booking_info WHERE id_user_booking = "' . $id_user_booking . '" AND item_status = "' . $item_status . '" ';
    $info = get_data_with_sql($sql);
    $total_status_item = $info['row_count'];

    if ($total_booking_item === $total_status_item) {
        update_data('user_booking', ['booking_status' => $item_status], array('where' => array('id' => $id_user_booking)));
    } else {
        update_data('user_booking', ['booking_status' => 1], array('where' => array('id' => $id_user_booking)));
    }
    return true;
}


function get_booking_vendor($id_user_booking)
{
    $sql = 'SELECT * FROM user_booking_info WHERE id_user_booking = "' . $id_user_booking . '" ';
    $info = get_data_with_sql($sql);
    $vendors = $info['row_count'] > 0 ? $info['data'] : array();
    $return_vendors = array();
    foreach ($vendors as $vendor) {
        $return_vendors[] = getVendors(array('id' => $vendor->id_vendor, 'request_from' => 'cart', 'with_bank' => 1));
    }
    return $return_vendors;
}
