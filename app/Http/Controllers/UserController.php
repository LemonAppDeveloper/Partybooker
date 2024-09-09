<?php

namespace App\Http\Controllers;

use App\Cms_pages;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;
use App\Event;
use App\Faq;
use Mail;
//use Mail;
use Hash;

class UserController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //return view('discover');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . Auth::user()->id . ',id',
        ]);

        $response_array = array('status' => false, 'message' => null, 'data' => null);
        $user = Auth::user();
        $user->name =  $request->name;
        $user->email =  $request->email;

        if ($request->hasFile('profile_image')) {
            $profile_image = $request->file('profile_image');
            $imageName = time() . '-profile.' . $profile_image->getClientOriginalExtension();
            $path = public_path() . '/uploads/profile/';
            $profile_image->move($path, $imageName);
            if (!empty($user->profile_image) && file_exists($path . $user->profile_image)) {
                @unlink($path . $user->profile_image);
            }
            $user->profile_image = $imageName;
        }
        $user->save();
        $response_array['status'] = true;
        $response_array['message'] = 'Profile updated successfully.';
        return response()->json($response_array);
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'password' => 'required|confirmed|min:4',
            'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!\Hash::check($value, $user->password)) {
                    return $fail(__('The current password is incorrect.'));
                }
            }],
        ]);
        $response_array = array('status' => false, 'message' => null, 'data' => null);
        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();
        $response_array['status'] = true;
        $response_array['message'] = 'Password updated successfully.';
        return response()->json($response_array);
    }

    /**
     * This function is used to retrieve faq list
     */
    public function faq()
    {
        $data = Faq::all();
        return view('faq', compact('data'));
    }
    
    public function faqSearch(Request $request)
    {
        $searchTerm = $request->input('query');
        $data = Faq::where('question', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('answer', 'LIKE', "%{$searchTerm}%")
                    ->get();
        
        return response()->json($data);
    }


    /**
     * This function is used to retrieve contact form
     */
    public function contactForm(Request $request)
    {
        $request->validate([
            'fname' => 'required|string',
            'email' => 'required|email',
            'refno' => 'required|string',
            'enquiry' => 'required|string',
            'message' => 'required|string',
        ]);
        $fname = $request->fname;
        $email = $request->email;
        $refno = $request->refno;
        $enquiry = $request->enquiry;
        $msg = $request->message;
        $to = "jaydip@crestcoders.com";
        try {
            Mail::send('mail.contact-form', ['fname' => $fname, 'email' => $email, 'refno' => $refno, 'enquiry' => $enquiry, 'msg' => $msg], function ($message) use ($request, $fname, $email, $refno, $enquiry, $msg, $to) {
                $message->to($to)->subject("'contact us' PartyBookr");
            });
            // Success message
            return back()->with('success', 'Your message has been sent successfully!');
        } catch (Exception $ex) {
            // Error message
            return back()->with('error', $ex->getMessage());
        }
    }
    /**
     * This function is used to retrieve CMS Page
     */
    public function termsOfUse()
    {
        $data = Cms_pages::where('slug', 'terms-and-conditions')->get();
        return view('terms-of-use', compact('data'));
    }

    /**
     * This function is used to retrieve Internet security
     */
    public function internetSecurity()
    {
        $data = Cms_pages::where('slug', 'internet-security')->get();
        return view('internet-security', compact('data'));
    }

    /**
     * This function is used to retrieve privacy policy
     */
    public function privacyPolicy()
    {
        $data = Cms_pages::where('slug', 'privacy-policy')->get();
        return view('privacy-policy', compact('data'));
    }
}
