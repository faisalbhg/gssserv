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
            '0'=>'bg-gradient-primary',
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
            'I02999','I00258','I03827','I00222','I00990','I03061','I03004','I00259','I03828','I00208','I00984','I03062','I04137','I03732','I03730','I01015','I03731','I03733'
        ],
        'services'=>[
            'S161','S162','S231','S237','S169','S033','S232','S234'
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

    ]

]
  
?>