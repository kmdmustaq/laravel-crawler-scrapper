<?php

namespace App\Http\Library;

use App\ListingAndComplain;

class ListingsAndComplainsLibrary 
{

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

            $parsedData[config('constants.listing-and-complain.'.$value[0])] = $subString ? trim($subString) : $value[1];
        }

        return $parsedData;
    }

    /**
     * Persisting the data into the table
     * 
     * @param Array $data
     * 
     * @return App\ListingAndComplain object
     */
    public function store(Array $data)
    {
        return ListingAndComplain::create($data);
    }

}