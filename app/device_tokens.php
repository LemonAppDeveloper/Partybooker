<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class device_tokens extends Model
{
    protected $fillable = ['user_id', 'token', 'device'];
}
