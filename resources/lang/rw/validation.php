<?php

return [
    'required' => 'Igice :attribute girakenewe.',
    'email' => ':attribute igomba kuba aderesi y\'imeyili nyayo.',
    'unique' => ':attribute isanzwe yarakoreshejwe.',
    'min' => [
        'string' => ':attribute igomba kuba nibura inyuguti :min.',
    ],
    'max' => [
        'string' => ':attribute ntishobora kurenza inyuguti :max.',
    ],
    'confirmed' => 'Icyemeza :attribute ntikijyanye.',
    'in' => ':attribute yatoranyijwe si nyayo.',
    'exists' => ':attribute yatoranyijwe si nyayo.',

    'custom' => [
        'company_name' => [
            'required' => 'Nyamuneka andika izina ry\'isosiyete.',
        ],
        'business_type' => [
            'required' => 'Nyamuneka hitamo ubwoko bw\'ubucuruzi.',
        ],
        'cooperative_id' => [
            'exists' => 'Koperative wahisemo ntibaho.',
        ],
    ],

    'attributes' => [
        'name' => 'amazina yose',
        'email' => 'imeyili',
        'phone' => 'telefoni',
        'password' => 'ijambo ry\'ibanga',
        'role' => 'uruhare',
        'language' => 'ururimi',
        'location' => 'ahantu',
        'company_name' => 'izina ry\'isosiyete',
        'business_type' => 'ubwoko bw\'ubucuruzi',
        'cooperative_id' => 'koperative',
    ],
];
