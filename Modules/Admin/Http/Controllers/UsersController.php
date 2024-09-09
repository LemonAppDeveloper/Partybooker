<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\User;
use Carbon;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $users = array();
        $users = User::whereHas('roles', function ($q) {
            $q->where('roles.id', '=', 3);
        })->orderBy('created_at', 'DESC')->get();
        return view('admin::user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('admin::user.create');
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
        return view('admin::user.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('admin::user.edit');
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

    public function export(Request $req, $type)
    {
        $type = in_array($type, array(1, 2)) ? $type : 1;
        if ($type == 1) {
            $users = User::whereHas('roles', function ($q) {
                $q->where('roles.id', '=', 3);
            })->orderBy('created_at', 'DESC')->get();
            // Create the headers.
            $header_args = array('ID', 'Name', 'Date Joined', 'Status',  'Email Address');
            // Prepare the content to write it to CSV file.
            $data = array();
            if (!empty($users)) {
                foreach ($users as $user) {
                    $temp = array();
                    $temp[] = $user['id'];
                    $temp[] = $user['name'];
                    $temp[] = Carbon\Carbon::parse($user['created_at'])->format('F d,Y');
                    $temp[] = $user['status'] === 1 ? 'Active' : 'Inactive';
                    $temp[] = $user['email'];
                    $data[] = $temp;
                }
            }
        } else {
            $vendors = User::whereHas('roles', function ($q) {
                $q->where('roles.id', '=', 2);
            })->orderBy('created_at', 'DESC')->get();
            // Create the headers.
            $header_args = array('Vendor ID', 'Vendor Name', 'Date Joined', 'Status',  'Email Address');
            // Prepare the content to write it to CSV file.
            $data = array();
            if (!empty($vendors)) {
                foreach ($vendors as $user) {
                    $temp = array();
                    $temp[] = $user['id'];
                    $temp[] = $user['name'];
                    $temp[] = Carbon\Carbon::parse($user['created_at'])->format('F d,Y');
                    $temp[] = $user['status'] === 1 ? 'Active' : 'Inactive';
                    $temp[] = $user['email'];
                    $data[] = $temp;
                }
            }
        }
        if (file_exists('PartyBookr-User.csv')) {
            @unlink('PartyBookr-User.csv');
        }
        // Start the output buffer.
        ob_start();
        // Set PHP headers for CSV output.
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=PartyBookr-User.csv');
        // Clean up output buffer before writing anything to CSV file.
        ob_end_clean();
        // Create a file pointer with PHP.
        $output = fopen('php://output', 'w');
        // Write headers to CSV file.
        fputcsv($output, $header_args);
        // Loop through the prepared data to output it to CSV file.
        foreach ($data as $data_item) {
            fputcsv($output, $data_item);
        }
        // Close the file pointer with PHP with the updated output.
        fclose($output);
        exit;
    }
     /**
     * retrieve user details for admin.
     */
    public function userDetail(Request $request)
    {
        $userId = $request->input('userId');
        $users = DB::table('users')
            ->where('users.id', $userId)
            ->get();
        $user_info = getUser($userId);
        $ActiveEvents = DB::table('user_booking')->where('id_users', $userId)->where('booking_status', 1)->count();
        $CompleteEvents = DB::table('user_booking')->where('id_users', $userId)->where('booking_status', 2)->count();
        $CancelEvents = DB::table('user_booking')->where('id_users', $userId)->where('booking_status', 3)->count();
        return response()->json(['success' => true, 'data' => $users, 'user_info' => $user_info, 'ActiveEvents' => $ActiveEvents, 'CompleteEvents' => $CompleteEvents, 'CancelEvents' => $CancelEvents]);
    }
}
