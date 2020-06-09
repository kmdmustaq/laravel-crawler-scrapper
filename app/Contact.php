<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['company_infos_id', 'location_id', 'reg_address', 'email', 'pin'];

    public function companyInfo()
    {
        return $this->belongsTo(CompanyInfo::class, 'company_infos_id', 'id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
