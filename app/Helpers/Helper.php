<?php

namespace App\Helpers;

use App\Models\UserModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Email_templates;
use App\User;
use Validator;
use DB;
use Illuminate\Support\Facades\URL;

class Helper
{
    /**
     * This function is used to data response
     */
    public static function dataResponse($httpCode, $message, $data = null)
    {
        $httpCode = $httpCode ?? 500;
        $message = $message ?? 'Something went wrong. Please try again or report to support team.';
        $success = in_array($httpCode, array(201, 200)) ? true : false;
        $data = $data ?? [];
        $data = !empty($data) ? $data : null;

        if (empty($data)) {
            $success = false;
        }        
        $response = ['status' => $success, 'message' => $message, 'data' => $data];
        return response()->json($response, $httpCode);
    }

    /**
     * This function is used to Exception mail to admin
     */
    public static function sendExceptionMail($exceptionMessage, $url)
    {
        $to = env('SUPPORT_MAIL_FROM_ADDRESS');
        if (!empty(Auth::user()->id)) {
            $errorForUser = Auth::user()->firstname . " " . Auth::user()->lastname . " (" . Auth::user()->email . ")";
        } else {
            $errorForUser = 'Test User';
        }
        $exceptionLink = $url;
        Mail::send('mail.mail', ['exceptionMessage' => $exceptionMessage, 'errorForUser' => $errorForUser, 'exceptionLink' => $exceptionLink], function ($message) use ($to) {
            $message->to($to);
            $message->subject('Alert!! Error in web api');
        });
        return true;
    }

    /**
     * This function is send to global send mail function
     * @param array $settings
     * @return boolean email response
     */
    public function sendMail($settings = array())
    {
        $email_template = Email_templates::where('slug', $settings['slug'])->get()->first();
        $email_content = $email_template->email_content;
        $subject = $email_template->subject;
        $to = $settings['to'];

        foreach ($this->getEmailKeys() as $key => $key_info) {
            $value = isset($settings['content']->{$key_info['column']}) ? $settings['content']->{$key_info['column']} : '';
            $email_content = str_replace($key, $value, $email_content);
        }

        Mail::send('mail.common', ['email_content' => $email_content], function ($message) use ($to, $subject) {
            $message->to($to);
            $message->subject($subject);
        });
        return true;
    }

    /**
     * This function is used to get email keys, It will replace key with content
     * @return array
     */
    public function getEmailKeys()
    {
        return array(
            '#NAME#' => array('column' => 'name', 'description' => 'To bind customer name in the applicable template.'),
            '#RESET_LINK#' => array('column' => 'reset_link', 'description' => 'To bind password reset link in the applicable template'),
            '#EVENT_NAME#' => array('column' => 'event_name', 'description' => 'To bind event name in the applicable template.'),
            '#EVENT_DATE#' => array('column' => 'event_date', 'description' => 'To bind event date in the applicable template.'),
            '#EVENT_TO_DATE#' => array('column' => 'event_to_date', 'description' => 'To bind event to date in the applicable template.'),
            '#EVENT_TIME#' => array('column' => 'event_time', 'description' => 'To bind event time in the applicable template.'),
            '#EVENT_TO_TIME#' => array('column' => 'event_to_time', 'description' => 'To bind event to time in the applicable template.'),
            '#EVENT_LOCATION#' => array('column' => 'event_location', 'description' => 'To bind event location in the applicable template.'),
        );
        
    }

