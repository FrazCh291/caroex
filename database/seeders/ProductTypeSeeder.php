<?php

namespace Database\Seeders;

use App\Models\Lookup;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Lookup::firstOrCreate(['slug' => 'product_type'], [
            'type' => 'product_type',
            'value' => 'Fashion',
            'slug' => 'fashion',
            'order' => 1,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'product_type'], [
            'type' => 'product_type',
            'value' => 'Fitness',
            'slug' => 'fitness',
            'order' => 2,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'product_type'], [
            'type' => 'product_type',
            'value' => 'Health and Beauty',
            'slug' => 'health_beauty',
            'order' => 3,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        Lookup::firstOrCreate(['slug' => 'product_type'], [
            'type' => 'product_type',
            'value' => 'Home',
            'slug' => 'home',
            'order' => 4,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'product_type'], [
            'type' => 'product_type',
            'value' => 'Phones and Accessories',
            'slug' => 'phones_accessories',
            'order' => 5,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'product_type'], [
            'type' => 'product_type',
            'value' => 'Toys',
            'slug' => 'toys',
            'order' => 6,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        Lookup::firstOrCreate(['slug' => 'product_type'], [
            'type' => 'product_type',
            'value' => 'Travel',
            'slug' => 'travel',
            'order' => 7,
            'enable' => true,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
