<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\device_tokens;
use App\Helpers\Helper;
use App\User;
use Illuminate\Support\Facades\Validator;
use Hash;
use Illuminate\Validation\Rule;
use URL;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /**
     * This function is used to logged in the user
     */
    public function login(Request $request)
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);
        try {
            $httpCode = 500;
            $message = '';
            $data = [];
            if (empty($request->email)) {
                $message = 'Please enter email address';
                $response_array['status'] = false;
                $response_array['message'] = $message;
                $response_array['data'] = $data;
                return response()->json($response_array);
            }
            if (empty($request->password)) {
                $message = 'Please enter password';
                $response_array['status'] = false;
                $response_array['message'] = $message;
                $response_array['data'] = $data;
                return response()->json($response_array);
            }
            $login = array('email' => $request->email, 'password' => $request->password);
            if (!Auth::attempt($login)) {
                $httpCode = 201;
                $message = 'Invalid login credentials';
                $response_array['status'] = false;
                $response_array['message'] = $message;
                $response_array['data'] = $data;
                return response()->json($response_array);
            } else {
                $user = Auth::user();

                if ($user->hasRole('User')) {
                    $success['token'] = $user->createToken('PartyBookr')->accessToken;
                    $user->access_token = $success['token'];
                    device_tokens::updateOrCreate(['token' => $user->access_token], [
                        'device' => $request->device_type,
                        'user_id' => $user->id,
                    ]);
                    $message = 'Login successfully';
                    $httpCode = 200;
                    $data = $user;
                    $profile_path = URL::to('/') . '/uploads/profile/';
                    if (!empty($data->profile_image)) {
                        $data->profile_image = $profile_path . $data->profile_image;
                    }

                    $response_array['status'] = true;
                    $response_array['message'] = $message;
                    $response_array['data'] = $data;
                } else {
                    $response_array['message'] = 'Invalid credentials. please try again...';
                }
                return response()->json($response_array);
            }
        } catch (\Exception $e) {
            $response_array['status'] = false;
            $response_array['message'] = $e->getMessage();
            $response_array['data'] = $data;
            return response()->json($response_array);
        }
    }

    /**
     * This function is used to signoff the user
     */
    public function logout(Request $request)
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);
        if (empty($request->access_token)) {
            $response_array['status'] = true;
            $response_array['message'] = 'Please enter access token';
            return response()->json($response_array);
        }
        $user = Auth::user();
        device_tokens::where('token', $request->access_token)->delete();
        return response()->json(['success' => true, 'message' => 'Success', 'data' => null]);
    }

    /**
     * This function is used to register the new user
     */
    public function signup(Request $request)
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);
        $message = '';
        $data = null;
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:3'],
        ]);

        if ($validator->fails()) {
            $httpCode = 422;
            $response_array['status'] = false;
            $response_array['message'] = $validator->errors()->first();
            $response_array['data'] = $data;
            return response()->json($response_array);
        }

        try {
            $data = $request->all();

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'status' => 1
            ]);

            if (isset($data['role']) && $data['role'] == 2) {
                DB::table('vendor_cms')->insert(
                    array(
                        'vendor_id' => $user->id,
                        'title' => 'Terms & Condition',
                        'slug' => 'terms-condition',
                        'created_at' => now(),
                        'updated_at' => now()
                    )
                );
                DB::table('vendor_cms')->insert(
                    array(
                        'vendor_id' => $user->id,
                        'title' => 'Privacy Policy',
                        'slug' => 'privacy-policy',
                        'created_at' => now(),
                        'updated_at' => now()
                    )
                );
            }
            $user->roles()->sync($data['role']);
            $redirectTo = '/login';
            $data = $user;
            $user = User::find($user->id);
            $success['token'] = $user->createToken('PartyBookr')->accessToken;
            $user->access_token = $success['token'];
            device_tokens::updateOrCreate(['token' => $user->access_token], [
                'device' => $request->device_type,
                'user_id' => $user->id,
            ]);
            $message = 'Login successfully';
            $httpCode = 200;
            $data = $user;

            $profile_path = URL::to('/') . '/uploads/profile/';
            if (!empty($data->profile_image)) {
                $data->profile_image = $profile_path . $data->profile_image;
            }

            $httpCode = 200;
            $response_array['status'] = true;
            $response_array['message'] = 'Registration Successful!';
            $response_array['data'] = $data;
            return response()->json($response_array);
        } catch (\Exception $e) {
            $response_array['message'] = $e->getMessage();
            return response()->json($response_array);
        }
    }

    /**
     * This function validates the user based on social registration
     */
    public function socialLogin(Request $request)
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);
        $message = '';
        $data = null;
        $validator = Validator::make($request->all(), [
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'provider' => ['required', 'string', 'in:google,facebook'],
            'provider_id' => ['required', 'string'],
            'device_type' => ['required', 'in:1,2'],
        ]);

        if ($validator->fails()) {
            $httpCode = 422;
            $response_array['status'] = false;
            $response_array['message'] = $validator->errors()->first();
            $response_array['data'] = $data;
            return response()->json($response_array);
        }

        try {
            $data = $request->all();
            $action = 'login';
            $is_exists = User::where('email', $data['email'])->count();
            if ($is_exists == 0) {
                $is_exists = User::where('provider', $data['provider'])->where('provider_id', $data['provider_id'])->count();
                if ($is_exists == 0) {
                    $action = 'signup';
                }
            }

            if ($action == 'signup') {

                $user = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'provider' => $data['provider'],
                    'provider_id' => $data['provider_id'],
                    'status' => 1,
                    'email_verified_at' => now()
                ]);
                $data['role'] = 3;
                $user->roles()->sync($data['role']);
                $redirectTo = '/login';
                $data = $user;
                $user = User::find($user->id);
                $success['token'] = $user->createToken('PartyBookr')->accessToken;
                $user->access_token = $success['token'];
                device_tokens::updateOrCreate(['token' => $user->access_token], [
                    'device' => $request->device_type,
                    'user_id' => $user->id,
                ]);
                $message = 'Login successfully';
                $httpCode = 200;
                $data = $user;

                $profile_path = URL::to('/') . '/uploads/profile/';
                if (!empty($data->profile_image)) {
                    $data->profile_image = $profile_path . $data->profile_image;
                }
                $httpCode = 200;
                $response_array['status'] = true;
                $response_array['message'] = 'Registration Successful!';
                $response_array['data'] = $data;
            } else {

                $user = User::where('email', $data['email'])->get();
                if (empty($user)) {
                    $user = User::where('provider', $data['provider'])->where('provider_id', $data['provider_id'])->get();
                    if (empty($user)) {
                        $action = 'signup';
                    }
                }
                Auth::loginUsingId($user[0]->id);

                $user = Auth::user();

                $success['token'] = $user->createToken('PartyBookr')->accessToken;
                $user->access_token = $success['token'];
                device_tokens::updateOrCreate(['token' => $user->access_token], [
                    'device' => $request->device_type,
                    'user_id' => $user->id,
                ]);
                $message = 'Login successfully';
                $httpCode = 200;
                $data = $user;
                $profile_path = URL::to('/') . '/uploads/profile/';
                if (!empty($data->profile_image)) {
                    $data->profile_image = $profile_path . $data->profile_image;
                }

                $response_array['status'] = true;
                $response_array['message'] = $message;
                $response_array['data'] = $data;
            }
            return response()->json($response_array);
        } catch (\Exception $e) {
            $response_array['message'] = $e->getMessage();
            return response()->json($response_array);
        }
    }

    /**
     * This function is used to get profile of the user.
     */
    public function getProfile(Request $request)
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);
        $httpCode = 200;
        $data =  $request->user();
        if ($request->user()->hasRole('Vendor')) {
            $response_array['status'] = true;
            $response_array['message'] = '';
            $info =  getVendors(array('id' => $data->id, 'detail' => 1));
            $response_array['data'] = $info;
        } else {
            $profile_path = URL::to('/') . '/uploads/profile/';
            if (!empty($data->profile_image)) {
                $data->profile_image = $profile_path . $data->profile_image;
            }
            $response_array['status'] = true;
            $response_array['message'] = '';
            $response_array['data'] = $data;
        }
        return response()->json($response_array);
    }

    /**
     * This function is used to update the profile
     */
    public function updateProfile(Request $request)
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);
        $data = null;
        $current_user =  $request->user();

        $rules = array(
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($current_user->id)],
        );
        if (strlen(trim($request->password)) > 0) {
            $rules['password'] = ['required', 'string', 'min:8'];
            $rules['repeat_password'] = ['required', 'string', 'min:8', 'same:password'];
        }

        $validator = Validator::make($request->all(), $rules);



        if ($validator->fails()) {
            $httpCode = 422;
            $response_array['message'] = $validator->errors()->first();
            $response_array['data'] = $data;
            return response()->json($response_array);
        }

        try {

            $data = $request->all();

            $myfile = fopen("logs.txt", "a") or die("Unable to open file!");
            $txt = "LoginController updateProfile() " . json_encode($request->all());
            fwrite($myfile, $txt);
            $txt = "\n";
            $txt = "file data " . json_encode($_FILES);
            fwrite($myfile, $txt);
            $txt = "\n";
            fwrite($myfile, $txt);
            fclose($myfile);


            $user = [
                'name' => $data['name'],
                'email' => $data['email']
            ];

            if ($request->hasFile('profile_image')) {
                $profile_image = $request->file('profile_image');
                $imageName = time() . '-profile.' . $profile_image->getClientOriginalExtension();
                $path = public_path() . '/uploads/profile/';
                $profile_image->move($path, $imageName);
                if (!empty($current_user->profile_image) && file_exists($path . $current_user->profile_image)) {
                    @unlink($path . $current_user->profile_image);
                }
                $user['profile_image'] = $imageName;
            }

            if (strlen(trim($request->password)) > 0) {
                $user['password'] = Hash::make($request->password);
            }
            $current_user->update($user);
            if ($request->id_category > 0) {
                $helper = new Helper();
                $sql = 'SELECT id FROM vendor WHERE id_users = "' . Auth::user()->id . '"';
                $info = $helper->get_data_with_sql($sql);
                if ($info['row_count'] > 0) {
                    $helper->update_data('vendor', array('id_category' => $request->id_category), array('where' => array('id_users' => Auth::user()->id)));
                } else {
                    $helper->insert_data('vendor', array('id_category' => $request->id_category, 'id_users' => Auth::user()->id, 'created_at' => now(), 'updated_at' => now()));
                }
            }

            $data = $user;
            $data  = User::find($current_user->id);
            $profile_path = URL::to('/') . '/uploads/profile/';
            if (!empty($data->profile_image)) {
                $data->profile_image = $profile_path . $data->profile_image;
            }
            $httpCode = 200;
            $response_array['status'] = true;
            $response_array['message'] =  "Profile updated successfully.";
            $response_array['data'] = $data;
            return response()->json($response_array);
        } catch (\Exception $e) {
            $response_array['message'] =  $e->getMessage();
            return response()->json($response_array);
        }
    }

    /**
     * This function is used to change the password
     */
    public function changePassword(Request $request)
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);
        $message = '';
        $data = null;
        $current_user =  $request->user();
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'string', 'min:8', function ($attribute, $value, $fail) use ($current_user) {
                if (!\Hash::check($value, $current_user->password)) {
                    return $fail(__('The current password is incorrect.'));
                }
            }],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        if ($validator->fails()) {
            $httpCode = 422;
            $response_array['status'] = false;
            $response_array['message'] = $validator->errors()->first();
            $response_array['data'] = $data;
            return response()->json($response_array);
        }
        try {
            $data = $request->all();
            $user = [
                'password' => Hash::make($data['password'])
            ];
            $current_user->update($user);
            $data = $request->user();
            $httpCode = 200;
            $response_array['status'] = true;
            $response_array['message'] = "Password updated successfully.";
            $response_array['data'] = $data;
            return response()->json($response_array);
        } catch (\Exception $e) {
            $response_array['message'] = $e->getMessage();
            return response()->json($response_array);
        }
    }

    /**
     * This function is used to send forgot password request
     */
    public function forgotPassword(Request $request)
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);
        $helper = new Helper();
        $response_array = $helper->forgotPassword($request->all());
        return response()->json($response_array);
    }

    /**
     * This function is used to update FCM notification token to connect with the user profile
     */
    public function updateNotificationToken(Request $request)
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);
        $data = null;
        $current_user =  $request->user();

        $rules = array(
            'device_type' => ['required', 'in:1,2'],
            'notification_token' => ['required', 'string'],
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response_array['message'] = $validator->errors()->first();
            $response_array['data'] = $data;
            return response()->json($response_array);
        }
        try {
            $data = $request->all();
            $data = [
                'notification_device_type' => $data['device_type'],
                'notification_token' => $data['notification_token']
            ];
            DB::table('users')->where('id', Auth::id())->update($data);

            $response_array['status'] = true;
            $response_array['message'] =  "Settings updated successfully.";
            $response_array['data'] = null;
            return response()->json($response_array);
        } catch (\Exception $e) {
            $response_array['message'] =  $e->getMessage();
            return response()->json($response_array);
        }
    }
}
