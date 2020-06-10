<?php

namespace App\Http\Library;

use App\Director;

class DirectorLibrary {

    /**
     * Parsing the data to a perfecet format
     * 
     * @param Array $data
     * 
     * @return Array
     */
    public function parse(Array $data, Array $header, $companyId) : Array
    {
        $director = [];

        // Looping the data array to keep in a good format.
        foreach ($data as $d) {
            // Getting keys and its equavalent table column names.
            $parsedData=[];
            $parsedData["company_infos_id"] = $companyId;

            foreach ($d as $key => $value){
                if ($value == "View Profile") {
                    break;
                }

                $subString = substr( $value , 0, strpos($value, 'See'));
    
                $parsedData [config('constants.director.'.trim($header[$key]))] = $subString ? trim($subString) : trim($value);
            }

            $director [] = $parsedData;
        }
        
        return $director;
    }

    /**
     * Persisting the data into the table
     * 
     * @param Array $data
     * 
     * @return App\Director object
     */
    public function store($directors)
    {
        $dir = null;
        foreach ($directors as $director) {
            $dir = Director::create($director);
        }

        return $dir;
    }

}