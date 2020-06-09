<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListingAndComplain extends Model
{
    protected $fillable = ['company_infos_id', 'status', 'date_of_last_agm', 'date_of_balance_sheet'];

    public function companyInfo()
    {
        return $this->belongsTo(CompanyInfo::class, 'company_infos_id', 'id');
    }
}
