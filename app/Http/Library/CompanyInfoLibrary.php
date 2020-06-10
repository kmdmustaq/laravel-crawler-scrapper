<?php

namespace App\Http\Library;

use App\CompanyInfo;

class CompanyInfoLibrary {

    /**
     * Parsing the data to a perfecet format
     * 
     * @param Array $data
     * 
     * @return Array
     */
    public function parse(Array $data) : Array
    {
        $parsedData = [];

        foreach ($data as $value) {
            // Getting keys and its equavalent table column names.
            $subString = substr( $value[1] , 0, strpos($value[1], 'See'));

            $parsedData[config('constants.company.'.$value[0])] = $subString ? trim($subString) : $value[1];
        }

        return $parsedData;
    }

    /**
     * Persisting the data into the table
     * 
     * @param Array $data
     * 
     * @return App\CompanyInfo object
     */
    public function store(Array $data)
    {
        $companyInfo = CompanyInfo::create($data);

        return $companyInfo;
    }
}