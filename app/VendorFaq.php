<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorFaq extends Model
{
    protected $fillable = [
        'vendor_id','question', 'answer', 'is_enable'
    ];
}
