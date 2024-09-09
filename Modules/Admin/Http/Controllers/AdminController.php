<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
 
use Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
 
    public function index(Request $request)
    {
 
        DB::statement('DELETE FROM `user_booking` WHERE id_events NOT IN (SELECT id FROM events)');
        DB::statement('DELETE FROM `cart` WHERE id_users NOT IN (SELECT id FROM users)');
        DB::statement('DELETE FROM `cart` WHERE id_vendor NOT IN (SELECT id FROM users)');
        DB::statement('DELETE FROM `cart` WHERE id_event NOT IN (SELECT id FROM events)');
        DB::statement('DELETE FROM `favorite_list` WHERE id_user NOT IN (SELECT id FROM users)');

        DB::statement('DELETE FROM `vendor_attributes` WHERE id_users NOT IN (SELECT id FROM users)');
        DB::statement('DELETE FROM `vendor_availabilities` WHERE id_vendor NOT IN (SELECT id FROM users)');
        DB::statement('DELETE FROM `vendor_cms` WHERE vendor_id NOT IN (SELECT id FROM users)');
        DB::statement('DELETE FROM `vendor_faqs` WHERE vendor_id NOT IN (SELECT id FROM users)');
        DB::statement('DELETE FROM `vendor_gallery` WHERE id_users NOT IN (SELECT id FROM users)');

        DB::statement('DELETE FROM `vendor_plans` WHERE id_users NOT IN (SELECT id FROM users)');

        DB::statement('DELETE FROM `vendor_plan_image` WHERE id_vendor_plan NOT IN (SELECT id FROM vendor_plans)');
        DB::statement('DELETE FROM `vendor_product` WHERE id_users NOT IN (SELECT id FROM users)');
        DB::statement('DELETE FROM `vendor_product_image` WHERE id_vendor_product NOT IN (SELECT id FROM vendor_product)');

        DB::statement('DELETE FROM `vendor_reviews` WHERE id_user NOT IN (SELECT id FROM users)');
        DB::statement('DELETE FROM `vendor_reviews` WHERE id_vendor NOT IN (SELECT id FROM users)');
        DB::statement('DELETE FROM  `device_tokens` WHERE user_id NOT IN (SELECT id FROM users)');
        DB::statement('DELETE FROM `user_booking_info` WHERE id_vendor NOT IN (SELECT id FROM users)');
        DB::statement('DELETE FROM `notifications` WHERE id_user NOT IN (SELECt id FROM users)');        

        $countryWiseUserCount = User::selectRaw('country, count(*) as user_count')
            ->join('users_roles', 'users.id', '=', 'users_roles.user_id')
            ->where('users_roles.role_id', 3)
            ->groupBy('country')
            ->orderBy('user_count', 'desc') 
            ->get();

        $selectedYear = $request->input('selectedYear', Carbon::now()->year);

        $active_users = DB::table('users')
        ->join('users_roles', 'users.id', '=', 'users_roles.user_id')
        ->select('users.*')
        ->where('users_roles.role_id', 3)
        ->where('users.status', 1)
        ->count();

        $inactive_users = DB::table('users')
        ->join('users_roles', 'users.id', '=', 'users_roles.user_id')
        ->select('users.*')
        ->where('users_roles.role_id', 3)
        ->where('users.status', 0)
        ->count();

        $totalusers = DB::table('users')
        ->join('users_roles', 'users.id', '=', 'users_roles.user_id')
        ->select('users.*')
        ->where('users_roles.role_id', 3)
        ->whereIn('users.status', [0, 1])
        ->count();

        // Monthly
        $jan = Carbon::now()->startOfyear()->format('m');

        $feb = Carbon::now()->startOfyear()->addDay(31)->format('m');

        $march = Carbon::now()->startOfyear()->addDay(59)->format('m');

        $april = Carbon::now()->startOfyear()->addDay(90)->format('m');

        $may = Carbon::now()->startOfyear()->addDay(120)->format('m');

        $jun = Carbon::now()->startOfyear()->addDay(151)->format('m');

        $july = Carbon::now()->startOfyear()->addDay(181)->format('m');

        $aug = Carbon::now()->startOfyear()->addDay(212)->format('m');

        $sep = Carbon::now()->startOfyear()->addDay(243)->format('m');

        $oct = Carbon::now()->startOfyear()->addDay(273)->format('m');

        $nov = Carbon::now()->startOfyear()->addDay(304)->format('m');

        $dec = Carbon::now()->startOfyear()->addDay(334)->format('m');

        $current_year = Carbon::now()->startOfyear()->format('Y');
        if(!empty($selectedYear)) {
            $current_year = $selectedYear;
        }

        $currentYear = Carbon::now()->year;

        // get last 3 year 
        $startYear = $currentYear - 3;
        $yearsList = [];
        for ($year = $currentYear; $year >= $startYear; $year--) {
            $yearsList[] = $year;
        }
        //end get last 3 years

        $jan_users = DB::table('users')->join('users_roles', 'users.id', '=', 'users_roles.user_id')->select('users.*')->where('users_roles.role_id', 3)->whereYear('users.created_at', $selectedYear)->whereMonth('users.created_at', '=', $jan)->count();
        $jan_vendor = DB::table('users')->join('users_roles', 'users.id', '=', 'users_roles.user_id')->select('users.*')->where('users_roles.role_id', 2)->whereYear('users.created_at', $selectedYear)->whereMonth('users.created_at', '=', $jan)->count();

        $feb_users = DB::table('users')->join('users_roles', 'users.id', '=', 'users_roles.user_id')->select('users.*')->where('users_roles.role_id', 3)->whereYear('users.created_at', $selectedYear)->whereMonth('users.created_at', '=', $feb)->count();
        $feb_vendor = DB::table('users')->join('users_roles', 'users.id', '=', 'users_roles.user_id')->select('users.*')->where('users_roles.role_id', 2)->whereYear('users.created_at', $selectedYear)->whereMonth('users.created_at', '=', $feb)->count();

        $march_users = DB::table('users')->join('users_roles', 'users.id', '=', 'users_roles.user_id')->select('users.*')->where('users_roles.role_id', 3)->whereYear('users.created_at', $selectedYear)->whereMonth('users.created_at', '=', $march)->count();
        $march_vendor = DB::table('users')->join('users_roles', 'users.id', '=', 'users_roles.user_id')->select('users.*')->where('users_roles.role_id', 2)->whereYear('users.created_at', $selectedYear)->whereMonth('users.created_at', '=', $march)->count();

        $april_users = DB::table('users')->join('users_roles', 'users.id', '=', 'users_roles.user_id')->select('users.*')->where('users_roles.role_id', 3)->whereYear('users.created_at', $selectedYear)->whereMonth('users.created_at', '=', $april)->count();
        $april_vendor = DB::table('users')->join('users_roles', 'users.id', '=', 'users_roles.user_id')->select('users.*')->where('users_roles.role_id', 2)->whereYear('users.created_at', $selectedYear)->whereMonth('users.created_at', '=', $april)->count();

        $may_users = DB::table('users')->join('users_roles', 'users.id', '=', 'users_roles.user_id')->select('users.*')->where('users_roles.role_id', 3)->whereYear('users.created_at', $selectedYear)->whereMonth('users.created_at', '=', $may)->count();
        $may_vendor = DB::table('users')->join('users_roles', 'users.id', '=', 'users_roles.user_id')->select('users.*')->where('users_roles.role_id', 2)->whereYear('users.created_at', $selectedYear)->whereMonth('users.created_at', '=', $may)->count();
        
        $jun_users = DB::table('users')->join('users_roles', 'users.id', '=', 'users_roles.user_id')->select('users.*')->where('users_roles.role_id', 3)->whereYear('users.created_at', $selectedYear)->whereMonth('users.created_at', '=', $jun)->count();
        $jun_vendor = DB::table('users')->join('users_roles', 'users.id', '=', 'users_roles.user_id')->select('users.*')->where('users_roles.role_id', 2)->whereYear('users.created_at', $selectedYear)->whereMonth('users.created_at', '=', $jun)->count();

        $july_users = DB::table('users')->join('users_roles', 'users.id', '=', 'users_roles.user_id')->select('users.*')->where('users_roles.role_id', 3)->whereYear('users.created_at', $selectedYear)->whereMonth('users.created_at', '=', $july)->count();
        $july_vendor = DB::table('users')->join('users_roles', 'users.id', '=', 'users_roles.user_id')->select('users.*')->where('users_roles.role_id', 2)->whereYear('users.created_at', $selectedYear)->whereMonth('users.created_at', '=', $july)->count();

        $aug_users = DB::table('users')->join('users_roles', 'users.id', '=', 'users_roles.user_id')->select('users.*')->where('users_roles.role_id', 3)->whereYear('users.created_at', $selectedYear)->whereMonth('users.created_at', '=', $aug)->count();
        $aug_vendor = DB::table('users')->join('users_roles', 'users.id', '=', 'users_roles.user_id')->select('users.*')->where('users_roles.role_id', 2)->whereYear('users.created_at', $selectedYear)->whereMonth('users.created_at', '=', $aug)->count();

        $sep_users = DB::table('users')->join('users_roles', 'users.id', '=', 'users_roles.user_id')->select('users.*')->where('users_roles.role_id', 3)->whereYear('users.created_at', $selectedYear)->whereMonth('users.created_at', '=',  $sep)->count();
        $sep_vendor = DB::table('users')->join('users_roles', 'users.id', '=', 'users_roles.user_id')->select('users.*')->where('users_roles.role_id', 2)->whereYear('users.created_at', $selectedYear)->whereMonth('users.created_at', '=',  $sep)->count();

        $oct_users = DB::table('users')->join('users_roles', 'users.id', '=', 'users_roles.user_id')->select('users.*')->where('users_roles.role_id', 3)->whereYear('users.created_at', $selectedYear)->whereMonth('users.created_at', '=',  $oct)->count();
        $oct_vendor = DB::table('users')->join('users_roles', 'users.id', '=', 'users_roles.user_id')->select('users.*')->where('users_roles.role_id', 2)->whereYear('users.created_at', $selectedYear)->whereMonth('users.created_at', '=',  $oct)->count();

        $nov_users = DB::table('users')->join('users_roles', 'users.id', '=', 'users_roles.user_id')->select('users.*')->where('users_roles.role_id', 3)->whereYear('users.created_at', $selectedYear)->whereMonth('users.created_at', '=',  $nov)->count();
        $nov_vendor = DB::table('users')->join('users_roles', 'users.id', '=', 'users_roles.user_id')->select('users.*')->where('users_roles.role_id', 2)->whereYear('users.created_at', $selectedYear)->whereMonth('users.created_at', '=',  $nov)->count();

        $dec_users = DB::table('users')->join('users_roles', 'users.id', '=', 'users_roles.user_id')->select('users.*')->where('users_roles.role_id', 3)->whereYear('users.created_at', $selectedYear)->whereMonth('users.created_at', '=',  $dec)->count();
        $dec_vendor = DB::table('users')->join('users_roles', 'users.id', '=', 'users_roles.user_id')->select('users.*')->where('users_roles.role_id', 2)->whereYear('users.created_at', $selectedYear)->whereMonth('users.created_at', '=',  $dec)->count();

        $categoryCounts = DB::table('vendor')
        ->join('categories', 'vendor.id_category', '=', 'categories.id')
        ->select('categories.category_name', 'vendor.id_category', DB::raw('COUNT(DISTINCT vendor.id_users) as user_count'))
        ->groupBy('vendor.id_category', 'categories.category_name')
        ->get();
        
        return view('admin::index',compact('countryWiseUserCount','totalusers','inactive_users','active_users'
            ,'jan_users','jan_vendor','feb_users','feb_vendor','march_users','march_vendor','april_users','april_vendor','may_users','may_vendor'
        ,'jun_users','jun_vendor','july_users','july_vendor','aug_users','aug_vendor','sep_users', 'sep_vendor',
        'oct_users','oct_vendor', 'nov_users', 'nov_vendor', 'dec_users', 'dec_vendor','current_year','categoryCounts','yearsList','selectedYear'));
    }
    /**
     * Display a profile screen.
     * @return view
     */
    public function profile()
    {
        return view('admin::profile');
    }
    /**
     * this function is use to update profile
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . Auth::user()->id . ',id',
        ]);
        $response_array = array('status' => false, 'message' => null, 'data' => null);
        $user = Auth::user();

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
        $user->name =  $request->name;
        $user->email =  $request->email;
        $user->save();
        $response_array['status'] = true;
        $response_array['message'] = 'Profile updated successfully.';
        return response()->json($response_array);
    }
    /**
     * this function is use to change password
     */
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
        $user->password = Hash::make($request->password);
        $user->save();
        $response_array['status'] = true;
        $response_array['message'] = 'Password updated successfully.';
        return response()->json($response_array);
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('admin::create');
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
        return view('admin::show');
    }
    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('admin::edit');
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
     * @return Renderable
     */
    public function destroy(Request $request)
    {
        try {
            if ($request->input('table') != '') {
                if ($request->input('table') == 'users') {
                    DB::table('events')->where('id_user', $request->input('id'))->delete();
                }
                DB::table($request->input('table'))->where('id', $request->input('id'))->delete();
            } else {
                DB::table('events')->where('id_user', $request->input('id'))->delete();
                $userDetail = User::findOrFail($request->input('id'));
                $userDetail->delete();
            }
            return json_encode(array('status' => 1));
        } catch (Exception $e) {
            return json_encode(array('status' => 0));
        }
    }
    /**
     * this function is use to change status
     */
    public function changeStatus(Request $request)
    {
        try {
            $userDetail = User::findOrFail($request->input('user_id'));
            $status = $request->input('status');
            if ($status == 1) {
                $update_status = 0;
            } else {
                $update_status = 1;
            }
            $userDetail->status = $update_status;
            $userDetail->save();
            return json_encode(array('status' => 1));
        } catch (Exception $e) {
            return json_encode(array('status' => 0));
        }
    }
}
