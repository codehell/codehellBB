<?php

namespace Codehell\Codehellbb\Entities;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function AdminsAndModerators()
    {

    }
}