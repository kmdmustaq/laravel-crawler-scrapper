<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['location', 'parent', 'level'];

    public function contact()
    {
        return $this->hasMany(Contact::class);
    }
}
