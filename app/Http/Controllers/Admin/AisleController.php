<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Aisle;
use App\Models\Section;
use App\Models\Building;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AisleController extends Controller
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
                $sectionId = request('section_id');
                $section = Section::find($sectionId);

                return Inertia::render('Building/Aisles/Create', ['section' => $section, 'building_code' => $buildingCode]);
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
                $sectionId = request('section_id');
                $request->validate([
                        'code' => 'required|max:2',
                        'volume' => 'required|numeric|gt:0',
                        'length' => 'required|numeric',
                        'width' => 'required|numeric',
                        'height' => 'required|numeric'
                ]);

                $aisleExist = Aisle::where('section_id', $sectionId)->where('code', $request->code)->select('id')->first();
                if ($aisleExist) {
                        $error = \Illuminate\Validation\ValidationException::withMessages([
                                'code' => 'Aisle code ' . $request->code . ' already exist in same Section'
                        ]);
                        throw $error;
                } else {
                        $aisle = new Aisle();
                        $aisle->company_id = Auth::user()->company_id;
                        $aisle->name = $request->name;
                        $aisle->code = $request->code;
                        $aisle->section_id = $sectionId;
                        $aisle->volume = $request->volume;
                        $aisle->length = $request->length;
                        $aisle->width = $request->width;
                        $aisle->height = $request->height;
                        $aisle->is_active = $request->is_active;
                        $aisle->is_occupied = $request->is_occupied;
                        $aisle->save();

                        return redirect()->route('building.show', $buildingCode)->with('success', 'Aisle Created Successfully');
                }
        }

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function show($buildingCode, $sectionCode, $aisleCode)
        {
                $building = Building::where('code', $buildingCode)->select('id', 'code')->first();
                $section = Section::where('building_id', $building->id)->where('code', $sectionCode)->select('id')->first();
                $aisle = Aisle::where('code', $aisleCode)->where('section_id', $section->id)->first();
                $context = $buildingCode . "-" . $sectionCode . "-" . $aisleCode;

                return Inertia::render('Building/Aisles/View', ['building' => $building, 'aisle' => $aisle, 'context' => $context]);
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
        {
                $aisle = Aisle::find($id);
                $section = Section::find($aisle->section_id);
                $buildingCode = Building::where('id', $section->building_id)->select('code')->first();

                return Inertia::render('Building/Aisles/Create', ['building_code' => $buildingCode->code, 'aisle' => $aisle, 'section' => $section]);
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
                $aisleId = $ids[0];
                $buildingCode = $ids[1];
                $request->validate([
                        'code' => 'required|max:2',
                        'volume' => 'required|numeric|gt:0',
                        'length' => 'required|numeric',
                        'width' => 'required|numeric',
                        'height' => 'required|numeric'
                ]);

                $aisle = Aisle::where('id', $aisleId)->first();
                $aisle->update($request->all());

                return redirect()->route('building.show', $buildingCode)->with('success', 'Aisle Updadted Successfully');
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
                $aisleId = $ids[0];
                $buildingCode = $ids[1];
                $aisle = Aisle::where('id', $aisleId)->first();
                $aisle->delete();

                return redirect()->route('building.show', $buildingCode)->with('delete', 'Aisle Deleted Successfully');
        }
}
