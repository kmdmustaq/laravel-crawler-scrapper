<?php

// Constants and its equavalent column name of its tables
return [
        "company" => [
                "Corporate Identification Number" => 'cin',
                "Company Name" => 'name',
                "Company Status" => "status",
                "Age (Date of Incorporation)" => "date_of_incorp",
                "Registration Number" => "reg_num",
                "Company Category" => "cateogy",
                "Company Subcategory" => "sub_cat",
                "Class of Company" => "class",
                "ROC Code" => "roc_code",
                "Number of Members (Applicable only in case of company without Share Capital)" => "num_of_mem"
        ],

        "contact" => [
                "Email Address" => 'email',
                "Registered Office" => "reg_address",
                "PIN" => 'pin'      
        ],

        "location-level" => [
                "Country" => 0,
                "State" => 1,
                "District" => 2,
                "City" => 3
        ],
        
        "industry" => [
                "Section" => "section",
                "Division" => "division",
                "Main Group" => "main_group",
                "Main Class" => "main_class",
        ],

        "listing-and-complain" => [
                'Whether listed or not' => "status",
                "Date of Last AGM" => "date_of_last_agm",
                "Date of Balance sheet" => "date_of_balance_sheet"
        ],
        
        "director" => [
                "Director Identification Number" => "director_id",
                "Name" => "name",
                "Designation" => "designation",
                "Date of Appointment" => "date_of_appointment",
        ],
];