<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\ProductStock;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companyId = Company::updateOrCreate(['name' => 'Alfa Mohuha'])->id;

        Product::updateOrCreate(
            [
                'sku' => 'SPN-X02-BLK'
            ],
            [
                'company_id' => $companyId,
                'name' => 'X2 Black',
                'shipping_method' => 'Tuffnells',
                'sku' => 'SPN-X02-BLK',
                'stock' => true,
                'product_type' => 'product',
                'color' => 'Black',
                'image' => 'products/x2-black.jpg',
                'weight_unit' => '25',
            ]
        );

        Product::updateOrCreate(
            [
                'sku' => 'SPN-X02-RED'
            ],
            [
                'company_id' => $companyId,
                'name' => 'X2 Red',
                'shipping_method' => 'Tuffnells',
                'sku' => 'SPN-X02-RED',
                'image' => 'products/x2-red.jpg',
                'stock' => true,
                'product_type' => 'product',
                'weight_unit' => '25',
            ]
        );

        Product::updateOrCreate(
            [
                'sku' => 'SPN-X02-WHT'
            ],
            [
                'company_id' => $companyId,
                'name' => 'X2 White',
                'shipping_method' => 'Tuffnells',
                'sku' => 'SPN-X02-WHT',
                'stock' => true,
                'product_type' => 'product',
                'color' => 'white',
                'image' => 'products/x2-white.jpg',
                'weight_unit' => '25',
            ]
        );

        Product::updateOrCreate(
            [
                'sku' => 'BIK-EBY-BLK'
            ],
            [
                'company_id' => $companyId,
                'name' => 'E-bykka Black',
                'shipping_method' => 'Tuffnells',
                'sku' => 'BIK-EBY-BLK',
                'stock' => true,
                'product_type' => 'product',
                'color' => 'back',
                'image' => 'products/e-bykka-black.jpg',
                'weight_unit' => '15',
            ]
        );

        Product::updateOrCreate(
            [
                'sku' => 'BIK-EBY-RED'
            ],
            [
                'company_id' => $companyId,
                'name' => 'E-bykka Red',
                'shipping_method' => 'Tuffnells',
                'sku' => 'BIK-EBY-RED',
                'stock' => true,
                'product_type' => 'product',
                'image' => 'products/e-bykka-red.jpg',
                'weight_unit' => '15',
            ]
        );

        Product::updateOrCreate(
            [
                'sku' => 'TRD-Q04-BLK'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Q4 flex Black',
                'shipping_method' => 'Tuffnells',
                'sku' => 'TRD-Q04-BLK',
                'stock' => true,
                'product_type' => 'product',
                'image' => 'products/q4-flex-black.jpg',
                'weight_unit' => '32',
            ]
        );

        Product::updateOrCreate(
            [
                'sku' => 'TRD-Q04-WHT'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Q4 flex White',
                'shipping_method' => 'Tuffnells',
                'sku' => 'TRD-Q04-WHT',
                'stock' => true,
                'product_type' => 'product',
                'image' => 'products/q4-flex-white.jpg',
                'weight_unit' => '32',
            ]
        );

        Product::updateOrCreate(
            [
                'sku' => 'TRD-P01-SIL'
            ],
            [
                'company_id' => $companyId,
                'name' => 'P1 T600',
                'shipping_method' => 'Tuffnells',
                'sku' => 'TRD-P01-SIL',
                'stock' => true,
                'product_type' => 'product',
                'image' => 'products/p1-t600.jpg',
                'weight_unit' => '32',
            ]
        );

        Product::updateOrCreate(
            [
                'sku' => 'TRD-A06-BSC-BLK'
            ],
            [
                'company_id' => $companyId,
                'name' => 'A6 Basic',
                'shipping_method' => 'Tuffnells',
                'sku' => 'TRD-A06-BSC-BLK',
                'stock' => true,
                'product_type' => 'product',
                'color' => '',
                'image' => 'products/a6-basic.jpg',
                'weight_unit' => '32',
            ]
        );

        Product::updateOrCreate(
            [
                'sku' => 'CRS-X00-BLK'
            ],
            [
                'company_id' => $companyId,
                'name' => 'X Trainer Black',
                'shipping_method' => 'Tuffnells',
                'sku' => 'CRS-X00-BLK',
                'image' => 'products/x-trainer-black.jpg',
                'stock' => true,
                'product_type' => 'product',
                'weight_unit' => '15',
            ]
        );
        Product::updateOrCreate(
            [
                'sku' => 'CRS-X00-WHT'
            ],
            [
                'company_id' => $companyId,
                'name' => 'X Trainer White',
                'shipping_method' => 'Tuffnells',
                'sku' => 'CRS-X00-WHT',
                'stock' => true,
                'product_type' => 'product',
                'image' => 'products/x–trainer-white.jpg',
                'weight_unit' => '15',
            ]
        );

        Product::updateOrCreate(
            [
                'sku' => 'MAS-MG1-GRY'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Fascial Gun',
                'shipping_method' => 'Tuffnells',
                'sku' => 'MAS-MG1-GRY',
                'image' => 'products/fascial-gun.jpg',
                'stock' => true,
                'product_type' => 'product',
                'weight_unit' => '4',
            ]
        );

        Product::updateOrCreate(
            [
                'sku' => 'TRD-A06-MLT-BLK'
            ],
            [
                'company_id' => $companyId,
                'name' => 'A6 Multi',
                'shipping_method' => 'Tuffnells',
                'sku' => 'TRD-A06-MLT-BLK',
                'stock' => true,
                'product_type' => 'product',
                'image' => 'products/a6-multi.jpg',
                'weight_unit' => '32',
            ]
        );

        Product::updateOrCreate(
            [
                'sku' => 'SPN-X03-YEL'
            ],
            [
                'company_id' => $companyId,
                'name' => 'X3 Black',
                'shipping_method' => 'Tuffnells',
                'sku' => 'SPN-X03-YEL',
                'image' => 'products/x3-black.jpg',
                'stock' => true,
                'product_type' => 'product',
            ]
        );

        Product::updateOrCreate(
            [
                'sku' => 'BIK-SNH-021-WHT'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Racer White',
                'shipping_method' => 'Tuffnells',
                'sku' => 'BIK-SNH-021-WHT',
                'stock' => true,
                'product_type' => 'product',
                'image' => 'products/racer-white.jpg',
                'weight_unit' => '20',
            ]
        );
        Product::updateOrCreate(
            [
                'sku' => 'BIK-SNH-021-RED'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Racer Red',
                'shipping_method' => 'Tuffnells',
                'sku' => 'BIK-SNH-021-RED',
                'stock' => true,
                'product_type' => 'product',
                'image' => 'products/racer-red.jpg',
                'weight_unit' => '20',
            ]
        );
        Product::updateOrCreate(
            [
                'sku' => 'BIK-SNH-021-BLK'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Racer Black',
                'shipping_method' => 'Tuffnells',
                'sku' => 'BIK-SNH-021-BLK',
                'stock' => true,
                'product_type' => 'product',
                'image' => 'products/racer-black.jpg',
                'weight_unit' => '20',
            ]
        );

        Product::updateOrCreate(
            [
                'sku' => 'BIK-SNH-021-WHT'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Racer White',
                'shipping_method' => 'Tuffnells',
                'sku' => 'BIK-SNH-021-WHT',
                'stock' => true,
                'product_type' => 'product',
                'image' => 'products/racer-white.jpg',
                'weight_unit' => '20',
            ]
        );
        Product::updateOrCreate(
            [
                'sku' => 'TRD-XF0-BLK'
            ],
            [
                'company_id' => $companyId,
                'name' => 'XF Black',
                'shipping_method' => 'Tuffnells',
                'sku' => 'TRD-XF0-BLK',
                'stock' => true,
                'product_type' => 'product',
                'image' => 'products/xf-black.jpg',
                'weight_unit' => '32',
            ]
        );

        Product::updateOrCreate(
            [
                'sku' => 'TRD-XF0-WHT'
            ],
            [
                'company_id' => $companyId,
                'name' => 'XF White',
                'shipping_method' => 'Tuffnells',
                'sku' => 'TRD-XF0-WHT',
                'stock' => true,
                'product_type' => 'product',
                'image' => 'products/xf-white.jpg',
                'weight_unit' => '32',
            ]
        );


        Product::updateOrCreate(
            [
                'sku' => 'SPN-X01-BLK'
            ],
            [
                'company_id' => $companyId,
                'name' => 'X1 Black',
                'shipping_method' => 'Tuffnells',
                'sku' => 'SPN-X01-BLK',
                'stock' => true,
                'product_type' => 'product',
                'color' => 'black',
                'image' => 'products/x1-black.jpg',
                'weight_unit' => '25',
            ]
        );
        Product::updateOrCreate(
            [
                'sku' => 'SPN-X07-BLK'
            ],
            [
                'company_id' => $companyId,
                'name' => 'X7 Black',
                'shipping_method' => 'Tuffnells',
                'sku' => 'SPN-X07-BLK',
                'stock' => true,
                'product_type' => 'product',
                'color' => 'black',
                'image' => 'products/x7-black.jpg',
                'weight_unit' => '25',
            ]
        );
        Product::updateOrCreate(
            [
                'sku' => 'SPN-X01-WHT'
            ],
            [
                'company_id' => $companyId,
                'name' => 'X1 White',
                'shipping_method' => 'Tuffnells',
                'sku' => 'SPN-X01-WHT',
                'stock' => true,
                'product_type' => 'product',
                'image' => 'products/x1-white.jpg',
                'color' => 'White',
                'weight_unit' => '25',
            ]
        );


        Product::updateOrCreate(
            [
                'sku' => 'TRD-Q03-BLK'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Q3 flex',
                'shipping_method' => 'Tuffnells',
                'sku' => 'TRD-Q03-BLK',
                'stock' => true,
                'product_type' => 'product',
                'color' => 'Black',
                'image' => 'products/q3-flex.jpg',
                'weight_unit' => '32',
            ]
        );

        Product::updateOrCreate(
            [
                'sku' => 'TRD-B03-BLK'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Breeze B3',
                'shipping_method' => 'Tuffnells',
                'sku' => 'TRD-B03-BLK',
                'stock' => true,
                'product_type' => 'product',
                'color' => 'Black',
                'image' => 'products/breeze-b3.jpg',
                'weight_unit' => '32',
            ]
        );

        Product::updateOrCreate(
            [
                'sku' => 'TRD-GLD-01-LGT'
            ],
            [
                'company_id' => $companyId,
                'name' => 'E-Glide Light',
                'shipping_method' => 'Tuffnells',
                'sku' => 'TRD-GLD-01-LGT',
                'stock' => true,
                'product_type' => 'product',
                'color' => 'Light',
                'image' => 'products/e-glide-light.jpg',
                'weight_unit' => '32',
            ]
        );
        Product::updateOrCreate(
            [
                'sku' => 'GRD-Z1-BLK'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Zah Z1 Garden Tool',
                'shipping_method' => 'Tuffnells',
                'sku' => 'GRD-Z1-BLK',
                'stock' => true,
                'product_type' => 'product',
                'color' => 'Black',
                'image' => 'products/zah-z1-garden-tool.jpg',
                'weight_unit' => '5',
            ]
        );


        Product::updateOrCreate(
            [
                'sku' => 'SPN-X01-RED'
            ],
            [
                'company_id' => $companyId,
                'name' => 'X1 Red',
                'shipping_method' => 'Tuffnells',
                'sku' => 'SPN-X01-RED',
                'image' => 'products/x1-red.jpg',
                'stock' => true,
                'product_type' => 'product',
                'color' => 'Red',
                'weight_unit' => '25',
            ]
        );

        Product::updateOrCreate(
            [
                'sku' => 'SPN-X04-BLK'
            ],
            [
                'company_id' => $companyId,
                'name' => 'X4 Black',
                'shipping_method' => 'Tuffnells',
                'sku' => 'SPN-X04-BLK',
                'color' => 'Black',
                'image' => 'products/x4-black.jpg',
                'weight_unit' => '25',
            ]
        );

        Product::updateOrCreate(
            [
                'sku' => 'SPN-T03-RED'
            ],
            [
                'company_id' => $companyId,
                'name' => 'T3 Red',
                'shipping_method' => 'Tuffnells',
                'sku' => 'SPN-T03-RED',
                'stock' => true,
                'product_type' => 'product',
                'color' => 'Red',
                'image' => 'products/t3-red.jpg',
                'weight_unit' => '25',
            ]
        );

        Product::updateOrCreate(
            [
                'sku' => 'SPN-T03-GLD'
            ],
            [
                'company_id' => $companyId,
                'name' => 'T3 Gold',
                'shipping_method' => 'Tuffnells',
                'sku' => 'SPN-T03-GLD',
                'stock' => true,
                'product_type' => 'product',
                'color' => 'Gold',
                'image' => 'products/t3-gold.jpg',
                'weight_unit' => '25',
            ]
        );

        Product::updateOrCreate(
            [
                'sku' => 'BIK-RRC-01-RED'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Road Racer Conti Bike Cycle Red',
                'shipping_method' => 'Tuffnells',
                'sku' => 'BIK-RRC-01-RED',
                'stock' => true,
                'product_type' => 'product',
                'color' => 'Red',
                'image' => 'products/racer-red.jpg',
                'weight_unit' => '20',
            ]
        );

        Product::updateOrCreate(
            [
                'sku' => 'BIK-RRC-01-BLK'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Road Racer Conti Bike Cycle Black',
                'shipping_method' => 'Tuffnells',
                'sku' => 'BIK-RRC-01-BLK',
                'stock' => true,
                'product_type' => 'product',
                'image' => 'products/racer-black.jpg',
                'color' => 'Black',
                'weight_unit' => '20',
            ]
        );

        Product::updateOrCreate(
            [
                'sku' => 'BIK-EP-01-BLK'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Equinox Pro Black',
                'shipping_method' => 'Tuffnells',
                'sku' => 'BIK-EP-01-BLK',
                'stock' => true,
                'product_type' => 'product',
                'image' => 'products/racer-black.jpg',
                'color' => 'Black',
                'weight_unit' => '20',
            ]
        );

        Product::updateOrCreate(
            [
                'sku' => 'BIK-EP-01-WHT'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Equinox Pro White',
                'shipping_method' => 'Tuffnells',
                'sku' => 'BIK-EP-01-WHT',
                'stock' => true,
                'product_type' => 'product',
                'image' => 'products/racer-white.jpg',
                'color' => 'White',
                'weight_unit' => '20',
            ]
        );
        Product::updateOrCreate(
            [
                'sku' => 'BIK-EP-01-WHT'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Equinox Pro Red',
                'shipping_method' => 'Tuffnells',
                'sku' => 'BIK-EP-01-WHT',
                'stock' => true,
                'product_type' => 'product',
                'image' => 'products/racer-red.jpg',
                'color' => 'Red',
                'weight_unit' => '20',
            ]
        );
        Product::updateOrCreate(
            [
                'sku' => 'BIK-EP-01-BLK-BLU'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Equinox Pro Black/Blue',
                'shipping_method' => 'Tuffnells',
                'sku' => 'BIK-EP-01-BLK-BLU',
                'stock' => true,
                'product_type' => 'product',
                'image' => 'products/racer-black.jpg',
                'color' => 'Black/Blue',

                'weight_unit' => '20',
            ]
        );

        Product::updateOrCreate(
            [
                'sku' => 'BIK-EP-01-BLK-GLD'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Equinox Pro Black/Gold',
                'shipping_method' => 'Tuffnells',
                'sku' => 'BIK-EP-01-BLK-GLD',
                'stock' => true,
                'product_type' => 'product',
                'image' => 'products/racer-black.jpg',
                'color' => ' Black/Gold',
                'weight_unit' => '20',
            ]
        );
        Product::updateOrCreate(
            [
                'sku' => 'BIK-EP-01-BLK-RED'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Equinox Pro Black/Red',
                'shipping_method' => 'Tuffnells',
                'sku' => 'BIK-EP-01-BLK-RED',
                'stock' => true,
                'product_type' => 'product',
                'image' => 'products/racer-black-red.jpg',
                'color' => 'Black/Red',
                'weight_unit' => '20',
            ]
        );
        Product::updateOrCreate(
            [
                'sku' => 'BIK-EP-01-WHT-RED'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Equinox Pro White/Red',
                'shipping_method' => 'Tuffnells',
                'sku' => 'BIK-EP-01-WHT-RED',
                'stock' => true,
                'product_type' => 'product',
                'image' => 'products/racer-white-red.jpg',
                'color' => 'White/Red',
                'weight_unit' => '20',
            ]
        );


        Product::updateOrCreate(
            [
                'sku' => 'CAR-MCD-01-BLK'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Mercedes Black',
                'shipping_method' => 'Tuffnells',
                'sku' => 'CAR-MCD-01-BLK',
                'stock' => true,
                'product_type' => 'product',
                'image' => 'products/mercedes-black.jpg',
                'color' => 'Black',
                'weight_unit' => '15',
            ]
        );
        Product::updateOrCreate(
            [
                'sku' => 'CAR-MCD-01-WHT'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Mercedes WHT',
                'shipping_method' => 'Tuffnells',
                'sku' => 'CAR-MCD-01-WHT',
                'stock' => true,
                'product_type' => 'product',
                'image' => 'products/mercedes-black.jpg',
                'color' => 'White',
                'weight_unit' => '15',
            ]
        );
        Product::updateOrCreate(
            [
                'sku' => 'CAR-MCD-01-RED'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Mercedes Red',
                'shipping_method' => 'Tuffnells',
                'sku' => 'CAR-MCD-01-RED',
                'stock' => true,
                'product_type' => 'product',
                'image' => 'products/mercedes-red.jpg',
                'color' => 'Red',
                'weight_unit' => '15',
            ]
        );
        Product::updateOrCreate(
            [
                'sku' => 'CAR-AUD-01-YEL'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Audi Yellow',
                'shipping_method' => 'Tuffnells',
                'sku' => 'CAR-Aud-01-YEL',
                'stock' => true,
                'product_type' => 'product',
                'image' => 'products/audi-yellow.jpg',
                'color' => 'Yellow',
                'weight_unit' => '15',
            ]
        );
        Product::updateOrCreate(
            [
                'sku' => 'CAR-AUD-01-RED'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Audi Red',
                'shipping_method' => 'Tuffnells',
                'sku' => 'CAR-AUD-01-RED',
                'stock' => true,
                'product_type' => 'product',
                'image' => 'products/audi-red.jpg',
                'color' => 'Red',
                'weight_unit' => '15',
            ]
        );

        Product::updateOrCreate(
            [
                'sku' => 'CAR-AUD-01-WHT'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Audi White',
                'shipping_method' => 'Tuffnells',
                'sku' => 'CAR-AUD-01-WHT',
                'stock' => true,
                'product_type' => 'product',
                'image' => 'products/audi-white.jpg',
                'color' => 'White',
                'weight_unit' => '15',
            ]
        );
        Product::updateOrCreate(
            [
                'sku' => 'JEP-X01-BLK'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Jeep Black',
                'shipping_method' => 'Tuffnells',
                'sku' => 'JEP-X01-BLK',
                'stock' => true,
                'product_type' => 'product',
                'image' => 'products/jeep-black.jpg',
                'color' => 'Black',
                'weight_unit' => '15',
            ]
        );
        Product::updateOrCreate(
            [
                'sku' => 'JEP-X01-RED'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Jeep Red',
                'shipping_method' => 'Tuffnells',
                'sku' => 'JEP-X01-RED',
                'image' => 'products/jeep-red.jpg',
                'stock' => true,
                'product_type' => 'product',
                'color' => 'Red',
                'weight_unit' => '15',
            ]
        );
        Product::updateOrCreate(
            [
                'sku' => 'JEP-X01-WHT'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Jeep White',
                'shipping_method' => 'Tuffnells',
                'sku' => 'JEP-X01-WHT',
                'image' => 'products/jeep-white.jpg',
                'stock' => true,
                'product_type' => 'product',
                'color' => 'White',
                'weight_unit' => '15',
            ]
        );
        Product::updateOrCreate(
            [
                'sku' => 'WHL-X0-lRG'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Wheel Abbs D004 Large',
                'shipping_method' => 'Tuffnells',
                'sku' => 'WHL-X0-lRG',
                'image' => 'products/wheel-abbs-d004-large.jpg',
                'stock' => true,
                'product_type' => 'product',
                'weight_unit' => '5',
            ]
        );
        Product::updateOrCreate(
            [
                'sku' => 'WHL-X0-SML'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Wheel Abbs Small',
                'shipping_method' => 'Tuffnells',
                'sku' => 'WHL-X0-SML',
                'image' => 'products/wheel-abbs-small.jpg',
                'stock' => true,
                'product_type' => 'product',
                'weight_unit' => '5',
            ]
        );
        Product::updateOrCreate(
            [
                'sku' => 'WHL-X0-LRG'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Wheel Abbs LRG',
                'shipping_method' => 'Tuffnells',
                'sku' => 'WHL-X0-lRG',
                'image' => 'products/wheel-abbs-d004-large.jpg',
                'stock' => true,
                'product_type' => 'product',
                'weight_unit' => '5',
            ]
        );

        Product::updateOrCreate(
            [
                'sku' => 'NKC-MCG1-GUN'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Neck massage',
                'shipping_method' => 'Tuffnells',
                'image' => 'products/neck-massage.jpg',
                'sku' => 'NKC-MCG1-GUN',
                'stock' => true,
                'product_type' => 'product',
                'weight_unit' => '3',
            ]
        );
        Product::updateOrCreate(
            [
                'sku' => 'DCM-CM1-CMR'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Drone Camera',
                'shipping_method' => 'Tuffnells',
                'image' => 'products/drone-camera.jpg',
                'sku' => 'DCM-CM1-CMR',
                'stock' => true,
                'product_type' => 'product',
                'weight_unit' => '5',
            ]
        );


        Product::updateOrCreate(
            [
                'sku' => 'ABC-CR1-CRN'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Abs Crunch',
                'shipping_method' => 'Tuffnells',
                'image' => 'products/wheel-abbs-d004-large.jpg',
                'sku' => 'ABC-CR1-CRN',
                'stock' => true,
                'product_type' => 'product',
                'weight_unit' => '5',
            ]
        );

        Product::updateOrCreate(
            [
                'sku' => 'GRD-TL1-BLK'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Garden Tool',
                'shipping_method' => 'Tuffnells',
                'image' => 'products/zah-z1-garden-tool.jpg',
                'sku' => 'GRD-TL1-BLK',
                'stock' => true,
                'product_type' => 'product',
                'weight_unit' => '5',
            ]
        );
        Product::updateOrCreate(
            [
                'sku' => 'PLT-V1-BLK'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Vibration Plate Black',
                'shipping_method' => 'Tuffnells',
                'sku' => 'PLT-V1-BLK',
                'stock' => true,
                'product_type' => 'product',
                'weight_unit' => '5',
            ]
        );
        Product::updateOrCreate(
            [
                'sku' => 'PLT-V1-RED'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Vibration Plate Red',
                'shipping_method' => 'Tuffnells',
                'sku' => 'PLT-V1-RED',
                'stock' => true,
                'product_type' => 'product',
                'weight_unit' => '5',
            ]
        );


        Product::updateOrCreate(
            [
                'sku' => 'PLT-V1-BlU'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Vibration Plate Blue',
                'shipping_method' => 'Tuffnells',
                'sku' => 'PLT-V1-BlU',
                'stock' => true,
                'product_type' => 'product',
                'image' => 'products/vibration-plate-blue.jpg',
                'weight_unit' => '5',
            ]
        );
        Product::updateOrCreate(
            [
                'sku' => 'PLT-V1-PNK'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Vibration Plate Pink',
                'shipping_method' => 'Tuffnells',
                'sku' => 'PLT-V1-PNK',
                'stock' => true,
                'product_type' => 'product',
                'image' => 'products/vibration-plate-pink.jpg',
                'weight_unit' => '5',
            ]
        );
        Product::updateOrCreate(
            [
                'sku' => 'KCH-X01-GRY'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Exploding Kittens',
                'shipping_method' => 'Tuffnells',
                'sku' => 'KCH-X01-GRY',
                'stock' => true,
                'product_type' => 'product',
                'weight_unit' => '5',
            ]
        );

        Product::updateOrCreate(
            [
                'sku' => 'TST-X01-RED'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Test',
                'shipping_method' => 'Tuffnells',
                'sku' => 'TST-X01-RED',
                'stock' => true,
                'product_type' => 'product',
                'weight_unit' => '1',
            ]
        );
        Product::updateOrCreate(
            [
                'sku' => 'SPN-HD1-BLK'
            ],
            [
                'company_id' => $companyId,
                'name' => 'HD1 Black',
                'shipping_method' => 'Tuffnells',
                'sku' => 'SPN-HD1-BLK',
                'stock' => true,
                'product_type' => 'product',
                'weight_unit' => '25',
            ]
        );

        Product::updateOrCreate(
            [
                'sku' => 'ECT-E01-BLK'
            ],
            [
                'company_id' => $companyId,
                'name' => 'E1 Black',
                'shipping_method' => 'Tuffnells',
                'sku' => 'ECT-E01-BLK',
                'stock' => true,
                'product_type' => 'product',
                'weight_unit' => '25',
            ]
        );


        Product::updateOrCreate(
            [
                'sku' => 'SNT-HSG1-2L'
            ],
            [
                'company_id' => $companyId,
                'name' => 'Organix Sanitiser',
                'shipping_method' => 'Tuffnells',
                'image' => 'products/oroganix-sanitiser.jpg',
                'sku' => 'SNT-HSG1-2L',
                'stock' => true,
                'product_type' => 'product',
                'weight_unit' => '2',
            ]
        );
        Product::updateOrCreate(
            [
                'sku' => 'VMP-VP1-BLK'
            ],
            [
                'company_id' => $companyId,
                'name' => 'VP1 Black',
                'shipping_method' => 'Tuffnells',
                'sku' => 'VMP-VP1-BLK',
                'stock' => true,
                'product_type' => 'product',
                'weight_unit' => '5',
            ]
        );
        Product::updateOrCreate(
            [
                'sku' => 'VMP-RV1-BLK'
            ],
            [
                'company_id' => $companyId,
                'name' => 'RV1 Black',
                'shipping_method' => 'Tuffnells',
                'sku' => 'VMP-RV1-BLK',
                'stock' => true,
                'product_type' => 'product',
                'weight_unit' => '5',
            ]
        );
    }
}
