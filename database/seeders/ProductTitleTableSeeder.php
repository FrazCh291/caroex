<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Product;
use App\Models\ProductTitle;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProductTitleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companyId = Company::updateOrCreate(['name' => 'Alfa Mohuha'])->id;

        $product = Product::where('name', 'E-bykka Red')->first();
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Pedal Bicycle Ebykka Jasiq Folding Bike Carbon Steel – Red Cycle - Red',
        ], [
            'product_title' => 'Pedal Bicycle Ebykka Jasiq Folding Bike Carbon Steel – Red Cycle - Red',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'T3 Gold')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Tornado T3 Exercise Spin Bike Limited Edition',
        ], [
            'product_title' => 'Tornado T3 Exercise Spin Bike Limited Edition',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);

        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'T3 Red')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'TORNADO T3 EXERCISE SPIN BIKE - RED',
        ], [
            'product_title' => 'TORNADO T3 EXERCISE SPIN BIKE - RED',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);

        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'E-bykka Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Swift Foldable Pedal Bike 26" - Black',
        ], [
            'product_title' => 'Swift Foldable Pedal Bike 26" - Black',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'E-bykka Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Swift Foldable Pedal Bike 26' . '' . '- Black',
        ], [
            'product_title' => 'Swift Foldable Pedal Bike 26' . '' . '- Black',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);

        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'A6 Basic')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Billna A6 Basic Electric Treadmill Folding Running Machine',
        ], [
            'product_title' => 'Billna A6 Basic Electric Treadmill Folding Running Machine',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);

        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'A6 Basic')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Billna A6 Pro-Runner Foldable Treadmill - 2 Options',
        ], [
            'product_title' => 'Billna A6 Pro-Runner Foldable Treadmill - 2 Options',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);

        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'A6 Basic')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Billna A6 Pro-Runner Foldable Treadmill with Massager and Multi-Gym',
        ], [
            'product_title' => 'Billna A6 Pro-Runner Foldable Treadmill with Massager and Multi-Gym',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);

        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'A6 Basic')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Billna A6 Pro-Runner Foldable Treadmill, Massager & Multi-Gym',
        ], [
            'product_title' => 'Billna A6 Pro-Runner Foldable Treadmill, Massager & Multi-Gym',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);

        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'A6 Basic')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Billna A6 Runner Foldable Treadmill - 2 Options',
        ], [
            'product_title' => 'Billna A6 Runner Foldable Treadmill - 2 Options',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);

        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'A6 Basic')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Billna A6 Runner Foldable Treadmill',
        ], [
            'product_title' => 'Billna A6 Runner Foldable Treadmill',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);


        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'A6 Basic')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Foldable Electric Treadmill + Massager and Multi-Gym',
        ], [
            'product_title' => 'Foldable Electric Treadmill + Massager and Multi-Gym',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);


        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'XF Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Pulse XF Foldable Electric Treadmill Running Machine - BLACK"',
        ], [
            'product_title' => 'Pulse XF Foldable Electric Treadmill Running Machine - BLACK"',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);

        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'XF Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Ejogga Pulse XF Foldable Electric Treadmill - 2 Colours',
        ], [
            'product_title' => 'Ejogga Pulse XF Foldable Electric Treadmill - 2 Colours',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);


        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'A6 Multi')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Billna A6 Foldable Treadmill Multi Function',
        ], [
            'product_title' => 'Billna A6 Foldable Treadmill Multi Function',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'A6 Basic')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Billna A6 Foldable Treadmill',
        ], [
            'product_title' => 'Billna A6 Foldable Treadmill',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);


        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Q4 flex Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'X-Trainer Elliptical Cross Trainer by Xstream Gym - 2 Colours',
        ], [
            'product_title' => ' X-Trainer Elliptical Cross Trainer by Xstream Gym - 2 Colours',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);

        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Q4 flex Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Abs Fitness Core and Abdominal Trainer Machine',
        ], [
            'product_title' => 'Abs Fitness Core and Abdominal Trainer Machine',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);


        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Q4 flex Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Quad Flex Q4 Electric Treadmill Motorised Running Machine - Black',
        ], [
            'product_title' => 'Quad Flex Q4 Electric Treadmill Motorised Running Machine - Black',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);

        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Q4 flex Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'eJogga Pulse Folding Electric Treadmill',
        ], [
            'product_title' => 'eJogga Pulse Folding Electric Treadmill',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Q4 flex Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'eJogga Pulse Folding Electric Treadmill - 2 Colours',
        ], [
            'product_title' => 'eJogga Pulse Folding Electric Treadmill - 2 Colours',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);


        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Q4 flex Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'eJogga Pulse Folding Electric Treadmill - 2 Colours',
        ], [
            'product_title' => 'eJogga Pulse Folding Electric Treadmill - 2 Colours',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);

        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Racer White')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'EQUINOX PRO RACE BIKE 21 GEAR CARBON STEEL - White',
        ], [
            'product_title' => 'EQUINOX PRO RACE BIKE 21 GEAR CARBON STEEL - White',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Racer Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'EQUINOX PRO RACE BIKE 21 GEAR CARBON STEEL - Black',
        ], [
            'product_title' => 'EQUINOX PRO RACE BIKE 21 GEAR CARBON STEEL - Black',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Racer Red')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'EQUINOX PRO RACE BIKE 21 GEAR CARBON STEEL - Red',
        ], [
            'product_title' => 'EQUINOX PRO RACE BIKE 21 GEAR CARBON STEEL - Red',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'X2 Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Hurricane X2 Chunk Exercise Spin Bike - Black',
        ], [
            'product_title' => 'Hurricane X2 Chunk Exercise Spin Bike - Black',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);


        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'X2 Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Black Hurricane X2 Spinning Exercise Bike - 12kg Fly Wheels, LCD Display & Adjustable Resistance',
        ], [
            'product_title' => 'Black Hurricane X2 Spinning Exercise Bike - 12kg Fly Wheels, LCD Display & Adjustable Resistance',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);


        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Q4 flex Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'QUAD FLEX Q4 ELECTRIC FOLDING TREADMILL RUNNING MACHINE - Black',
        ], [
            'product_title' => 'QUAD FLEX Q4 ELECTRIC FOLDING TREADMILL RUNNING MACHINE - Black',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'E-bykka Red')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Ebykka Jasiq Pedal Bicycle Folding Carbon Steel 21 Gear - Red',
        ], [
            'product_title' => 'Ebykka Jasiq Pedal Bicycle Folding Carbon Steel 21 Gear - Red',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'E-bykka Red')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Folding Steel Suspension Pedal Bicycle - 2 Colours',
        ], [
            'product_title' => 'Folding Steel Suspension Pedal Bicycle - 2 Colours',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);

        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'E-bykka Red')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Folding Steel Suspension Pedal Bicycle',
        ], [
            'product_title' => 'Folding Steel Suspension Pedal Bicycle',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);


        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'E-Glide Light')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'EJOGGA GLIDE TREADMILL MACHINE WITH MEDIA',
        ], [
            'product_title' => 'EJOGGA GLIDE TREADMILL MACHINE WITH MEDIA',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Racer Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Sanhema Road Racing Bike Carbon Steel 26" Black - Black',
        ], [
            'product_title' => 'Sanhema Road Racing Bike Carbon Steel 26" Black - Black',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Racer White')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Sanhema Road Racing Bike 21 Gear Carbon Steel  26â€³ White - White',
        ], [
            'product_title' => 'Sanhema Road Racing Bike 21 Gear Carbon Steel  26â€³ White - White',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Racer White')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Sanhema Road Racing Bike Carbon Steel 26" Black - White',
        ], [
            'product_title' => 'Sanhema Road Racing Bike Carbon Steel 26" Black - White',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);

        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Racer White')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Sanhema Road Racing Bike',
        ], [
            'product_title' => 'Sanhema Road Racing Bike',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Racer White')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Sanhema Road Racing Bike 21 Gear Carbon Steel  26″ White - Black',
        ], [
            'product_title' => 'Sanhema Road Racing Bike 21 Gear Carbon Steel  26″ White - Black',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'XF Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'PULSE XF FOLDABLE ELECTRIC TREADMIL RUNNING MACHINE',
        ], [
            'product_title' => 'PULSE XF FOLDABLE ELECTRIC TREADMIL RUNNING MACHINE',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Breeze B3')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'BREEZE B3 WALKING PAD TREADMILL RUNNING EXERCISE MACHINE',
        ], [
            'product_title' => 'BREEZE B3 WALKING PAD TREADMILL RUNNING EXERCISE MACHINE',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'A6 Multi')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Billna A6 Multi Function Electric Treadmill Folding Running Machine',
        ], [
            'product_title' => 'Billna A6 Multi Function Electric Treadmill Folding Running Machine',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);

        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'A6 Multi')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'A6 Multi',
        ], [
            'product_title' => 'A6 Multi',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Q4 flex White')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'QUAD FLEX Q4 ELECTRIC FOLDING TREADMILL RUNNING MACHINE - White',
        ], [
            'product_title' => 'QUAD FLEX Q4 ELECTRIC FOLDING TREADMILL RUNNING MACHINE - White',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'P1 T600')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'DYNAMO PRO P1 EXERCISE TREADMILL RUNNING MACHINE',
        ], [
            'product_title' => 'DYNAMO PRO P1 EXERCISE TREADMILL RUNNING MACHINE',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);

        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'P1 T600')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Dynamo Pro P1 12-Programme Treadmill',
        ], [
            'product_title' => 'Dynamo Pro P1 12-Programme Treadmill',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);

        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'X4 Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Hurricane X4 Spinning Exercise Bike Xstream Gym',
        ], [
            'product_title' => 'Hurricane X4 Spinning Exercise Bike Xstream Gym',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);


        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'T3 Gold')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'TORNADO T3 EXERCISE SPIN BIKE - GOLD',
        ], [
            'product_title' => 'TORNADO T3 EXERCISE SPIN BIKE - GOLD',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Racer White')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'EQUINOX PRO - White',
        ], [
            'product_title' => 'EQUINOX PRO - White',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'A6 Basic')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'BILLNA RUNNING MACHINE A6 BASIC FOLDABLE TREADMILL',
        ], [
            'product_title' => 'BILLNA RUNNING MACHINE A6 BASIC FOLDABLE TREADMILL',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'E-bykka Red')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'PEDAL BICYCLE EBYKKA JASIQ FOLDING BIKE CARBON STEEL – RED CYCLE',
        ], [
            'product_title' => 'PEDAL BICYCLE EBYKKA JASIQ FOLDING BIKE CARBON STEEL – RED CYCLE',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'E-bykka Red')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Pedal Bicycle Ebykka Jasiq Folding Bike Carbon Steel â€“ Red Cycle - Red',
        ], [
            'product_title' => 'Pedal Bicycle Ebykka Jasiq Folding Bike Carbon Steel â€“ Red Cycle - Red',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);


        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'E-bykka Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'PEDAL BICYCLE EBYKKA JASIQ FOLDING BIKE CARBON STEEL – BLACK CYCLE',
        ], [
            'product_title' => 'PEDAL BICYCLE EBYKKA JASIQ FOLDING BIKE CARBON STEEL – BLACK CYCLE',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Racer White')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'SANHEMA ROAD RACING BIKE 21 GEARS CARBON STEEL 26″ FRAME – WHITE',
        ], [
            'product_title' => 'SANHEMA ROAD RACING BIKE 21 GEARS CARBON STEEL 26″ FRAME – WHITE',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Racer Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'SANHEMA ROAD RACING BIKE 21 GEARS CARBON STEEL 26″ FRAME – BLACK',
        ], [
            'product_title' => 'SANHEMA ROAD RACING BIKE 21 GEARS CARBON STEEL 26″ FRAME – BLACK',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'X2 Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'X2 HURRICANE CHUNK EXERCISE SPIN BIKE – BLACK',
        ], [
            'product_title' => 'X2 HURRICANE CHUNK EXERCISE SPIN BIKE – BLACK',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);

        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'X2 Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Hurricane X2 Spinning Exercise Bike - 3 Colours',
        ], [
            'product_title' => 'Hurricane X2 Spinning Exercise Bike - 3 Colours',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'T3 Red')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'TORNADO T3 SPINNING EXERCISE BIKE',
        ], [
            'product_title' => 'TORNADO T3 SPINNING EXERCISE BIKE',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        //        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        //        $product = Product::where('name', '')->first();
        //        ProductTitle::firstOrCreate([
        //            'product_title' => '',
        //        ], [
        //            'product_title' => '',
        //            'product_id' => $product->id,
        //            'id' => $productTitle ? $productTitle->id + 1 : 1,

        //        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'A6 Basic')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Billna A6 Basic Foldable Electric Treadmill by eJogga',
        ], [
            'product_title' => 'Billna A6 Basic Foldable Electric Treadmill by eJogga',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);

        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'A6 Basic')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Billna A6 Pro-Runner Foldable Treadmill',
        ], [
            'product_title' => 'Billna A6 Pro-Runner Foldable Treadmill',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);


        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'E-bykka Red')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'High Carbon Foldable Mountain Bike',
        ], [
            'product_title' => 'High Carbon Foldable Mountain Bike',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);

        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'E-bykka Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'High Carbon Foldable Mountain Bike - 2 Colours',
        ], [
            'product_title' => 'High Carbon Foldable Mountain Bike - 2 Colours',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);

        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'E-bykka Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Swift Foldable Pedal Bike 26″ - Black',
        ], [
            'product_title' => 'Swift Foldable Pedal Bike 26″ - Black',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'P1 T600')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Dynamo Pro P1 - Treadmill Running Machine - 12 Speed - 12km/ph Pulse Reader Inc',
        ], [
            'product_title' => 'Dynamo Pro P1 - Treadmill Running Machine - 12 Speed - 12km/ph Pulse Reader Inc',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'E-bykka Red')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Swift Foldable Pedal Bike 26″ - Red',
        ], [
            'product_title' => 'Swift Foldable Pedal Bike 26″ - Red',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'X2 Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Hurricane X2 Chunk Spinning Bike Cycling Machine - BLACK COLOUR',
        ], [
            'product_title' => 'Hurricane X2 Chunk Spinning Bike Cycling Machine - BLACK COLOUR',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'A6 Multi')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Billna A6 Multi- Gym-Function Foldable Electric Motorised Treadmill by eJogga',
        ], [
            'product_title' => 'Billna A6 Multi- Gym-Function Foldable Electric Motorised Treadmill by eJogga',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Wheel Abbs Small')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Abs Cruncher Workout Fitness Core & Abdominal Trainers Machine Home Gym Strength',
        ], [
            'product_title' => 'Abs Cruncher Workout Fitness Core & Abdominal Trainers Machine Home Gym Strength',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'X2 Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'X2 Hurricane Chunk Exercise Spin Bike - Black',
        ], [
            'product_title' => 'X2 Hurricane Chunk Exercise Spin Bike - Black',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Q4 flex Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Quad Flex Q4 Treadmill Running Machine - Black',
        ], [
            'product_title' => 'Quad Flex Q4 Treadmill Running Machine - Black',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);


        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Q4 flex Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Quad Flex Q4 Treadmill',
        ], [
            'product_title' => 'Quad Flex Q4 Treadmill',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'E-bykka Red')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Pedal Bicycle Ebykka Jasiq Folding Bike Carbon Steel - Red Cycle',
        ], [
            'product_title' => 'Pedal Bicycle Ebykka Jasiq Folding Bike Carbon Steel - Red Cycle',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Neck massage')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Massage Gun Cordless Rechargeable Deep Tissue Massager - Body Massager',
        ], [
            'product_title' => 'Massage Gun Cordless Rechargeable Deep Tissue Massager - Body Massager',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'E-bykka Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Pedal Bicycle Ebykka Jasiq Folding Bike Carbon Steel - Black Cycle',
        ], [
            'product_title' => 'Pedal Bicycle Ebykka Jasiq Folding Bike Carbon Steel - Black Cycle',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'X Trainer White')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'X - Trainer Elliptical Cross Training Treadmill Machine - White',
        ], [
            'product_title' => 'X - Trainer Elliptical Cross Training Treadmill Machine - White',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'X Trainer Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'X - Trainer Elliptical Cross Training Treadmill Machine - Black',
        ], [
            'product_title' => 'X - Trainer Elliptical Cross Training Treadmill Machine - Black',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);

        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Vibration Plate Blue')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'eJogga Massage Vibration Standing Plate - Blue',
        ], [
            'product_title' => 'eJogga Massage Vibration Standing Plate - Blue',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);

        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Vibration Plate Blue')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'VIBRATION PLATE FIT BODY CRAZY SHAKER MASSAGE FITNESS MACHINE OSCILLATING POWER',
        ], [
            'product_title' => 'VIBRATION PLATE FIT BODY CRAZY SHAKER MASSAGE FITNESS MACHINE OSCILLATING POWER',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);


        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'X7 Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Spin Exercise Bike Blaze X7 With  Screen & Live Classes',
        ], [
            'product_title' => 'Spin Exercise Bike Blaze X7 With  Screen & Live Classes',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Vibration Plate Pink')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'eJogga Massage Vibration Standing Plate - Pink',
        ], [
            'product_title' => 'eJogga Massage Vibration Standing Plate - Pink',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Q4 flex Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Quad Flex Q4 Treadmill Running Machine - Black"',
        ], [
            'product_title' => 'Quad Flex Q4 Treadmill Running Machine - Black"',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'X Trainer Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'X - Trainer Elliptical Cross Training Machine - Black "',
        ], [
            'product_title' => 'X - Trainer Elliptical Cross Training Machine - Black "',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);

        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'X Trainer Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'ELLIPTICAL CROSS TRAINER BODY TRAINING MACHINE',
        ], [
            'product_title' => 'ELLIPTICAL CROSS TRAINER BODY TRAINING MACHINE',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);

        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'X Trainer Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'ELLIPTICAL CROSS TRAINER BODY TRAINING MACHINE',
        ], [
            'product_title' => 'ELLIPTICAL CROSS TRAINER BODY TRAINING MACHINE',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);

        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'E-bykka Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Pedal Bicycle Ebykka Jasiq Folding Bike Carbon Steel - Black Cycle - BLACK"',
        ], [
            'product_title' => 'Pedal Bicycle Ebykka Jasiq Folding Bike Carbon Steel - Black Cycle - BLACK"',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Vibration Plate Blue')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'eJogga Vibration Plate Blue Slim Exercise Body Shaper Train Massage Oscillate Fitness Machine',
        ], [
            'product_title' => 'eJogga Vibration Plate Blue Slim Exercise Body Shaper Train Massage Oscillate Fitness Machine',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);


        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Vibration Plate Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'REASEJOY 500W VIBRATION PLATE CRAZY COMPATIBLE WITH MASSAGE EXERCISE MACHINE OSCILLATING PLATFORM BLACK',
        ], [
            'product_title' => 'REASEJOY 500W VIBRATION PLATE CRAZY COMPATIBLE WITH MASSAGE EXERCISE MACHINE OSCILLATING PLATFORM BLACK',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Vibration Plate Pink')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'eJogga Vibration Plate Pink Slim Exercise Body Shaper Train Massage Oscillate Fitness Machine',
        ], [
            'product_title' => 'eJogga Vibration Plate Pink Slim Exercise Body Shaper Train Massage Oscillate Fitness Machine',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'X Trainer White')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'X - Trainer Elliptical Cross Training Machine - " White',
        ], [
            'product_title' => 'X - Trainer Elliptical Cross Training Machine - " White',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'E-bykka Red')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Pedal Bicycle Ebykka Jasiq Folding Bike Carbon Steel - Red Cycle - BLACK"',
        ], [
            'product_title' => 'Pedal Bicycle Ebykka Jasiq Folding Bike Carbon Steel - Red Cycle - BLACK"',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);

        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'E-bykka Red')->first();
        ProductTitle::firstOrCreate([
            'product_title' => '(5F59FC4F51D51) A foldable bike',
        ], [
            'product_title' => '(5F59FC4F51D51) A foldable bike',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);

        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Neck massage')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Massage Gun Drill Cordless Rechargeable Deep Tissue Massager Portable Massage Device Massage Body',
        ], [
            'product_title' => 'Massage Gun Drill Cordless Rechargeable Deep Tissue Massager Portable Massage Device Massage Body',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'P1 T600')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Dynamo Pro P1 Exercise Running Machine Treadmill',
        ], [
            'product_title' => 'Dynamo Pro P1 Exercise Running Machine Treadmill',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'E-bykka Red')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Pedal Bicycle Ebykka Jasiq Folding Bike Carbon Steel - Red Cycle - "RED',
        ], [
            'product_title' => 'Pedal Bicycle Ebykka Jasiq Folding Bike Carbon Steel - Red Cycle - "RED',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Racer White')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Sanhema Road Racing Bike 21 Gears Carbon Steel 26" Frame - White',
        ], [
            'product_title' => 'Sanhema Road Racing Bike 21 Gears Carbon Steel 26" Frame - White',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Racer White')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Road Racing Bike',
        ], [
            'product_title' => 'Road Racing Bike',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);


        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'XF White')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Pulse XF Foldable Electric Treadmill Running Machine - "WHITE',
        ], [
            'product_title' => 'Pulse XF Foldable Electric Treadmill Running Machine - "WHITE',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Racer Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Sanhema Road Racing Bike 21 Gears Carbon Steel 26" Frame',
        ], [
            'product_title' => 'Sanhema Road Racing Bike 21 Gears Carbon Steel 26" Frame',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'E-bykka Red')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Pedal Bicycle Ebykka Jasiq Folding Bike Carbon Steel - Cycle - "RED',
        ], [
            'product_title' => 'Pedal Bicycle Ebykka Jasiq Folding Bike Carbon Steel - Cycle - "RED',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'E-bykka Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Pedal Bicycle Ebykka Jasiq Folding Bike Carbon Steel - Cycle - BLACK"',
        ], [
            'product_title' => 'Pedal Bicycle Ebykka Jasiq Folding Bike Carbon Steel - Cycle - BLACK"',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Q4 flex Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Quad Flex Q4 Treadmill Running Machine',
        ], [
            'product_title' => 'Quad Flex Q4 Treadmill Running Machine',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'X2 Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'X2 Hurricane Chunk Spin Exercise Bike',
        ], [
            'product_title' => 'X2 Hurricane Chunk Spin Exercise Bike',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'A6 Basic')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Billna A6 Basic Foldable Treadmill',
        ], [
            'product_title' => 'Billna A6 Basic Foldable Treadmill',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'X2 Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'X2 Hurricane Chunk Spin Exercise Bike - Black',
        ], [
            'product_title' => 'X2 Hurricane Chunk Spin Exercise Bike - Black',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'X2 Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'X2 - Hurricane',
        ], [
            'product_title' => 'X2 - Hurricane',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'X2 Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'X2 - Hurricane - Black',
        ], [
            'product_title' => 'X2 - Hurricane - Black',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'A6 Basic')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'An A6 foldable electric treadmill pro-runner',
        ], [
            'product_title' => 'An A6 foldable electric treadmill pro-runner',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'A6 Multi')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'TREADMILL & MASSAGE SET: An A6 foldable electric treadmill pro-runner',
        ], [
            'product_title' => 'TREADMILL & MASSAGE SET: An A6 foldable electric treadmill pro-runner',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Breeze B3')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'BREEZE B3 - A Walking Pad Treadmill',
        ], [
            'product_title' => 'BREEZE B3 - A Walking Pad Treadmill',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Garden Tool')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Multipurpose garden hedge trimmer set',
        ], [
            'product_title' => 'Multipurpose garden hedge trimmer set',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);

        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'P1 T600')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'A Dynamo Pro P1 treadmill',
        ], [
            'product_title' => 'A Dynamo Pro P1 treadmill',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);

        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Racer Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'BLACK: A road racer cycle',
        ], [
            'product_title' => 'BLACK: A road racer cycle',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Racer Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => '(5F6484BE5D0EC) A road racer cycle',
        ], [
            'product_title' => '(5F6484BE5D0EC) A road racer cycle',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Racer White')->first();

        ProductTitle::firstOrCreate([
            'product_title' => 'WHITE: A road racer cycle',
        ], [
            'product_title' => 'WHITE: A road racer cycle',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'X2 Black')->first();

        ProductTitle::firstOrCreate([
            'product_title' => 'X2: A Hurricane X2 spinning exercise bike with 12kg fly wheels',
        ], [
            'product_title' => 'X2: A Hurricane X2 spinning exercise bike with 12kg fly wheels',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Audi Red')->first();

        ProductTitle::firstOrCreate([
            'product_title' => 'BING BANG BOSH Electric Cars For Kids Ride On Jeep Wrangler With Parents Remote Control & LED Lights&#x2502; Children &#x2502; Boys &#x2502;Girls &#x2502;12v Battery (White)',
        ], [
            'product_title' => 'BING BANG BOSH Electric Cars For Kids Ride On Jeep Wrangler With Parents Remote Control & LED Lights&#x2502; Children &#x2502; Boys &#x2502;Girls &#x2502;12v Battery (White)',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Drone Camera')->first();

        ProductTitle::firstOrCreate([
            'product_title' => 'BIG BANG BOSH RC X-CAM 720P HD Camera, Best Drone for Beginners With Headless Mode, Fully Remote Controlled, 2.4Ghz Radio, Flexible Landing Skids, 380 x 380 x 100mm, Suitable for Adults (Black)',
        ], [
            'product_title' => 'BIG BANG BOSH RC X-CAM 720P HD Camera, Best Drone for Beginners With Headless Mode, Fully Remote Controlled, 2.4Ghz Radio, Flexible Landing Skids, 380 x 380 x 100mm, Suitable for Adults (Black)',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'X1 White')->first();

        ProductTitle::firstOrCreate([
            'product_title' => 'eBykka Hurricane X1 Spinning Exercise Bike 4 Home & Gym Bicycle Cycling Cardio Fitness Training (White)',
        ], [
            'product_title' => 'eBykka Hurricane X1 Spinning Exercise Bike 4 Home & Gym Bicycle Cycling Cardio Fitness Training (White)',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);

        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'X1 White')->first();

        ProductTitle::firstOrCreate([
            'product_title' => 'Hurricane X1 Exercise Bike With LCD Display - 2 Colours'
        ], [
            'product_title' => 'Hurricane X1 Exercise Bike With LCD Display - 2 Colours',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Racer White')->first();

        ProductTitle::firstOrCreate([
            'product_title' => 'Ebykka Equinox Pro Road Racing Bike - 3 Colours',
        ], [
            'product_title' => 'Ebykka Equinox Pro Road Racing Bike - 3 Colours',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);


        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'X1 White')->first();

        ProductTitle::firstOrCreate([
            'product_title' => 'Hurricane X1 Exercise Bike With LCD Display',
        ], [
            'product_title' => 'Hurricane X1 Exercise Bike With LCD Display',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Exploding Kittens')->first();

        ProductTitle::firstOrCreate([
            'product_title' => 'Imploding Kittens: This is the First Expansion of Exploding Kittens - ENGLISH VERSION',
        ], [
            'product_title' => 'Imploding Kittens: This is the First Expansion of Exploding Kittens - ENGLISH VERSION',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Vibration Plate Blue')->first();

        ProductTitle::firstOrCreate([
            'product_title' => 'ejogga Vibrating Plate Machine, Vibration Plate, Body Shaper Train Massage, Oscillation Vibration Fitness Machine Huge Anti-Slip Surface, Workout Equipment (Blue)',
        ], [
            'product_title' => 'ejogga Vibrating Plate Machine, Vibration Plate, Body Shaper Train Massage, Oscillation Vibration Fitness Machine Huge Anti-Slip Surface, Workout Equipment (Blue)',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Vibration Plate Red')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'ejogga Vibrating Plate Machine, Vibration Plate, Body Shaper Train Massage, Oscillation Vibration Fitness Machine Huge Anti-Slip Surface, Workout Equipment (Red)',
        ], [
            'product_title' => 'ejogga Vibrating Plate Machine, Vibration Plate, Body Shaper Train Massage, Oscillation Vibration Fitness Machine Huge Anti-Slip Surface, Workout Equipment (Red)',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'A6 Multi')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'eJogga Electric Treadmill Running Machine Billna A6 Folding Pro+ Multi Function Cardio Runner & Trainer Motorised Treadmills | Folding Running Machines',
        ], [
            'product_title' => 'eJogga Electric Treadmill Running Machine Billna A6 Folding Pro+ Multi Function Cardio Runner & Trainer Motorised Treadmills | Folding Running Machines',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Audi Red')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Big Bang Bosh Electric Ride-ons Car Kids Audi R8 Spyder 12V Battery, Rechargeable , Parental Remote Control (Red)',
        ], [
            'product_title' => 'Big Bang Bosh Electric Ride-ons Car Kids Audi R8 Spyder 12V Battery, Rechargeable , Parental Remote Control (Red)',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'XF Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'EJOGGA Electric Folding Treadmill Running Machine Pulse Xf Cardio Gym Runner Machine, Motorized Electric Treadmill Cardio - Sports Equipment (Black)',
        ], [
            'product_title' => 'EJOGGA Electric Folding Treadmill Running Machine Pulse Xf Cardio Gym Runner Machine, Motorized Electric Treadmill Cardio - Sports Equipment (Black)',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'X2 Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Xstream Gym Spinning Bike - Indoor Cycling Exercise Bikes For Home Home Use &#x2502; Cardio Workout Machine &#x2502; Heart Rate Monitor &#x2502;12kg Flywheel &#x2502; 1 Year Warranty &#x2502;Hurricane X2 Chunk (Black/Red)',
        ], [
            'product_title' => 'Xstream Gym Spinning Bike - Indoor Cycling Exercise Bikes For Home Home Use &#x2502; Cardio Workout Machine &#x2502; Heart Rate Monitor &#x2502;12kg Flywheel &#x2502; 1 Year Warranty &#x2502;Hurricane X2 Chunk (Black/Red)',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'X2 Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Hurricane X2 Spinning Exercise Bike - 12kg Fly Wheels, LCD Display & Adjustable Resistance!',
        ], [
            'product_title' => 'Hurricane X2 Spinning Exercise Bike - 12kg Fly Wheels, LCD Display & Adjustable Resistance!',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'X2 Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Black Hurricane X2 Spinning Exercise Bike - 12kg Fly Wheels, LCD Display & Adjustable Resistance!',
        ], [
            'product_title' => 'Black Hurricane X2 Spinning Exercise Bike - 12kg Fly Wheels, LCD Display & Adjustable Resistance!',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'X2 Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Black Hurricane X2 Spinning Exercise Bike - 12kg Fly Wheels, LCD Display & Adjustable Resistance',
        ], [
            'product_title' => 'Black Hurricane X2 Spinning Exercise Bike - 12kg Fly Wheels, LCD Display & Adjustable Resistance',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);


        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Test')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Test',
        ], [
            'product_title' => 'Test',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Test')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Test Product',
        ], [
            'product_title' => 'Test Product',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);

        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'Test')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'Demo_Product',
        ], [
            'product_title' => 'Demo_Product',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
        $productTitle = ProductTitle::orderBy('id', 'desc')->first();
        $product = Product::where('name', 'X3 Black')->first();
        ProductTitle::firstOrCreate([
            'product_title' => 'X3 Pro Spinning Exercise Bike',
        ], [
            'product_title' => 'X3 Pro Spinning Exercise Bike',
            'product_id' => $product->id,
            'id' => $productTitle ? $productTitle->id + 1 : 1,
            'company_id' => $companyId,
        ]);
    }
}
