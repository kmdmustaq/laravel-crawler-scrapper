<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Crawler extends Model
{
    protected $fillable = ['url', 'title', 'status', 'is_crawled', 'is_scrapped'];
}
