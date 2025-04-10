<?php
   
return [
    'TAX_PERCENT' => 5,
    'CURRENCY' => 'AED',
    'is_active'=>[
        '0'=>[
            'label'=>'Dissable',
            'class'=>'bg-gradient-danger',
        ],
        '1'=>[
            'label'=>'Active',
            'class'=>'bg-gradient-success',
        ],
    ],
    'payment' => [
        'type'=>[
            '0'=>"Pay Later",
            '1'=>"Payment Link",
            '2'=>"Pay By Card",
            '3'=>"Cash Payment",
            '4'=>"Pay By Credit",
            '6'=>"Cash In Advance"
        ],
        'type_class'=>[
            '0'=>'bg-gradient-dark',
            '1'=>'bg-gradient-info',
            '2'=>'bg-gradient-success',
            '3'=>'bg-gradient-primary',
            '4'=>'bg-gradient-danger',
            '6'=>'bg-gradient-info',
        ],
        'icons'=>[
            '0'=>"fa-solid fa-basket-shopping",
            '1'=>"fa-solid fa-file-invoice-dollar",
            '2'=>"fa-solid fa-credit-card",
            '3'=>"fa-solid fa-money-bill-1",
            '4'=>"fa-solid fa-money-bill-1",
            '6'=>"fa-solid fa-money-bill-1",
        ],
        'text_class'=>[
            '0'=>'text-dark',
            '1'=>"text-danger",
            '2'=>"text-danger",
            '3'=>"text-info",
            '4'=>"text-danger",
            '6'=>"text-info",
        ],
        'status'=>[
            '0'=>'Pending',
            '1'=>'Paid',
            '2'=>'Failed',
            '3'=>'Cancelled',
            '4'=>'Advanced',
            '6'=>'Advanced',
        ],
        'status_class'=>[
            '0'=>'bg-gradient-danger',
            '1'=>'bg-gradient-success',
            '2'=>'bg-gradient-danger',
            '3'=>'bg-gradient-danger',
            '4'=>'bg-gradient-success',
            '6'=>'bg-gradient-success',
        ],
        'status_icon'=>[
            '0'=>'fas fa-minus',
            '1'=>'fas fa-check',
            '2'=>'fas fa-minus',
            '3'=>'fas fa-minus',
            '4'=>'fas fa-check',
            '6'=>'fas fa-check',
        ],
        'status_icon_class'=>[
            '0'=>'btn-outline-danger',
            '1'=>'btn-outline-success',
            '2'=>'btn-outline-danger',
            '3'=>'btn-outline-danger',
            '4'=>'btn-outline-success',
            '6'=>'btn-outline-success',
        ],
        'status_update'=>[
            '1'=>'Paid',
            '2'=>'Failed',
            '3'=>'Cancelled',
        ],
    ],
    //Paymennt Section


    //Job Status
    'jobs'=>[
        'actions' => [
            '0'=>'Created',
            '1'=>'Work Started',
            '2'=>'Quality Check',
            '3'=>'Ready For Delivery',
            '4'=>'Delivered',
        ],
        'status' => [
            '0'=>'Created',
            '1'=>'Working Progress',
            '2'=>'Quality Check',
            '3'=>'Ready For Delivery',
            '4'=>'Delivered',
        ],
        'status_icon' => [
            '0'=>'fa-solid fa-hourglass-start',
            '1'=>'fa-solid fa-gear',
            '2'=>'fa-solid fa-recycle',
            '3'=>'fas fa-check',
            '4'=>'fa-solid fa-flag-checkered',
        ],
        'status_text_class' => [
            '0'=>'text-dark',
            '1'=>'text-danger',
            '2'=>'text-warning',
            '3'=>'text-info',
            '4'=>'text-success',
        ],
        'status_btn_class' => [
            '0'=>'bg-gradient-dark',
            '1'=>'bg-gradient-danger',
            '2'=>'bg-gradient-warning',
            '3'=>'bg-gradient-info',
            '4'=>'bg-gradient-success',
        ],
        'status_perc' => [
            '0'=>'25%',
            '1'=>'50%',
            '2'=>'75%',
            '3'=>'90%',
            '4'=>'100%',
        ],
        'status_perc_class' => [
            '0'=>'bg-gradient-dark',
            '1'=>'bg-gradient-danger',
            '2'=>'bg-gradient-warning',
            '3'=>'bg-gradient-info',
            '4'=>'bg-gradient-success',
        ],
        'job_status_bg' => [
            '0'=>'bg-gradient-dark',
            '1'=>'bg-gradient-danger',
            '2'=>'bg-gradient-warning',
            '3'=>'bg-gradient-info',
            '4'=>'bg-gradient-success',
        ],
        'job_type' => [
            "1"=>"Quick Wash",
            "2"=>"General Service",
            "3"=>"Quick Lube"
        ],
    ],

    'job_status' => [
        '0'=>'Start',
        '1'=>'Working Progress',
        '2'=>'Quality Checked',
        '3'=>'Ready For Delivery',
        '4'=>'Dispatched/Devlivered',
        '5'=>'Delivered',
    ],
    'job_status_icon' => [
        '0'=>'fa-solid fa-hourglass-start',
        '1'=>'fa-solid fa-gear',
        '2'=>'fa-solid fa-recycle',
        '3'=>'fas fa-check',
        '4'=>'fas fa-check',
        '5'=>'fa-solid fa-flag-checkered',
    ],
    'job_status_text_class' => [
        '0'=>'bg-gradient-danger',
        '1'=>'bg-gradient-primary',
        '2'=>'bg-gradient-primary',
        '3'=>'bg-gradient-info',
        '4'=>'bg-gradient-success',
        '5'=>'bg-gradient-success',
    ],
    'status_perc' => [
        '0'=>'25%',
        '1'=>'50%',
        '2'=>'75%',
        '3'=>'100%',
        '4'=>'100%',
    ],
    'status_perc_class' => [
        '0'=>'bg-gradient-default',
        '1'=>'bg-gradient-primary',
        '2'=>'bg-gradient-primary',
        '3'=>'bg-gradient-success',
        '4'=>'bg-gradient-success',
    ],

    'item_status'=>[
        '1'=>'Processing',
        '2'=>'Dispatch',
        '3'=>'Delivered'
    ],
    'item_status_text_class'=> [
        '1'=>'bg-gradient-info',
        '2'=>'bg-gradient-primary',
        '3'=>'bg-gradient-success',
    ],
    'job_department' => [
        '0'=>'Customer Service',
        '1'=>'Operation',
        '2'=>'Operation',
        '3'=>'Accounts',
        '4'=>'Finished'
    ],
    'job_department_text_class' => [
        '0'=>'text-danger',
        '1'=>'text-primary',
        '2'=>'text-info',
        '3'=>'text-success',
        '4'=>'text-success'
    ],
    
    'qr_status_color' => [
        '0'=>'linear-gradient(45deg, #f44336, #e91e63, #ff5722,#e91e63, #ff5722, #f44336, #e91e63,#ff5722, #ff9800)',
        '1'=>'linear-gradient(45deg, #f44336, #e91e63, #ff5722,#e91e63, #ff5722, #f44336, #e91e63,#ff5722, #ff9800)',
        '2'=>'linear-gradient(45deg, #f44336, #e91e63, #ff5722,#e91e63, #ff5722, #f44336, #e91e63,#ff5722, #ff9800)',
        '3'=>'linear-gradient(45deg, #009688, #4caf50, #cddc39,#0eb114, #009688, #009688, #4caf50, #cddc39,#0eb114, #009688)',
        '4'=>'linear-gradient(45deg, #009688, #4caf50, #cddc39,#0eb114, #009688, #009688, #4caf50, #cddc39,#0eb114, #009688)',
    ],
    'fuel' => [
        '1'=>'Quarter',
        '2'=>'Half',
        '3'=>'Full',
    ],
    "user_type" => [
        "1"=>"Administrator",
        "2"=>"Operation",
        "3"=>"Service",
        "4"=>"Sales",
        "5"=>"Finance",
        "6"=>"Security",
        "7"=>"Quality",
        "8"=>"Section Forman",
        "9"=>"Mechanical",
    ],
    "user_type_access"=>[
        "administrator"=>[
            "1"
        ],
        "operation"=>[
            "1","2","3","4","8","9"
        ],
        "section-forman"=>[
            "1","2","8"
        ],

        
        "finance"=>[
            "1","4"
        ],
        "security"=>[
            "1","2","6"
        ],
        "service"=>[
            "1","2","3","4","9"
        ],
        
        "mechanical"=>[
            "1","2","3","4",
        ],
        "quality"=>[
            "1","2","7",
        ]
    ],
    "sorting"=>[
        "1"=>"Latest",
        "2"=>"Oldest",
        "3"=>"Low Price",
        "4"=>"Hight Price",
    ],
    //'bhr-paymenkLink_payment_url'=>'https://bhr.ae/payment-app/api/pbl-payment-panel',
    'paymenkLink_payment_url'=>'https://gsstations.ae/gssapi/api/new-payment-link',
    'synchronize_single_paymenkLink_url'=>'https://gsstations.ae/gssapi/api/single-pbl-synch-payment-panel',
    
    'sms'=>[
        "1"=>[
            "name"=>"mshastra",
            "url"=>"https://mshastra.com/sendurlcomma.aspx",
            "sms_url"=>"https://mshastra.com/sendurlcomma.aspx?user=20092622&pwd=buhaleeba@123&senderid=GSS SERVICE",
            "profileid"=>"20092622",
            "password"=>"buhaleeba@123",
            "senderid"=>"GSS SERVICE",
        ]
    ],

    'country'=>[
        [
            "CountryCode" => "AE",
            "CountryName" => "United Arab Emirates",
            "CountryNameAR" => "الإمارات العربية المتحدة",
            "id" => "2",
            "Active" => "1",
        ],
        [
            "CountryCode" => "BH",
            "CountryName" => "Bahrain",
            "CountryNameAR" => "البحرين",
            "id" => "23",
            "Active" => "1",
        ],
        [
            "CountryCode" => "KW",
            "CountryName" => "Kuwait",
            "CountryNameAR" => "الكويت",
            "id" => "106",
            "Active" => "1",
        ],
        [
            "CountryCode" => "OM",
            "CountryName" => "Oman",
            "CountryNameAR" => "عُمان",
            "id" => "148",
            "Active" => "1",
        ],
        [
            "CountryCode" => "QA",
            "CountryName" => "Qatar",
            "CountryNameAR" => "قطر",
            "id" => "161",
            "Active" => "1",
        ],
        [
            "CountryCode" => "SA",
            "CountryName" => "Saudi Arabia",
            "CountryNameAR" => "المملكة العربية السعودية",
            "id" => "165",
            "Active" => "1",
        ],
        [
            "CountryCode" => "SD",
            "CountryName" => "Sudan",
            "CountryNameAR" => "السودان",
            "id" => "168",
            "Active" => "1",
        ],
    ],

    'engine_oil_discount_voucher'=>[
        'items'=>[
            'I02999','I00258','I03827','I00222','I00990','I03061','I03004','I00259','I03828','I00208','I00984','I03062','I04137','I03732','I03730','I01015','I03731','I03733','I09137','I00280','I00281'
        ],
        'services'=>[
            'S161','S162','S231','S237','S169','S033','S232','S233','S234','S423','S424','S425','S426','S427','S428','S429','S430','S431'
        ],

    ],
    'customize_price_item'=>[
        'S408'=>[
            'price'=>[
                '500',
                '750',
                '1000'
            ]
        ]
    ],
    'package'=>[
        'type'=>[
            '1'=>[
                'title'=>'Silver',
                'bg_class'=>'silver_button',
                'text_class'=>'text-dark',
            ],
            '2'=>[
                'title'=>'Gold',
                'bg_class'=>'gold_button',
                'text_class'=>'text-white',
            ],
            '3'=>[
                'title'=>'Platinum',
                'bg_class'=>'platinum_button',
                'text_class'=>'text-white',
            ],
            '10'=>[
                'title'=>'Advance',
                'bg_class'=>'platinum_button',
                'text_class'=>'text-white',
            ],
        ],
    ],

    'ql_all_item_search_category'=>[
        '43','40'
    ],

    'carTexiItems'=>[
        'S255','S408'
    ],
    'bundles'=>[
        'type'=>[
            '1'=>"Normal Customer",
            '2'=>"Discount Customer",
            '3'=>"BHG Staff",
            
        ],
        'type_class'=>[
            '1'=>'bg-gradient-dark',
            '2'=>'bg-gradient-primary',
            '3'=>'bg-gradient-info',
        ],
        'btn_class'=>[
            '1'=>'bg-gradient-dark',
            '2'=>'bg-gradient-primary',
            '3'=>'bg-gradient-info',
        ],
    ],
    'quality_check'=>[
        'body_wash'=>[
            "body wash",
            "shine wash",
            "express polish",
            "vip wash",
            "super wash",
            "full service",
        ],
        'glazing'=>[
            "glazing",
            "seat cleaning",
            "tinting",
            "paint protection film",
            "mechanical",
            "electrical",
            "rust proofing",
            "misc sales",
            "sublet services",
            "dtc project"
        ],

    ],
    "check_list"=>[
        "wash"=>[
            "services"=>["Body Wash", "Shine Wash", "Express Polish", "Vip Wash", "Super Wash", "Full Service","Wash & Wax"],
            "checklist"=>[
                "types"=>[
                    "1"=>[
                        "name"=>"Washing Checklist",
                        "subtype"=>true,
                        "subtype_list"=>[
                            "1"=>[
                                "subname"=>"Front Side",
                                "subtypes"=>[
                                    "1"=>"Bumper",
                                    "2"=>"Grill",
                                    "3"=>"Number Plate",
                                    "4"=>"Head Lamps",
                                    "5"=>"Fog Lamps",
                                    "6"=>"Hood"
                                ],
                            ],
                            "2"=>[
                                "subname"=>"Rear Side",
                                "subtypes"=>[
                                    "1"=>"Bumper",
                                    "2"=>"Muffler",
                                    "3"=>"Number Plate",
                                    "4"=>"Trunk",
                                    "5"=>"Lights",
                                    "6"=>"Roof Top"
                                ],
                            ],
                            "3"=>[
                                "subname"=>"Left Side",
                                "subtypes"=>[
                                    "1"=>"Wheel",
                                    "2"=>"Fender",
                                    "3"=>"Side Mirror",
                                    "4"=>"Door Glass In & Out",
                                    "5"=>"Door Handle",
                                    "6"=>"Side Stepper"
                                ],
                            ],
                            "4"=>[
                                "subname"=>"Right Side",
                                "subtypes"=>[
                                    "1"=>"Wheel",
                                    "2"=>"Fender",
                                    "3"=>"Side Mirror",
                                    "4"=>"Door Glass In & Out",
                                    "5"=>"Door Handle",
                                    "6"=>"Side Stepper"
                                ],
                            ],
                            "5"=>[
                                "subname"=>"Inner Side",
                                "subtypes"=>[
                                    "1"=>"Smell",
                                    "2"=>"Windshield FR & RR",
                                    "3"=>"Steering Wheel",
                                    "4"=>"Gear Knob",
                                    "5"=>"Centre Console",
                                    "6"=>"Ash Try",
                                    "7"=>"Dashboard",
                                    "8"=>"AC Vents FR & RR",
                                    "9"=>"Interior Trim",
                                    "10"=>"Floor Mat",
                                    "11"=>"Rear View Mirror",
                                    "12"=>"Luggage Comp",
                                    "13"=>"Roof Top"
                                ],
                            ],
                        ],
                    ],
                ]
            ],
        ],
        "glazing"=>[
            "services"=>["Glazing"],
            "checklist"=>[
                "types"=>[
                    "1"=>[
                        "title"=>"Painted Surface",
                        "show_inner_section"=>true,
                        "subtypes"=>[
                            "1"=>[
                                "name"=>"Surface Contaminants Removed",
                                "inner_sections"=>[
                                    "1"=>"Front",
                                    "2"=>"Front left",
                                    "3"=>"Rear Left",
                                    "4"=>"Rear",
                                    "5"=>"Rear Right",
                                    "6"=>"Front Right",
                                    "7"=>"Top / Roof",
                                ],
                            ],
                            "2"=>[
                                "name"=>"Metallic Fallout & Acid Rain Spotting Removed",
                                "inner_sections"=>[
                                    "1"=>"Front",
                                    "2"=>"Front left",
                                    "3"=>"Rear Left",
                                    "4"=>"Rear",
                                    "5"=>"Rear Right",
                                    "6"=>"Front Right",
                                    "7"=>"Top / Roof",
                                ],
                            ],
                            "3"=>[
                                "name"=>"Scratches, Swirl Marks & Oxidation Removed",
                                "inner_sections"=>[
                                    "1"=>"Front",
                                    "2"=>"Front left",
                                    "3"=>"Rear Left",
                                    "4"=>"Rear",
                                    "5"=>"Rear Right",
                                    "6"=>"Front Right",
                                    "7"=>"Top / Roof",
                                ],
                            ],
                            "4"=>[
                                "name"=>"Residue Removed",
                                "inner_sections"=>[
                                    "1"=>"Front",
                                    "2"=>"Front left",
                                    "3"=>"Rear Left",
                                    "4"=>"Rear",
                                    "5"=>"Rear Right",
                                    "6"=>"Front Right",
                                    "7"=>"Top / Roof",
                                ],
                            ],
                            "5"=>[
                                "name"=>"Final Finish Evenly Applied",
                                "inner_sections"=>[
                                    "1"=>"Front",
                                    "2"=>"Front left",
                                    "3"=>"Rear Left",
                                    "4"=>"Rear",
                                    "5"=>"Rear Right",
                                    "6"=>"Front Right",
                                    "7"=>"Top / Roof",
                                ],
                            ],
                        ],
                        
                    ],
                    "2"=>[
                        "title"=>"Engine Compartment",
                        "show_inner_section"=>false,
                        "subtypes"=>[
                            "1"=>"Contaminants Removed from:",
                            "2"=>"Engine",
                            "3"=>"Engine Compartment",
                            "4"=>"Inner Hood (hood liner not saturated)",
                            "5"=>"Engine Dressed",
                        ],
                    ],
                    "3"=>[
                        "title"=>"Wheels, Tires & Wheel Arch",
                        "show_inner_section"=>false,
                        "subtypes"=>[
                            "1"=>"Wheels Cleaned",
                            "2"=>"Tires Cleaned and Dressed",
                            "3"=>"Wheel Arch Cleaned and Dressed",
                        ],
                    ],
                    "4"=>[
                        "title"=>"Critical Details (Cleaned and Dressed)",
                        "show_inner_section"=>false,
                        "subtypes"=>[
                            "1"=>"Grill",
                            "2"=>"Air Dam",
                            "3"=>"Bumper",
                            "4"=>"Logo",
                            "5"=>"Chrome Parts",
                            "6"=>"Door / Trunk (Stay Rods, Connecting Rods)",
                            "7"=>"Fuel Lid",
                            "8"=>"Exterior Rubber",
                            "9"=>"Vinyl Trims",
                            "10"=>"Door Handles",
                            "11"=>"Exterior Glass & Mirrors",
                        ],
                    ]
                ]
            ],
        ],
        "interiorCleaning"=>[
            "services"=>["Seat Cleaning"],
            "checklist"=>[
                "types"=>[
                    "1"=>[
                        "title"=>"Plastic, Rubber & Glass Surfaces Cleaned & Dressed",
                        "show_inner_section"=>true,
                        "subtypes"=>[
                            "1"=>[
                                "name"=>"Dashboard",
                                "inner_sections"=>[
                                    "1"=>"Front",
                                    "2"=>"Front left",
                                    "3"=>"Front Right",
                                ],
                            ],
                            "2"=>[
                                "name"=>"Console",
                                "inner_sections"=>[
                                    "1"=>"Front",
                                    "2"=>"Front left",
                                    "3"=>"Rear Left",
                                    "4"=>"Rear",
                                    "5"=>"Rear Right",
                                    "6"=>"Front Right",
                                    "7"=>"Top / Roof",
                                ],
                            ],
                            "3"=>[
                                "name"=>"Instrumental Panel",
                                "inner_sections"=>[
                                    "1"=>"Front left",
                                ],
                            ],
                            "4"=>[
                                "name"=>"Steering Wheel",
                                "inner_sections"=>[
                                    "1"=>"Front left",
                                ],
                            ],
                            "5"=>[
                                "name"=>"Foot Pedals",
                                "inner_sections"=>[
                                    "1"=>"Front left",
                                ],
                            ],
                            "6"=>[
                                "name"=>"Storage Areas",
                                "inner_sections"=>[
                                    "1"=>"Front",
                                    "2"=>"Front left",
                                    "3"=>"Rear Left",
                                    "4"=>"Rear",
                                    "5"=>"Rear Right",
                                    "6"=>"Front Right",
                                    "7"=>"Top / Roof",
                                ],
                            ],
                            "7"=>[
                                "name"=>"Door Frame & Trims",
                                "inner_sections"=>[
                                    "1"=>"Front left",
                                    "2"=>"Rear Left",
                                    "3"=>"Rear Right",
                                    "4"=>"Front Right",
                                ],
                            ],
                            "8"=>[
                                "name"=>"Weather Strip (Door & Body)",
                                "inner_sections"=>[
                                    "1"=>"Front left",
                                    "2"=>"Rear Left",
                                    "3"=>"Rear Right",
                                    "4"=>"Front Right",
                                ],
                            ],
                            "9"=>[
                                "name"=>"Interior Glass & Mirrors",
                                "inner_sections"=>[
                                    "1"=>"Front",
                                    "2"=>"Front left",
                                    "3"=>"Rear Left",
                                    "4"=>"Rear",
                                    "5"=>"Rear Right",
                                    "6"=>"Front Right",
                                ],
                            ],
                            "10"=>[
                                "name"=>"Rear Window Deck",
                                "inner_sections"=>[
                                    "1"=>"Rear Left",
                                    "2"=>"Rear",
                                    "3"=>"Rear Right",
                                ],
                            ],
                            "7"=>[
                                "name"=>"Ash Trays",
                                "inner_sections"=>[
                                    "1"=>"Front",
                                    "2"=>"Front left",
                                    "3"=>"Rear Left",
                                    "4"=>"Rear",
                                    "5"=>"Rear Right",
                                    "6"=>"Front Right",
                                ],
                            ],
                        ],
                        
                    ],
                    "2"=>[
                        "title"=>"Leather & Fabric Seats Cleaned",
                        "show_inner_section"=>false,
                        "subtypes"=>[
                            "1"=>"Driver Seat & Seat Belt",
                            "2"=>"Passenger Seat & Seat Belts",
                            "3"=>"2nd Row Seats & Seat Belts",
                            "4"=>"3rd Row Seats & Seat Belts",
                        ],
                    ],
                    "3"=>[
                        "title"=>"Carpets",
                        "show_inner_section"=>false,
                        "subtypes"=>[
                            "1"=>"Floor Carpet",
                            "2"=>"Floor Mats",
                            "3"=>"Head Liner",
                            "4"=>"Trunk / Luggage Compartment",
                        ],
                    ],
                    "4"=>[
                        "title"=>"General Check",
                        "show_inner_section"=>false,
                        "subtypes"=>[
                            "1"=>"Jod Card & Amount Proposed",
                            "2"=>"Dashboard Alerts",
                            "3"=>"Radio",
                            "4"=>"A/C",
                            "5"=>"Lights",
                            "6"=>"Window Glass",
                            "7"=>"Seats",
                            "8"=>"Steering Controls",
                            "9"=>"Electronic Switches",
                            "10"=>"Touch Screen",
                            "11"=>"Rear View Camera",
                            "12"=>"Noise / Abnormal Sounds",
                            "13"=>"Cabin Smell",
                        ],
                    ]
                ]
            ],
        ],
        "tinting"=>[
            "services"=>["Tinting"],
            "checklist"=>[
                "types"=>[
                    "1"=>[
                        "title"=>"Glass Surface",
                        "show_inner_section"=>true,
                        "subtypes"=>[
                            "1"=>[
                                "name"=>"Tinting Film Applied",
                                "inner_sections"=>[
                                    "1"=>"Front",
                                    "2"=>"Front left",
                                    "3"=>"Rear Left",
                                    "4"=>"Rear",
                                    "5"=>"Rear Right",
                                    "6"=>"Front Right",
                                    "7"=>"Top / Roof",
                                ],
                            ],
                            "2"=>[
                                "name"=>"Bubbles, Dust & Damage",
                                "inner_sections"=>[
                                    "1"=>"Front",
                                    "2"=>"Front left",
                                    "3"=>"Rear Left",
                                    "4"=>"Rear",
                                    "5"=>"Rear Right",
                                    "6"=>"Front Right",
                                    "7"=>"Top / Roof",
                                ],
                            ],
                            "3"=>[
                                "name"=>"Edges and Corners Cut Properly",
                                "inner_sections"=>[
                                    "1"=>"Front",
                                    "2"=>"Front left",
                                    "3"=>"Rear Left",
                                    "4"=>"Rear",
                                    "5"=>"Rear Right",
                                    "6"=>"Front Right",
                                    "7"=>"Top / Roof",
                                ],
                            ],
                            "4"=>[
                                "name"=>"Final Finish Evenly Applied & Clean",
                                "inner_sections"=>[
                                    "1"=>"Front",
                                    "2"=>"Front left",
                                    "3"=>"Rear Left",
                                    "4"=>"Rear",
                                    "5"=>"Rear Right",
                                    "6"=>"Front Right",
                                    "7"=>"Top / Roof",
                                ],
                            ],
                        ],
                        
                    ],
                    "2"=>[
                        "title"=>"Critical Details (Cleaned and Dressed)",
                        "show_inner_section"=>true,
                        "subtypes"=>[
                            "1"=>[
                                "name"=>"Grill",
                                "inner_sections"=>[
                                    "1"=>"Front",
                                ],
                            ],
                            "2"=>[
                                "name"=>"Air Dam",
                                "inner_sections"=>[
                                    "1"=>"Front",
                                ],
                            ],
                            "3"=>[
                                "name"=>"Bumper",
                                "inner_sections"=>[
                                    "1"=>"Front",
                                ],
                            ],
                            "4"=>[
                                "name"=>"Logo",
                                "inner_sections"=>[
                                    "1"=>"Front",
                                    "2"=>"Rear",
                                ],
                            ],
                            "5"=>[
                                "name"=>"Chrome Parts",
                                "inner_sections"=>[
                                    "1"=>"Front",
                                    "2"=>"Front left",
                                    "3"=>"Rear Left",
                                    "4"=>"Rear",
                                    "5"=>"Rear Right",
                                    "6"=>"Front Right",
                                    "7"=>"Top / Roof",
                                ],
                            ],
                            "6"=>[
                                "name"=>"Door / Trunk Stay Rods",
                                "inner_sections"=>[
                                    "1"=>"Front left",
                                    "2"=>"Rear Left",
                                    "3"=>"Rear",
                                    "4"=>"Rear Right",
                                    "5"=>"Front Right",
                                ],
                            ],
                            "7"=>[
                                "name"=>"Fuel Lid",
                                "inner_sections"=>[
                                    "1"=>"Rear",
                                ],
                            ],
                            "8"=>[
                                "name"=>"Exterior Rubbers",
                                "inner_sections"=>[
                                    "1"=>"Front",
                                    "2"=>"Front left",
                                    "3"=>"Rear Left",
                                    "4"=>"Rear",
                                    "5"=>"Rear Right",
                                    "6"=>"Front Right",
                                    "7"=>"Top / Roof",
                                ],
                            ],
                            "9"=>[
                                "name"=>"Vinyl Trims",
                                "inner_sections"=>[
                                    "1"=>"Front",
                                    "2"=>"Front left",
                                    "3"=>"Rear Left",
                                    "4"=>"Rear",
                                    "5"=>"Rear Right",
                                    "6"=>"Front Right",
                                    "7"=>"Top / Roof",
                                ],
                            ],
                            "10"=>[
                                "name"=>"Door Handles",
                                "inner_sections"=>[
                                    "1"=>"Front left",
                                    "2"=>"Rear Left",
                                    "3"=>"Rear",
                                    "4"=>"Rear Right",
                                    "5"=>"Front Right",
                                    "6"=>"Top / Roof",
                                ],
                            ],
                            "11"=>[
                                "name"=>"Exterior Glass",
                                "inner_sections"=>[
                                    "1"=>"Front",
                                    "2"=>"Front left",
                                    "3"=>"Rear Left",
                                    "4"=>"Rear",
                                    "5"=>"Rear Right",
                                    "6"=>"Front Right",
                                    "7"=>"Top / Roof",
                                ],
                            ],
                        ],
                    ],
                    "3"=>[
                        "title"=>"Wheels, Tires & Wheel Arch",
                        "show_inner_section"=>true,
                        "subtypes"=>[
                            "1"=>[
                                "name"=>"Wheels Cleaned",
                                "inner_sections"=>[
                                    "1"=>"Front",
                                    "2"=>"Rear Left",
                                    "3"=>"Spare Wheel",
                                    "4"=>"Rear Right",
                                    "5"=>"Front Right",
                                ],
                            ],
                            "2"=>[
                                "name"=>"Tires Cleaned and Dressed",
                                "inner_sections"=>[
                                    "1"=>"Front",
                                    "2"=>"Rear Left",
                                    "3"=>"Spare Wheel",
                                    "4"=>"Rear Right",
                                    "5"=>"Front Right",
                                ],
                            ],
                            "3"=>[
                                "name"=>"Wheel Arch Cleaned and Dressed",
                                "inner_sections"=>[
                                    "1"=>"Front",
                                    "2"=>"Rear Left",
                                    "3"=>"Spare Wheel",
                                    "4"=>"Rear Right",
                                    "5"=>"Front Right",
                                ],
                            ],
                        ],
                    ],
                ]
            ],
        ],
        "oilChange"=>[
            "services"=>["Quick Lube","Engine flush – efm"],
            "checklist"=>[
                "types"=>[
                    "1"=>[
                        "title"=>"Interior Cabin Inspection",
                        "show_inner_section"=>false,
                        "subtypes"=>[
                            "1"=>"Turn key on - check for fault codes",
                            "2"=>"Start Engine - observe operation",
                            "3"=>"Reset the Service Reminder Alert",
                            "4"=>"Stick & Update Service Reminder Sticker on B-Piller",
                        ],
                        
                    ],
                    "2"=>[
                        "title"=>"Under Hood Inspection",
                        "show_inner_section"=>false,
                        "subtypes"=>[
                            "1"=>"Check Power Steering Fluid Level",
                            "2"=>"Check Power Steering tank Cap properly fixed",
                            "3"=>"Check Brake fluid level",
                            "4"=>"Check Brake fluid tank Cap properly fixed",
                            "5"=>"Check Engine Oil Level",
                            "6"=>"Check Radiator Coolant Level",
                            "7"=>"Check Radiator Cap properly fixed",
                            "8"=>"Top off windshield washer fluid",
                            "9"=>"Check windshield Cap properly fixed",
                        ],
                    ],
                    "3"=>[
                        "title"=>"Under Body Inspection",
                        "show_inner_section"=>false,
                        "subtypes"=>[
                            "1"=>"Check for Oil leaks - Engine, Steering",
                            "2"=>"Check for Oil Leak - Oil Filtering",
                            "3"=>"Check Drain Plug fixed properly",
                            "4"=>"Check Oil Filter fixed properly",
                        ],
                    ],
                ],
            ],
        ]
    ]

]
  
?>