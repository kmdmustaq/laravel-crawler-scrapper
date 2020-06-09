<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyInfo extends Model
{
    protected $fillable = ['CIN', 'name', 'date_of_incorp', 'reg_num', 'cateogy', 'sub_cat', 'class', 'roc_code', 'num_of_mem'];
    
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function directors()
    {
        return $this->hasMany(Director::class);
    }

    public function industryClassifications()
    {
        return $this->hasMany(IndustryClassification::class);
    }

    public function listngAndComplains()
    {
        return $this->hasMany(ListingAndComplain::class);
    }
}
