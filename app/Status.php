<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function partials()
    {
        return $this->hasMany(Partial::class);
    }
}
