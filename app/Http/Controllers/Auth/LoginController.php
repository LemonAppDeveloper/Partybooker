<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use DB;
use App\Email_templates;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Hash;
use Validator;
use Mail;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function login(Request $request)
    {
        $this->validateLogin($request);
        $user = User::where('email', $request->email)->first();
        $status = true;
        $message = '';
        if ($user && !$user->hasRole('user')) {
            $message = 'You are not authorized to login for this app.';
            $status = false;
        }
        if ($user && $user->status == 0) {
            $message = 'Your account is disabled, please contact admin to active this account.';
            return redirect('login')->withErrors($message);
        }

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();
        $this->clearLoginAttempts($request);
        if ($request->ajax()) {
            return $this->authenticated($request, $this->guard()->user())
                ?: response()->json(['url' => redirect()->intended($this->redirectPath())->getTargetUrl()]);
        } else {
            
            if (Auth::User()->hasRole('Admin')) {
                
                return redirect('admin/dashboard')->with('success', 'You have logged in as Admin');
            } else if (Auth::User()->hasRole('Vendor')) {
                return redirect('vendor/dashboard')->with('success', 'You have logged in as Vendor');
            } else {
                return redirect('/discover')->with('success', 'You have logged in');
            }
        }
    }

    public function forgotPassword(Request $request)
    {
        $helper = new Helper();
        $response_array = $helper->forgotPassword($request->all());
        return response()->json($response_array);
    }

    public function resetPassword(Request $request, $token)
    {
        $info = DB::table('password_resets')->where('token', $token)->get()->first();
        if (!empty($info)) {

            $response_array = array('status' => false, 'message' => null, 'data' => null);

            if ($request->ajax()) {
                $data = $request->all();
                $validator = Validator::make(
                    $data,
                    [
                        'password' => 'required|confirmed|min:6',
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
                    $user = User::where('email', $info->email)->get()->first();
                    $email_to = $user->email;
                    $get_name = $user->name;

                    $user->password = Hash::make($request->password);
                    $user->save();

                    DB::table('password_resets')->where('token', $token)->delete();

                    //send mail for reset password
                    $get_mail_temp = Email_templates::where('slug', 'reset-password')->first();
                    $email_subject = $get_mail_temp['subject'];
                    $email_content = $get_mail_temp['email_content'];
                    $email_content = str_replace("#NAME#", $get_name, $email_content);

                    try {
                        Mail::send('mail.common', ['email_content' => $email_content] ,function ($message) use ($email_to, $email_subject) {
                            $message->to($email_to)->subject($email_subject);
                        });
                    } catch (Exception $ex) {
                        // Error message
                        return back()->with('error', $ex->getMessage());
                    }

                    $response_array['status'] = true;
                    $response_array['message'] = 'Password reset successful.';
                }
                return response()->json($response_array);
            }


            $data = array();
            $data['token'] = $token;
            return view('auth/reset-password', $data);
        } else {
            return redirect('/')->with('error', 'Invalid reset password link');
        }
    }
}
