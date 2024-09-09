<?php

namespace Modules\Vendor\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

use App\{User};
use Illuminate\Support\Facades\Hash;
use Auth;
use App\Helpers\Helper;
use Validator;

class GalleryController extends Controller
{
    public $_helper;
    public function __construct()
    {
        $this->_helper = new Helper();
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $path = url('/uploads/vendor-gallery/') . '/';
        $sql = 'SELECT id,CONCAT("' . $path . '",name) AS image_url,name FROM vendor_gallery WHERE id_users = "' . Auth::user()->id . '"';
        $images = $this->_helper->get_data_with_sql($sql);
        $user = Auth::user();
        $settings = array();
        $settings['id_users'] = $user->id;
        $vendor_product = getVendorProduct($settings);
        $product_view = view('vendor::product.list', compact('user', 'vendor_product'))->render();
        $settings = array();
        $settings['id_users'] = $user->id;
        $vendor_plan = getVendorPlans($settings);
        $plan_view = view('vendor::plan.list-new', compact('user', 'vendor_plan'))->render();
        return view('vendor::gallery.index', compact('images', 'product_view', 'plan_view'));
    }
     /**
     * this function is use to upload gallery for vendor side.
     */
 
    
     public function upload(Request $request)
    {
        $userId = Auth::user()->id;
        $helper = new Helper();
    
        // Fetch the count of images and videos already uploaded by the user
        $imageCount = DB::table('vendor_gallery')
                        ->where('id_users', $userId)
                        ->where('file_type', 1) // 1 for images
                        ->count();
    
        $videoCount = DB::table('vendor_gallery')
                        ->where('id_users', $userId)
                        ->where('file_type', 2) // 2 for videos
                        ->count();
    
        // Validation logic
        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $file_type = strpos($file->getMimeType(), 'image') !== false ? 1 : 2;
    
            // Check the limits
            if ($file_type === 1 && $imageCount >= 7) {
              
                $response_array = [
                    'status' => false,
                    'message' =>'You can upload a maximum of 7 images.'
                ];
                return response()->json($response_array);
            }
    
            if ($file_type === 2 && $videoCount >= 1) {
               
                $response_array = [
                    'status' => false,
                    'message' =>'You can upload only 1 video.'
                ];
                return response()->json($response_array);
            }
    
            // Proceed with file upload if validation passes
            $fileName = time() . '-gallery.' . $file->getClientOriginalExtension();
            $path = public_path() . '/uploads/vendor-gallery/';
            $file->move($path, $fileName);
    
            $type = null; // Initialize $type with null
    
            // Handle image-specific logic
            if ($file_type === 1) { // If it's an image
                list($width, $height) = getimagesize($path . $fileName);
                $type = $this->getAspectRatio($width, $height); // Calculate aspect ratio for images
            } else {
                $type = 'video'; // Assign 'video' as the type for videos
            }
    
            // Insert the file data into the database
            $helper->insert_data('vendor_gallery', [
                'name' => $fileName,
                'id_users' => $userId,
                'type' => $type, // Use the calculated or assigned type
                'file_type' => $file_type, // 1 for image, 2 for video
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    
        $response_array = [
            'status' => true,
            'message' => 'Media uploaded successfully.'
        ];
    
        return response()->json($response_array);
    }


    /**
     * this function is use to display aspact ratio for vendor side.
     */
    function getAspectRatio(int $width, int $height)
    {
        if ($height > ($width * 2)) {
            return '9x80';
        } else if ($height > $width) {
            return '32x9';
        } else if ($height < $width) {
            return '16x9';
        }
    }
    /**
     * this function is use to delete gallery for vendor side.
     */
    public function deleteGalleryImage(Request $request)
    {
        $id = $request->id;
        $sql = 'SELECT id,name FROM vendor_gallery WHERE id_users = "' . Auth::user()->id . '" AND id = "' . $id . '" ';
        $info = $this->_helper->get_data_with_sql($sql);
        if ($info['row_count'] > 0) {
            $info = $info['data'][0];
            $path = public_path() . '/uploads/vendor-gallery/';
            if (file_exists($path . $info->name)) {
                @unlink($path . $info->name);
            }
            $this->_helper->delete_data('vendor_gallery', array('where' => array('id' => $info->id)));
        }
        $response_array = array(
            'status' => true, 'message' => 'Image removed succesfully.'
        );
        return response()->json($response_array);
    }
}
