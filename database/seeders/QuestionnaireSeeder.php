<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Questionnaire;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class QuestionnaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Questionnaire::updateOrCreate(
            [
                'label' => 'First Name',
            ],
            [
                'company_id' => 1,
                'label' => 'First Name',
                'value' => 'first_name',
                'type' => 'text',
                'description' => 'Please provide first name',
                'is_enable' => true
            ]
        );
        Questionnaire::updateOrCreate(
            [
            'label' => 'Last Name',
        ],
        [
            'company_id' => 1,
            'label' => 'Last Name',
            'value' => 'last_name',
            'type' => 'text',
            'description' => 'Please provide last name',
            'is_enable' => true
        ]
    );
    Questionnaire::updateOrCreate(
        [
        'label' => 'Email',
    ],
    [
        'company_id' => 1,
        'label' => 'Email',
        'value' => 'email',
        'type' => 'text',
        'description' => 'Please provide email',
        'is_enable' => true
    ]
);

Questionnaire::updateOrCreate(
    [
    'label' => 'Phone',
],
[
    'company_id' => 1,
    'label' => 'Phone',
    'value' => 'phone',
    'type' => 'text',
    'description' => 'Please provide phone',
    'is_enable' => true
]
);


Questionnaire::updateOrCreate(
    [
    'label' => 'Industry',
],
[
    'company_id' => 1,
    'label' => 'Industry',
    'value' => 'industry',
    'type' => 'text',
    'description' => 'Please provide industry',
    'is_enable' => true
]
);

Questionnaire::updateOrCreate(
    [
    'label' => 'Company',
],
[
    'company_id' => 1,
    'label' => 'Company',
    'value' => 'company',
    'type' => 'text',
    'description' => 'Please provide company',
    'is_enable' => true
]
);
Questionnaire::updateOrCreate(
    [
    'label' => 'Platform',
],
[
    'company_id' => 1,
    'label' => 'Platform',
    'value' => 'platform',
    'type' => 'select',
    'description' => 'Please provide platform',
    'is_enable' => true
]
);
Questionnaire::updateOrCreate(
    [
    'label' => 'Shipment per Month',
],
[
    'company_id' => 1,
    'label' => 'Shipment per Month',
    'value' => 'shipment_month',
    'type' => 'select',
    'description' => 'Please provide shipment per month',
    'is_enable' => true
]
);
Questionnaire::updateOrCreate(
    [
    'label' => 'Message',
],
[
    'company_id' => 1,
    'label' => 'Message',
    'value' => 'message',
    'type' => 'textarea',
    'description' => 'Please provide message',
    'is_enable' => true
]
);
  }
}
