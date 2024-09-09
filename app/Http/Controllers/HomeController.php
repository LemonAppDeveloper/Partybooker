<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;
use App\Event;
use App\Helpers\Helper;
use Carbon\Carbon;
//use Mail;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, $id="")
    {
        if (Auth::user()) {
            if (Auth::user()->hasRole('Vendor')) {
                return redirect(url('/') . '/vendor/dashboard');
            }
        }

        if(!empty($request->id)) {
            session(['location_filter_ignore' => false]);
            session(['selected_event_id' => my_decrypt($request->id)]);
        }
        
        $location_filter_ignore = session('location_filter_ignore');
        if ($request->ajax()) {
            $response_array =  array('status' => true, 'message' => null, 'data' => null);

            $settings = array(
                'limit' => 150,
                'id_category' => $request->id_category,
                'sort_by' => $request->sort_by,
                'rating' => $request->rating,
                'search' => $request->search,
                'id_event' => !empty(session('selected_event_id')) ? session('selected_event_id') : null,
                'id_user' => Auth::check() ? Auth::user()->id : null,
                'location_filter_ignore' => $location_filter_ignore,
            );
            $vendor_info = getVendors($settings);

            $response_array['data']['html'] = view('discover-vendor-list', compact('vendor_info'))->render();
            return response()->json($response_array);
        }
        $helper = new Helper();
        $category = $helper->getCategory();
        if (Auth::check()) {
            $myParty =  getMyParty(Auth::user()->id);
        } else {
            $myParty = null;
        }
        $id_event = !empty(session('selected_event_id')) ? session('selected_event_id') : null;
        $settings = array('limit' => 150,'id_user' => Auth::check() ? Auth::user()->id : null,'id_event'=>$id_event,'location_filter_ignore' => $location_filter_ignore);
        $vendor_info = getVendors($settings);
        $location = null;
        if (Auth::check()) {
            if (!isset($id_event) || $id_event === null) {
                // $id_event is either not set or explicitly null
                $lastEvent = Event::where('id_user', Auth::id())->orderBy('id', 'desc')->first();
            
                if ($lastEvent) {
                    $id_event = $lastEvent->id;
                }
            }
            $location = Event::where('id', $id_event)->first();
            
            if ($location) {
                $location = $location->event_location;
            } 
        } 
         
        return view('discover', compact('myParty' , 'category', 'vendor_info','id_event','location'));
    }
     /**
     * save value in session for clear location filter.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
     public function updateLocationFilter(Request $request)
    {
        if ($request->ajax()) {
            $ignoreValue = $request->input('location_filter_ignore');
            session(['location_filter_ignore' => $ignoreValue]);
            return response()->json(['status' => true, 'message' => 'Session updated']);
        }
    
        return response()->json(['status' => false, 'message' => 'Invalid request']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function indexOld()
    {
        $helper = new Helper();
        $category = $helper->getCategory();
        $myParty = getMyParty(Auth::user()->id);
        $settings = array('limit' => 10);
        $vendor_info = getVendors($settings);
        return view('discover-old', compact('myParty', 'category', 'vendor_info'));
    }

    /**
     * This function is used to my party list
     */
    public function myParty()
    {
        $this->middleware('auth');
        $helper = new Helper();
        $category = $helper->getCategory();
        $myParty = getMyParty(Auth::user()->id);
        return view('my_party', compact('myParty', 'category'));
    }

    public function preferences()
    {
        return redirect()->route('discover');
        $this->middleware('auth');
        $user = Auth::user();
        return view('preferences');
    }

    /**
     * This function is used to create an event
     */
    public function createEvent(Request $request)
    {
        $this->middleware('auth');
        if ($request->id > 0) {
            $saveEvent = Event::find($request->id);
            if (is_null($request->lat) || is_null($request->lng)) {
                return response()->json(array('status' => false, 'message' =>  'Kindly select the loaction from the dropdown'));
            }
        } else {
            $saveEvent = new Event();
            if (is_null($request->lat) || is_null($request->lng)) {
                return response()->json(array('status' => false, 'message' =>  'Kindly select the loaction from the dropdown'));
            }
        }
        $saveEvent->id_user = Auth::user()->id;
        $saveEvent->event_title = $request->title;
        $saveEvent->event_location = $request->location;
        if (isset($request->lat) && !empty($request->lat)) {
            $saveEvent->latitude = $request->lat;
        }
        if (isset($request->lng) && !empty($request->lng)) {
            $saveEvent->longitude = $request->lng;
        }
        $saveEvent->event_date = Carbon::createFromFormat('m/d/Y', $request->event_date)->format('Y-m-d');
        $saveEvent->event_to_date = Carbon::createFromFormat('m/d/Y', $request->event_to_date)->format('Y-m-d');
        $saveEvent->event_category =  rand(11111, 99999);
        $saveEvent->category = $request->category;
        $saveEvent->created_by = Auth::user()->id; 
        if ($request->id > 0) {
            $saveEvent->update();
            $message = 'Party updated successfully.';
        } else {
            $saveEvent->save();
            session(['location_filter_ignore' => 'false']);
            $message = 'Party created successfully.';
        }

        session(['selected_event_id' => $saveEvent->id]);
        
         $encryptedId = my_encrypt($saveEvent->id);

        if ($request->ajax()) {
            return response()->json(array('status' => true, 'message' => $message,  'data' => ['encrypted_id' => $encryptedId]));
        }
        return view('my_party');
    }

    /**
     * This function is used to get vendor detail
     */
    public function vendors()
    {
        $this->middleware('auth');
        $settings = array('limit' => 40);
        $vendor_info = getVendors($settings);
        $helper = new Helper();
        $category = $helper->getCategory();
        return view('vendors', compact('vendor_info', 'category'));
    }

    /**
     * This function is used to get event detail
     */
    public function eventDetail(Request $request)
    {
        $this->middleware('auth');
        if ($request->ajax()) {
            $validated = $request->validate([
                'id' => 'required'
            ]);
            $event_detail = getEventDetail($request->id);
            if (!empty($event_detail)) {
                $html = view('event-detail', compact('event_detail'))->render();
                return response()->json(array('status' => true, 'message' => null, 'data' => array('html' => $html, 'event_detail' => $event_detail)));
            } else {
                return response()->json(array('status' => false, 'message' => "Detail not available.", 'data' => null));
            }
        }
    }

    /**
     * This function is used to get the vendor detail
     */
    public function vendorDetail(Request $request)
    {
        if ($request->ajax()) {
            $validated = $request->validate([
                'id' => 'required'
            ]);
            $settings = array(
                'id' => $request->id
            );
            $vendor_detail = getVendors($settings);
            if (!empty($vendor_detail)) {
                $vendor_detail = $vendor_detail[0];
                $html = view('vendor-detail', compact('vendor_detail'))->render();
                return response()->json(array('status' => true, 'message' => null, 'data' => array('html' => $html)));
            } else {
                return response()->json(array('status' => false, 'message' => "Detail not available.", 'data' => null));
            }
        }
    }

    /**
     * This function is used to remove the event from the database
     */
    public function eventDelete(Request $request)
    {
        $this->middleware('auth');
        if ($request->ajax()) {
            $validated = $request->validate([
                'id' => 'required'
            ]);
            deleteEvent($request->id, Auth::user()->id);
            return response()->json(array('status' => true, 'message' => "Event removed successfully.", 'data' => null));
        }
    }
}
