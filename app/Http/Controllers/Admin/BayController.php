<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Aisle;
use App\Models\Bay;
use App\Models\Section;
use App\Models\Building;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BayController extends Controller
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
                $aisleId = request('aisle_id');
                $aisle = Aisle::find($aisleId);

                return Inertia::render('Building/Bays/Create', ['aisle' => $aisle, 'building_code' => $buildingCode]);
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
                $aisleId = request('aisle_id');
                $request->validate([
                        'code' => 'required|max:2',
                        'volume' => 'required|numeric|gt:0',
                        'length' => 'required|numeric',
                        'width' => 'required|numeric',
                        'height' => 'required|numeric',
                        'max_weight' => 'required|numeric'
                ]);

                $bayExist = Bay::where('aisle_id', $aisleId)->where('code', $request->code)->select('id')->first();
                if ($bayExist) {
                        $error = \Illuminate\Validation\ValidationException::withMessages([
                                'code' => 'Bay code ' . $request->code . ' already exist in same Aisle'
                        ]);
                        throw $error;
                } else {
                        $bay = new Bay();
                        $bay->company_id = Auth::user()->company_id;
                        $bay->name = $request->name;
                        $bay->code = $request->code;
                        $bay->aisle_id = $aisleId;
                        $bay->volume = $request->volume;
                        $bay->length = $request->length;
                        $bay->width = $request->width;
                        $bay->height = $request->height;
                        $bay->is_active = $request->is_active;
                        $bay->is_occupied = $request->is_occupied;
                        $bay->max_weight = $request->max_weight;
                        $bay->save();

                        return redirect()->route('building.show', $buildingCode)->with('success', 'bay Created Successfully');
                }
        }

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function show($buildingCode, $sectionCode, $aisleCode, $bayCode)
        {
                $building = Building::where('code', $buildingCode)->select('id', 'code')->first();
                $section = Section::where('building_id', $building->id)->where('code', $sectionCode)->select('id')->first();
                $aisle = Aisle::where('code', $aisleCode)->where('section_id', $section->id)->select('id')->first();
                $bay = Bay::where('code', $bayCode)->where('aisle_id', $aisle->id)->first();
                $context = $buildingCode . "-" . $sectionCode . "-" . $aisleCode . "-" . $bayCode;

                return Inertia::render('Building/Bays/View', ['building' => $building, 'bay' => $bay, 'context' => $context]);
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
        {
                $bay = Bay::find($id);
                $aisle = Aisle::find($bay->aisle_id);
                $section = Section::where('id', $aisle->section_id)->select('building_id')->first();
                $buildingCode = Building::where('id', $section->building_id)->select('code')->first();

                return Inertia::render('Building/Bays/Create', ['building_code' => $buildingCode->code, 'aisle' => $aisle, 'bay' => $bay]);
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
                $bayId = $ids[0];
                $buildingCode = $ids[1];

                $request->validate([
                        'code' => 'required|max:2',
                        'volume' => 'required|numeric|gt:0',
                        'length' => 'required|numeric',
                        'width' => 'required|numeric',
                        'height' => 'required|numeric',
                        'max_weight' => 'required|numeric'
                ]);

                $bay = Bay::where('id', $bayId)->first();
                $bay->update($request->all());

                return redirect()->route('building.show', $buildingCode)->with('success', 'bay Updadted Successfully');
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
                $bayId = $ids[0];
                $buildingCode = $ids[1];
                $bay = Bay::where('id', $bayId)->first();
                $bay->delete();

                return redirect()->route('building.show', $buildingCode)->with('delete', 'bay Deleted Successfully');
        }
}
