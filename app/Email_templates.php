<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email_templates extends Model
{
    //protected $table = 'name_of_table';

    protected $fillable = [
        'subject', 'email_content', 'description'
    ];
}
