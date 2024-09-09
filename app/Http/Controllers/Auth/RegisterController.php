<?php

namespace App\Http\Controllers\Auth;

use App\Email_templates;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::PREFERENCE;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $ipAddress = $_SERVER['REMOTE_ADDR'];
        $getCountry = getCountryInfoByIp($ipAddress);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'country' => $getCountry['country'],
            'password' => Hash::make($data['password']),
        ]);
        $email_to = $user->email;
        $get_name = $user->name;
        $get_mail_temp = Email_templates::where('slug', 'registration-success')->first();
        $email_subject = $get_mail_temp['subject'];
        $email_content = $get_mail_temp['email_content'];
        $email_content = str_replace("#NAME#", $get_name, $email_content);
        $email_content = str_replace("#EMAIL#", $email_to, $email_content);
      
        try {
            Mail::send('mail.common', ['email_content' => $email_content] ,function ($message) use ($email_to, $email_subject) {
                $message->to($email_to)->subject($email_subject);
            });
        } catch (Exception $ex) {
            // Error message
            return back()->with('error', $ex->getMessage());
        }

        if (isset($data['vendor_register']) && !empty($data['vendor_register'])) {
            $user->roles()->sync(2);
            $user->email_verified_at = now();
            $user->status = 1;
            $user->update();

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

            $this->redirectTo = RouteServiceProvider::VENDOR_DASHBOARD;
            $this->guard()->login($user);
            $redirectTo = '/login';
        } else {
            $user->email_verified_at = now();
            $user->status = 1;
            $user->update();
            $this->guard()->login($user);
            $user->roles()->sync(3);
        }
        return $user;
    }
}
