<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'event_title', 'event_location','latitude','longitude', 'event_date','event_to_date', 'event_category','category'
    ];

    public function eventUsersDetail()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }
}
