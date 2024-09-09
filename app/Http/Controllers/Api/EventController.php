<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\device_tokens;
use App\Helpers\Helper;
use App\User;
use App\Event;
use Illuminate\Support\Facades\Validator;
use Hash;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class EventController extends Controller
{
    /** 
     * This function is used to create an event
     */
    public function create(Request $request)
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);
        $message = '';
        $data = null;
        $current_user =  $request->user();
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'location' => 'required',
            'event_date' => 'required',
            'event_to_date' => 'required',
            'category' => 'required'
        ]);
        if ($validator->fails()) {
            $httpCode = 422;
            $response_array['status'] = false;
            $response_array['message'] = $validator->errors()->first();
            $response_array['data'] = $data;
            return response()->json($response_array);
        }
        try {
            
            if ($request->id > 0) {
                $saveEvent = Event::find($request->id);
            } else {
                $saveEvent = new Event();
            }
            
           
            $saveEvent->id_user = Auth::user()->id;
            $saveEvent->event_title = $request->title;
            $saveEvent->event_location = $request->location;
            $saveEvent->event_date = $request->event_date;
            $saveEvent->event_to_date = $request->event_to_date;  
            $saveEvent->event_category =  rand(11111, 99999);
            $saveEvent->category = $request->category;
            $saveEvent->latitude = $request->lat;
            $saveEvent->longitude = $request->lng;
            $saveEvent->created_by = Auth::user()->id;
            if ($request->id > 0) {
                $saveEvent->update();
                $message = 'Party updated successfully.';
            } else {
                $saveEvent->save();
                $message = 'Party created successfully.';
            }

            $response_array['status'] = true;
            $response_array['message'] = $message;
            $response_array['data'] = $data;
            return response()->json($response_array);
        } catch (\Exception $e) {
            $response_array['message'] = $e->getMessage();
            return response()->json($response_array);
        }
    }

    /**
     * This function is uesd to get party/event list
     */
    public function get(Request $request)
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);

        try {
            $helper = new Helper();
            $myParty = getMyParty(Auth::user()->id);
            $response_array['status'] =  !empty($myParty) ? true : false;
            $response_array['message'] = '';
            $response_array['data'] = array('info' => $myParty);
            return response()->json($response_array);
        } catch (\Exception $e) {
            $response_array['message'] = $e->getMessage();
            return response()->json($response_array);
        }
    }

    /**
     * This function is used to get detail of the vent
     */
    public function detail(Request $request)
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required'
            ]);

            if ($validator->fails()) {
                $response_array['status'] = false;
                $response_array['message'] = $validator->errors()->first();
                return response()->json($response_array);
            }
            $event_detail = getEventDetail($request->id);
            if (!empty($event_detail)) {
                return response()->json(array('status' => true, 'message' => null, 'data' => array('info' => $event_detail)));
            } else {
                return response()->json(array('status' => false, 'message' => "Detail not available.", 'data' => null));
            }
        } catch (\Exception $e) {
            $response_array['message'] = $e->getMessage();
            return response()->json($response_array);
        }
    }

    /**
     * This function is used to delete an event
     */
    public function delete(Request $request)
    {
        $response_array = array('status' => false, 'message' => null, 'data' => null);
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required'
            ]);

            if ($validator->fails()) {
                $response_array['status'] = false;
                $response_array['message'] = $validator->errors()->first();
                return response()->json($response_array);
            }
            deleteEvent($request->id, Auth::user()->id);
            return response()->json(array('status' => true, 'message' => "Event deleted successfully.", 'data' => null));
        } catch (\Exception $e) {
            $response_array['message'] = $e->getMessage();
            return response()->json($response_array);
        }
    }
}
