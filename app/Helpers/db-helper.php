<?php

use App\Helpers\Helper;

/**
 * This function is used to get data with plain sql query
 */
function get_data_with_sql($sql)
{
    $return = array('row_count' => 0, 'data' => null);
    $info = DB::select($sql);
    if (count($info) > 0) {
        $return['row_count'] =  count($info);
        $return['data'] =  (array) $info;
    }
    return $return;
}

/**
 * This function is used to select data based on settings
 */
function select_data($conditions = array())
{
    $return = array('row_count' => 0, 'data' => null);
    $object = DB::table($conditions['table']);
    $object->select(isset($conditions['select']) ? $conditions['select'] : '*');
    if (array_key_exists('where', $conditions)) {
        foreach ($conditions['where'] as $column => $value) {
            $object->where($column, $value);
        }
    }
    $info = $object->get();
    if (count($info) > 0) {
        $return['row_count'] =  count($info);
        $return['data'] =  (array) $info->toArray();
    }
    return $return;
}
/**
 * This function is globally used to insert the data in the table
 */
function insert_data($table, $record = array())
{
    $id = DB::table($table)->insertGetId($record);
    return $id;
}

/**
 * This function is used to update the data
 */
function update_data($table, $record, $conditions)
{
    $object = DB::table($table);
    foreach ($conditions['where'] as $column => $value) {
        $object->where($column, $value);
    }
    $object->update($record);
    return true;
}
/**
 * This function is used to delete the data
 */
function delete_data($table, $conditions)
{
    $object = DB::table($table);
    foreach ($conditions['where'] as $column => $value) {
        $object->where($column, $value);
    }
    $object->delete();
    return true;
}

/**
 * This function is used to delete the file from path
 */
function delete_file_from_table($table, $upload_path,  $column_name, $conditions)
{
    $conditions['SELECT'] = $column_name;
    $conditions['table'] = $table;
    $info = select_data($conditions);
    if ($info['row_count'] > 0) {
        foreach ($info['data'] as $value) {
            if (file_exists($upload_path . $value->{$column_name})) {
                @unlink($upload_path . $value->{$column_name});
            }
        }
    }
    return true;
}

/**
 * This function is used to format the date and time
 */
function format_datetime($date)
{
    if (empty($date) || in_array($date, array('0000-00-00', '0000-00-00 00:00:00'))) {
        return '';
    }
    if (strpos(' ', $date) !== false) {
        return date('d-m-Y h:i A', strtotime($date));
    } else {
        return date('d-m-Y', strtotime($date));
    }
}



/**
 * This function is in synchronization of admin section
 */
function my_encrypt($string)
{
    $secret_key = '8N=3M78fdlkses^(*$XYj';
    $secret_iv = 'x(*UHFYTE){8^2%KV]DG';
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
    return $output;
}

/**
 * This function is in synchronization of admin section
 */
function my_decrypt($string)
{
    $secret_key = '8N=3M78fdlkses^(*$XYj';
    $secret_iv = 'x(*UHFYTE){8^2%KV]DG';
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    return $output;
}


/**
 * This function is used to event based on user
 */
function getMyParty($id_user, $is_future_date = false)
{
    $helper = new Helper();
    $sql = 'SELECT * FROM events WHERE id_user = "' . $id_user . '"';
    
    // $sql = 'SELECT e.* FROM events e LEFT JOIN user_booking ub ON e.id = ub.id_events WHERE e.id_user = (SELECT id FROM users WHERE id = "'. $id_user .'") AND ub.id_events IS NULL';
   
    if ($is_future_date) {
        $currentDate = date('Y-m-d');
        $sql .= ' AND event_date >= "' . $currentDate . '"';
    }
    $info =  get_data_with_sql($sql);
    if ($info['row_count'] > 0) {
        $helper = new Helper();
        foreach ($info['data'] as &$value) {
            if (is_numeric($value->event_category)) {
                $category_info = $helper->getCategory($value->event_category);
                $value->category_name = !empty($category_info) ? $category_info[0]->category_name : $value->event_category;
            } else {
                $value->category_name = $value->event_category;
            }
        }
        unset($value);
        return $info['data'];
    } else {
        return null;
    }
}

/**
 * This function formats a number to two decimal places
 *
 * @param float $number
 * @return float
 */
