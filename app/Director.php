<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    protected $fillable = ['company_infos_id', 'director_id', 'name', 'designation', 'date_of_appointment'];

    public function companyInfo()
    {
        return $this->belongsTo(CompanyInfo::class, 'company_infos_id', 'id');
    }
}
