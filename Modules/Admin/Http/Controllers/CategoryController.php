<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Category;
use DB;
use Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $category = array();
        $category = Category::get();
        return view('admin::category.index', compact('category'));
    }
    /**
     * this function use to store category.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $rules = [
            'category_name' => "required|max:255",
            'category_icon' => 'required|mimes:jpeg,jpg,png,svg'
        ];
        $current_info = null;
        if (isset($request->id) && $request->id > 0) {
            $current_info = DB::table('categories')->where('id', $request->id)->get()->first();
        }
        if (!empty($current_info)) {
            unset($rules['category_icon']);
        }

        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $message = array();
            foreach ($validator->errors()->messages() as $input => $error) {
                $message[$input] = $error[0];
            }
            return response()->json(['status' => false, 'message' => $message]);
        } else {
            $data = array(
                'category_name' => $request->category_name,
            );
            if ($request->hasFile('category_icon')) {
                $category_icon = $request->file('category_icon');
                $category_iconName = time() . '_' . $category_icon->getClientOriginalName();
                $path = public_path() . env('CATEGORY_PATH');
                $upload = $category_icon->move($path, $category_iconName);
                $data['category_icon'] = $category_iconName;
                if (isset($current_info->category_icon) && !empty($current_info->category_icon)) {                    
                    if (file_exists(public_path() .env('CATEGORY_PATH') . $current_info->category_icon)) {
                        @unlink(public_path() .env('CATEGORY_PATH') . $current_info->category_icon);
                    }
                }
            }
            $data['is_enable'] = $request->is_enable == 1 ? 1 : 0;
            if (!empty($current_info)) {                
                $data['updated_at'] = now();
                $id = $request->id;                
                DB::table('categories')->where('id', $id)->update($data);
                $message = 'Record updated successfully.';
            } else {
                $data['updated_at'] = now();
                $data['created_at'] = now();
                $id = DB::table('categories')->insertGetId($data);
                $message = 'Record added successfully.';
            }
            if (!is_null($id)) {
                return response()->json(['status' => true, 'message' => $message, 'data' => null]);
            } else {
                return response()->json(['status' => false, 'message' => 'Something wrong, Please try again.']);
            }
        }
    }
    /**
     * This function is used to remove the category from the database
     */
    public function destroy(Request $request, $id)
    {
        $current_info = DB::table('categories')->where('id', $id)->get()->first();
        if (isset($current_info->category_icon) && !empty($current_info->category_icon)) {
            if (file_exists(public_path().env('CATEGORY_PATH') . $current_info->category_icon)) {
                @unlink(public_path().env('CATEGORY_PATH') . $current_info->category_icon);
            }
        }
        DB::table('categories')->where('id', $id)->delete();
        return response()->json(['status' => true, 'message' => 'Record deleted successfully.', 'data' => null]);
    }
}
