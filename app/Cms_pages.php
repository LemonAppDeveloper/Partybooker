<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cms_pages extends Model
{
    //protected $table = 'name_of_table';

    protected $fillable = [
        'title', 'slug', 'description', 'image'
    ];
}
