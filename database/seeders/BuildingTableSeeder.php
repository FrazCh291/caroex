<?php

namespace Database\Seeders;

use App\Models\Aisle;
use App\Models\Bin;
use App\Models\Bay;
use App\Models\Section;
use App\Models\Level;
use App\Models\Building;
use Illuminate\Database\Seeder;

class BuildingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $buildingCount = 1;
        $sectionCount = 3;
        $aisleCount = 6;
        $bayCount = 6;
        $levelCount = 4;
        $binCount = 2;

        $buildings = Building::factory()->count($buildingCount)->create();
        foreach ($buildings as $building) {
            $sections = Section::factory()->count($sectionCount)->create();
            foreach ($sections as $section) {
                $aisles = Aisle::factory()->count($aisleCount)->create();
                foreach ($aisles as $aisle) {
                    $bays = Bay::factory()->count($bayCount)->create();
                    foreach ($bays as $bay) {
                        $levels = Level::factory()->count($levelCount)->create();
                        foreach ($levels as $level) {
                            Bin::factory()->count($binCount)->create();
                        }
                    }
                }
            }
        }
    }
}
