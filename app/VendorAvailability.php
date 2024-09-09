<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorAvailability extends Model
{
    protected $fillable = [
        'id_vendor','title', 'from_date','to_date','from_time', 'to_time'
    ];
}
