<?php

return [
    'service_charge' => 100,

    'merchant_ref' => env('MERCHANT_REF') ?? '7056',

    'product_id' => env('PRODUCT_ID') ?? '6205',

    'pay_item_id' => env('PAY_ITEM_ID') ?? '101',
    
    'mac' => env('MAC') ?? 'D3D1D05AFE42AD50818167EAC73C109168A0F108F32645C8B59E897FA930DA44F9230910DAC9E20641823799A107A02068F7BC0F4CC41D2952E249552255710F',
    
    'currency' => '566',

    'pay_url' => 'https://sandbox.interswitchng.com/webpay/pay',
    
    'get_transaction_url' => 'https://sandbox.interswitchng.com/webpay/api/v1/gettransaction.json',

    'abvs' => [
        'Niger' => 'Ng',
        'Taraba' => 'Trb',
        'Abia' => 'Ab',
    ],
];