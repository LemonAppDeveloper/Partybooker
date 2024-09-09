<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankDetails extends Model
{
    protected $table = 'bank_details';

    protected $fillable = [
        'vendor_id', 'bank_name','account_no','code'
    ];
}
