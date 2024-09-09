<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    //protected $table = 'name_of_table';
    public $timestamps = true;
    
    protected $fillable = [
        'question', 'answer', 'is_enable'
    ];
}
