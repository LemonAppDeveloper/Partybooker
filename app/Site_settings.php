<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site_settings extends Model
{
    //protected $table = 'name_of_table';

    protected $fillable = [
        'setting_key', 'setting_value'
    ];
}