function format_number($number = 0, $symbol = false)
{
    $number = str_replace(",", "", number_format((float)round($number, 2), 2, '.', ''));
    if ($symbol == true) {
        $number = '$' . $number;
    }
    return $number;
}
/**
 * This function is get user details
 */
function getUser($id)
{
    $sql = 'SELECT * FROM users WHERE id = "' . $id . '" ';
    $info = get_data_with_sql($sql);
    if ($info['row_count'] > 0) {
        $info = $info['data'][0];
        $info->path = asset('vendor-assets/images/profile.png');
        if ($info->profile_image != '' && file_exists('uploads/profile/' . $info->profile_image)) {
            $info->path = asset('uploads/profile/' . $info->profile_image);
        }
        return $info;
    } else {
        return false;
    }
}

/**
 * This function is use to date filter
 */
function getDateFilterOption()
{
    $current_date = date('Y-m-d');
    $month = date('Y-m-d', strtotime('-30 days')) . '--' . date('Y-m-d');
    $last_month = date('Y-m-01', strtotime($current_date . ' -1 month')) . '--' . date('Y-m-t', strtotime($current_date . ' -1 month'));
    $last_three_month = date('Y-m-01', strtotime($current_date . ' -3 month')) . '--' . date('Y-m-d');
    $last_six_month = date('Y-m-01', strtotime($current_date . ' -6 month')) . '--' . date('Y-m-d');
    $last_year = date('Y-m-01', strtotime($current_date . ' -1 year')) . '--' . date('Y-m-t', strtotime($current_date . ' -1 year'));

    $array = array(
        $month => date('M, d', strtotime('-30 days')) . '-' . date('M, d'),
        $last_month => "Last Month",
        $last_three_month => "Last 3 Month",
        $last_six_month => "Last 6 Month",
        $last_year => "Last Year",
    );
    return $array;
}


/**
 * This function is use to create slug
 */
function create_slug($text)
{
    // Convert text to lowercase
    $slug = strtolower($text);

    // Replace spaces with dashes
    $slug = preg_replace('/\s+/', '-', $slug);

    // Remove special characters
    $slug = preg_replace('/[^\w\-]+/', '', $slug);

    return $slug;
}


/**
 * This function is used to get dates between two dates
 */
function get_dates_between_two_dates($start_date, $end_date)
{

    // Firstly, format the provided dates.  
    // This function works best with YYYY-MM-DD  
    // but other date formats will work thanks  
    // to strtotime().  
    $start_date = date("Y-m-d", strtotime($start_date));
    $end_date = date("Y-m-d", strtotime($end_date));
    // Start the variable off with the start date  
    $a_days[] = $start_date;

    // Set a 'temp' variable, s_current_date, with  
    // the start date - before beginning the loop  
    $s_current_date = $start_date;

    // While the current date is less than the end date  
    while ($s_current_date < $end_date) {
        // Add a day to the current date  
        $s_current_date = date("Y-m-d", strtotime("+1 day", strtotime($s_current_date)));

        // Add this new day to the a_days array  
        $a_days[] = $s_current_date;
    }
    // Once the loop has finished, return the  
    // array of days.  
    return $a_days;
}

/**
 * This function is used to get when details update means which time ago
 */
function get_time_ago($datetime, $full = false)
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}


/**
 * This function is used to generate idempotency key for all type of request
 */
function generate_idempotency_key()
{
    return generate_random_string(8) . '-' . generate_random_string(4) . '-' . generate_random_string(4) . '-' . generate_random_string(4) . '-' . generate_random_string(12);
}

/**
 * This function is used to generate random string
 */
function generate_random_string($length = 5)
{
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array();
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < $length; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return strtolower(implode($pass));
}


/**
 * This function is used to get notification based on user id
 */
function get_notifications($id_user)
{
    $response_array = array('status' => false, 'message' => null, 'data' => null);
    $data =  DB::table('notifications')->select('id', 'notification', 'is_read', 'created_at')->where('id_user', $id_user)->orderBy('id', 'DESC')->get();
    if (empty($data) || count($data) == 0) {
        $message = 'Details not available.';
        $data = null;
        $response_array['message'] = $message;
    } else {
        $response_array['status'] = true;
        foreach ($data as &$value) {
            $value->created_at = get_time_ago($value->created_at);
        }
        $total_unread = DB::table('notifications')->select('id')->where('id_user', $id_user)->where('is_read', 0)->count();
        $response_array['data'] = array('info' => $data, 'total_unread' => $total_unread);
    }
    return $response_array;
}
