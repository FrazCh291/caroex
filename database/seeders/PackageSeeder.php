<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $package = Package::updateOrCreate([
            'name' => 'Pro',
        ], [
            'name' => 'Pro',
            'price' => 800,
            'is_one_time' => 1,
            'duration' => 30,
            'number_of_user' => 20,
            'status' => 1
        ]);

        $moduleIds = Module::all()->pluck('id')->toArray();
        $package->modules()->attach($moduleIds);

        $package = Package::updateOrCreate([
            'name' => 'Basic',
        ], [
            'price' => 500,
            'is_one_time' => 1,
            'duration' => 30,
            'number_of_user' => 20,
            'status' => 1
        ]);
        $moduleIdss = Module::all()->random(5)->pluck('id')->toArray();
        $package->modules()->attach($moduleIdss);
    }
}
