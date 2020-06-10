<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyInfo extends Model
{
    protected $fillable = ['cin', 'name', 'status', 'date_of_incorp', 'reg_num', 'cateogy', 'sub_cat', 'class', 'roc_code', 'num_of_mem', 'url'];
    
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

    public function setDateOfIncorpAttribute($date)
    {
        preg_match('#\((.*?)\)#', $date, $date);
        $this->attributes['date_of_incorp'] = $date[1];
    }
}
