<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorCms extends Model
{
    protected $fillable = [
        'vendor_id','title', 'slug','description','image', 'is_enable'
    ];
}
