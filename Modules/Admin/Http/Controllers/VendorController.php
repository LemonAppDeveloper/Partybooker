<?php

namespace Modules\Admin\Http\Controllers;

use App\BankDetails;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;  

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(){
        $vendors = array();
        $vendors = User::whereHas('roles', function ($q) {$q->where('roles.id', '=',2);})->orderBy('created_at','DESC')->get();
        return view('admin::vendor.index',compact('vendors')); 
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(){
        return view('admin::vendor.create');
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
        return view('admin::vendor.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('admin::vendor.edit');
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
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
   /**
     * Show the form for the specified vendor.
     */
    public function vendorDetail(Request $request) {
        $userId = $request->input('userId');
        $users= DB::table('users')->where('users.id', $userId)->get();
        $user_info = getUser($userId);
        $ActiveEvents = DB::table('user_booking')->where('id_users',$userId)->where('booking_status', 1)->count();
        $CompleteEvents = DB::table('user_booking')->where('id_users',$userId)->where('booking_status', 2)->count();
        $CancelEvents = DB::table('user_booking')->where('id_users',$userId)->where('booking_status', 3)->count();
        $bankDetail = BankDetails::where('vendor_id', $userId)->first();
        return response()->json(['success' => true, 'data' => $users ,'user_info'=>$user_info, 'ActiveEvents' => $ActiveEvents, 'CompleteEvents' => $CompleteEvents, 'CancelEvents' => $CancelEvents, 'bankDetail' => $bankDetail]);
    }
}
