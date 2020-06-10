<?php

namespace App\Http\Library;

use App\Contact;
use App\Location;

class ContactLibrary {

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

            $parsedData[config('constants.contact.'.$value[0])] = $value[1];
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
    public function parseLocation(Array $data) : Array
    {
        $parsedData = [];
        $location = [];
        $parentId = 2;

        foreach ($data as $value) {
            
            // Creating location if not exists

            $location = Location::where('location', $value[1])->first();

            if (is_null($location) && in_array($value[0], ["State", "District", "City"]) ) {
                
                $location = Location::create ([
                    "location" => $value[1],
                    "level" => config("constants.location-level.".$value[0]),
                    "parent" => config("constants.location-level.".$value[0]) == 1 ? 2 : $parentId
                ]);
            } 

            if (!is_null($location) && $value[0] != 'PIN') {
                $parentId = $location->id;
            }

            if ($value[0] == 'PIN') {
                $parsedData = [
                    config('constants.contact.'.$value[0]) =>  $value[1],
                    'location_id' => $parentId
                ];

                break;
            }
        }

        return $parsedData;
    }

    /**
     * Persisting the data into the table
     * 
     * @param Array $data
     * 
     * @return App\Contact object
     */
    public function store($data)
    {
        $companyInfo = Contact::create($data);

        return $companyInfo;
    }

}