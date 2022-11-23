<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bin;
use App\Models\Bay;
use Inertia\Inertia;
use App\Models\Level;
use App\Models\Aisle;
use App\Models\Section;
use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class BinController extends Controller
{
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
                //
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
                $buildingCode = request('building_code');
                $levelId = request('level_id');
                $level = Level::find($levelId);

                return Inertia::render('Building/Bins/Create', ['level' => $level, 'building_code' => $buildingCode]);
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request)
        {
                $buildingCode = request('building_code');
                $levelId = request('level_id');
                $request->validate([
                        'code' => 'required|max:2',
                        'volume' => 'required|numeric|gt:0',
                        'length' => 'required|numeric',
                        'width' => 'required|numeric',
                        'height' => 'required|numeric',
                ]);

                $binExist = Bin::where('level_id', $levelId)->where('code', $request->code)->select('id')->first();
                if ($binExist) {
                        $error = \Illuminate\Validation\ValidationException::withMessages([
                                'code' => 'Bin code ' . $request->code . ' already exist in same Level'
                        ]);
                        throw $error;
                } else {
                        $bin = new Bin();
                        $bin->company_id = Auth::user()->company_id;
                        $bin->name = $request->name;
                        $bin->code = $request->code;
                        $bin->level_id = $levelId;
                        $bin->volume = $request->volume;
                        $bin->length = $request->length;
                        $bin->width = $request->width;
                        $bin->height = $request->height;
                        $bin->is_occupied = $request->is_occupied;
                        $bin->save();

                        return redirect()->route('building.show', $buildingCode)->with('success', 'Bin Created Successfully');
                }
        }

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function show($buildingCode, $sectionCode, $aisleCode, $bayCode, $levelCode, $binCode)
        {
                $building = Building::where('code', $buildingCode)->select('id', 'code')->first();
                $section = Section::where('building_id', $building->id)->where('code', $sectionCode)->select('id')->first();
                $aisle = Aisle::where('code', $aisleCode)->where('section_id', $section->id)->select('id')->first();
                $bay = Bay::where('code', $bayCode)->where('aisle_id', $aisle->id)->select('id')->first();
                $level = Level::where('code', $levelCode)->where('bay_id', $bay->id)->select('id')->first();
                $bin = Bin::where('code', $binCode)->where('level_id', $level->id)->first();
                $context =  $buildingCode . "-" . $sectionCode . "-" . $aisleCode . "-" . $bayCode . "-" . $levelCode . "-" . $binCode;

                return Inertia::render('Building/Bins/View', ['building' => $building, 'bin' => $bin, 'context' => $context]);
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
        {
                $bin = Bin::find($id);
                $level = Level::find($bin->level_id);
                $bay = Bay::where('id', $level->bay_id)->select('aisle_id')->first();
                $aisle = Aisle::where('id', $bay->aisle_id)->select('section_id')->first();
                $section = Section::where('id', $aisle->section_id)->select('building_id')->first();
                $buildingCode = Building::where('id', $section->building_id)->select('code')->first();

                return Inertia::render('Building/Bins/Create', ['building_code' => $buildingCode->code, 'level' => $level, 'bin' => $bin]);
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, $id)
        {
                $ids = explode("-", $id);
                $binId = $ids[0];
                $buildingCode = $ids[1];

                $request->validate([
                        'code' => 'required|max:2',
                        'volume' => 'required|numeric|gt:0',
                        'length' => 'required|numeric',
                        'width' => 'required|numeric',
                        'height' => 'required|numeric',
                ]);

                $bin = Bin::where('id', $binId)->first();
                $bin->update($request->all());

                return redirect()->route('building.show', $buildingCode)->with('success', 'Bin Updadted Successfully');
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function destroy($id)
        {
                $ids = explode("-", $id);
                $binId = $ids[0];
                $buildingCode = $ids[1];
                $bin = Bin::where('id', $binId)->first();
                $bin->delete();

                return redirect()->route('building.show', $buildingCode)->with('delete', 'Bin Deleted Successfully');
        }
}
