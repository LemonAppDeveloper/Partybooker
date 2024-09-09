<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Redirect;
use App\User;

class SocialLoginController extends Controller
{
    protected $providers = [
        'facebook', 'google', 'twitter'
    ];
    
     /**
     * this function is use to redirect to provider.
     */
    public function redirectToProvider($driver)
    {
        if (!$this->isProviderAllowed($driver)) {
            return $this->sendFailedResponse("{$driver} is not currently supported");
        }
        try {
            return Socialite::driver($driver)->redirect();
        } catch (Exception $e) {
            return $this->sendFailedResponse($e->getMessage());
        }
    }
    
    /**
     * this function is use to handle the provider calll back function.
     */
    public function handleProviderCallback($driver)
    {
        try {
            if($driver == 'twitter') {
                $user = Socialite::driver($driver)->user();
            } else {
                $user = Socialite::driver($driver)->stateless()->user();
            }            
        } catch (Exception $e) {
            return $this->sendFailedResponse($e->getMessage());
        }
        if ($driver == 'twitter') {
            return $this->loginOrCreateAccount($user, $driver);
        } else if ($driver == 'facebook') {
            return $this->loginOrCreateAccount($user, $driver);
        } else {
            // check for email in returned user
            return empty($user->email) ? $this->sendFailedResponse("No email id returned from {$driver} provider.") : $this->loginOrCreateAccount($user, $driver);
        }
    }

    /**
     * this function is use to check allowed provider
     */
    private function isProviderAllowed($driver)
    {
        return in_array($driver, $this->providers) && config()->has("services.{$driver}");
    }
     /**
     * this function is use to failed response
     */
    protected function sendFailedResponse($msg = null)
    {
        if (empty($msg)) {
            $msg = 'Unable to login, try with another provider to login.';
        }
        return redirect('login')->withErrors($msg);
    }
    /**
     * this function is use to social login and create account
     */
    protected function loginOrCreateAccount($providerUser, $driver)
    {
        // check for already has account
        if ($driver == 'facebook') {
            $user = User::where('provider_id', $providerUser->getId())->where('provider', $driver)->first();
        } else {
            $user = User::where('email', $providerUser->getEmail())->where('provider', $driver)->first();
            if(empty($user)) {
                $user = User::where('email', $providerUser->getEmail())->first();
            }
        }
        // if user already found
        if ($user) {
            // update the avatar and provider that might have changed
            $getUsername = explode(' ', $providerUser->getName(), 2);
            $user->name = $providerUser->getName();
            $user->provider_id = $providerUser->getId();
            $user->save();
            Auth::login($user, true);
            return $this->sendSuccessResponse(0);
        } else {
            // create a new user
            $user = new User();
            $user->name = $providerUser->getName();
            $user->email = $providerUser->getEmail();
            $user->provider = $driver;
            $user->provider_id = $providerUser->getId();
            $user->status = 1;
            // user can use reset password to create a password
            $user->password = '';
            $user->save();
            $user->roles()->sync(3);
            Auth::login($user, true);
            return $this->sendSuccessResponse(1);
        }
    }
    
     /**
     * this function is use to send success response
     */
    protected function sendSuccessResponse($log)
    {
        if (!empty($log)) {
            $url = '/preferences';
        } else {
            $url = '/discover';
        }
        return Redirect::to($url);
    }
}