     /**
     * This function is used to forgot password
     * @return array
     */
    public function forgotPassword($data)
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);

        $validator = Validator::make(
            $data,
            [
                'email' => 'required|email|exists:users,email',
            ],
            [
                'email.exists' => 'This email is not registered.'
            ]
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->messages() as $input => $error) {
                $response_array['message'][$input] = $error[0];
            }
        } else {
            $user = User::where('email', $data['email'])->get()->first();
            $token = sha1(md5(rand(111111, 999999)));
            DB::table('password_resets')->where('email', $user->email)->delete();
            DB::table('password_resets')->insert([
                'email' => $user->email,
                'token' => $token,
                'created_at' => now()
            ]);
            $user->reset_link = '<a target="_blank" style="text-decoration:underline;" href="' . url('/') . '/reset-password/' . $token . '">Click Here</a>';
            $settings = array(
                'slug' => 'forgot-password',
                'to' => $data['email'],
                'user_info' => $user,
                'content' => $user
            );
            $helper = new Helper();
            $helper->sendMail($settings);
            $response_array['status'] = true;
            $response_array['message'] = 'Password reset link sent successfully.';
        }
        return $response_array;
    }

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
     * This function is used to retrive data
     * @return array
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
     * This function is used to saved data
     * @return array
     */
    function insert_data($table, $record = array())
    {
        $id = DB::table($table)->insertGetId($record);
        return $id;
    }

    /**
     * This function is used to update data
     * @return array
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
     * This function is used to delete data
     * @return array
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
     * This function is used to event based on user
     */
    function getMyParty($id_user)
    {
        $sql = 'SELECT * FROM events WHERE id_user = "' . $id_user . '" ';
        $info = $this->get_data_with_sql($sql);
        if ($info['row_count'] > 0) {
            return $info['data'];
        } else {
            return null;
        }
    }

    /**
     * This function is used to get category array to view
     */
    function getCategory($id = '')
    {
        $path = URL::to('/') . env('CATEGORY_PATH');
        $sql = 'SELECT id,category_name,CONCAT("' . $path . '",category_icon) AS category_icon_url FROM categories WHERE is_enable = 1 ORDER BY category_name ASC';
        $info = $this->get_data_with_sql($sql);
        if ($info['row_count'] > 0) {
            return $info['data'];
        } else {
            return null;
        }
    }
    
    /**
     * This function is used to sub get category array to view
     */
    function getSubCategory($id=''){
        $categories = [
            ['id' => 1, 'category_name' => 'Kids Party (under 12 years)'],
            ['id' => 2, 'category_name' => 'Teens Party (13-18 years)'],
            ['id' => 3, 'category_name' => 'Adults General Party (18+ years)'],
            ['id' => 4, 'category_name' => 'Adult-Themed Parties'],
            ['id' => 5, 'category_name' => 'Weddings'],
            ['id' => 6, 'category_name' => 'Corporate Networking Event'],
            ['id' => 7, 'category_name' => 'Conferences and Expos'],
            ['id' => 8, 'category_name' => 'Religious Parties and Events'],
            ['id' => 9, 'category_name' => 'School Parties and Events'],
            ['id' => 10, 'category_name' => 'Festivals and Concerts'],
            ['id' => 11, 'category_name' => 'Engagement Parties'],
            ['id' => 12, 'category_name' => 'Awards and Graduation Ceremonies'],
        ];
    
        if ($id === '') {
            return $categories;
        } else {
            foreach ($categories as $category) {
                if ($category['id'] == $id) {
                    return $category['category_name'];
                }
            }
            return 'Teens party (13-18 years)'; // Return null if no category is found with the given ID
        }
    }

     /**
     * This function is used to send notification
     */
    function sendPushNotification($token, $title, $body)
    {
        $serverKey = 'AAAA1a0Nx7Q:APA91bHtyTWvjS3fX3Gq6mPvpYX3YXh18_ZJJK0wqRFEl3U3ZxvzEcfMtUTcx24G2gmbdQQF-7FDHqCg0jJgBWTgY_Qc3ryNxOmnG6eqwqq0r-psFUJNMjMVFGsBR7xk-5DlwBHMvJvf'; 
        $url = 'https://fcm.googleapis.com/fcm/send';
        $headers = [
            'Authorization: key=' . $serverKey,
            'Content-Type: application/json',
        ];
        $fields = [
            'to' => $token,
            'notification' => [
                'title' => $title,
                'body' => $body,
            ],
            
            'data' => [
                'key' => 'value',
            ],
        ];
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($fields),
            CURLOPT_HTTPHEADER => $headers,
        ]);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}
