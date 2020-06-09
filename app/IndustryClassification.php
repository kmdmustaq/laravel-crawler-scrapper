<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndustryClassification extends Model
{
    protected $fillable = ['company_infos_id', 'section', 'division', 'main_group', 'main_class'];

    public function companyInfo()
    {
        return $this->belongsTo(CompanyInfo::class, 'company_infos_id', 'id');
    }
}
