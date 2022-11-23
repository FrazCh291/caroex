<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Section;
use App\Models\Building;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
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
                $buildingId = request('building_id');
                $building = Building::find($buildingId);

                return Inertia::render('Building/Sections/Create', ['building' => $building]);
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request)
        {
                $buildingId = request('building_id');
                $buildingCode = request('building_code');
                $request->validate([
                        'code' => 'required|max:2',
                        'volume' => 'required|numeric|gt:0',
                        'length' => 'required|numeric',
                        'width' => 'required|numeric',
                        'height' => 'required|numeric',

                ]);

                $sectionExist = Section::where('building_id', $buildingId)->where('code', $request->code)->select('id')->first();
                if ($sectionExist) {
                        $error = \Illuminate\Validation\ValidationException::withMessages([
                                'code' => 'Section code ' . $request->code . ' already exist in same Building'
                        ]);
                        throw $error;
                } else {
                        $section = new Section();
                        $section->company_id = Auth::user()->company_id;
                        $section->name = $request->name;
                        $section->code = $request->code;
                        $section->building_id = $buildingId;
                        $section->volume = $request->volume;
                        $section->length = $request->length;
                        $section->width = $request->width;
                        $section->height = $request->height;
                        $section->is_active = $request->is_active;
                        $section->is_occupied = $request->is_occupied;
                        $section->save();

                        return redirect()->route('building.show', [$buildingCode])->with('success', 'Section Created Successfully');
                }
        }

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function show($buildingCode, $sectionCode)
        {
                $building = Building::where('code', $buildingCode)->select('id', 'code')->first();
                $section = Section::where('code', $sectionCode)->where('building_id', $building->id)->first();

                return Inertia::render('Building/Sections/View', ['building' => $building, 'section' => $section]);
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
        {
                $section = Section::find($id);
                $building = Building::find($section->building_id);

                return Inertia::render('Building/Sections/Create', ['building' => $building, 'section' => $section]);
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
                $sectionId = $ids[0];
                $buildingId = $ids[1];
                $buildingCode = Building::where('id', $buildingId)->select('code')->first();
                $request->validate([
                        'code' => 'required|max:2',
                        'volume' => 'required|numeric|gt:0',
                        'length' => 'required|numeric',
                        'width' => 'required|numeric',
                        'height' => 'required|numeric',

                ]);

                $section = Section::where('id', $sectionId)->first();
                $section->update($request->all());

                return redirect()->route('building.show', $buildingCode->code)->with('success', 'Section Updadted Successfully');
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
                $sectionId = $ids[0];
                $buildingCode = $ids[1];
                $section = Section::where('id', $sectionId)->first();
                $section->delete();

                return redirect()->route('building.show', $buildingCode)->with('delete', 'Section Deleted Successfully');
        }
}
