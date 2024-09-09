<?php

namespace Modules\Vendor\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Helpers\Helper;
use App\Notification;
use App\VendorAvailability;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use \CarbonPeriod;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $review_info = getVendorReviews(array('id_vendor' => Auth::id(), 'filter_by' => $request->sort_by));
        $sql = 'SELECT AVG(rating) AS avg_rating FROM vendor_reviews WHERE id_vendor = "' . Auth::id() . '" AND review_status = 1';
        $info = get_data_with_sql($sql);
        $average_review = $info['row_count'] > 0 ? round($info['data'][0]->avg_rating * 2) / 2 : 0;
        $sort_by = $request->sort_by;
        return view('vendor::review.index', compact('review_info', 'average_review','sort_by'));
    }
}
