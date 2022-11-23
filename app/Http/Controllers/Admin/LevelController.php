<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bay;
use Inertia\Inertia;
use App\Models\Aisle;
use App\Models\Level;
use App\Models\Section;
use App\Models\Building;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LevelController extends Controller
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
        $bayId = request('bay_id');
        $bay = Bay::find($bayId);

        return Inertia::render('Building/Levels/Create', ['bay' => $bay, 'building_code' => $buildingCode]);
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
        $bayId = request('bay_id');
        $request->validate([
            'code' => 'required|max:2',
            'volume' => 'required|numeric|gt:0',
            'length' => 'required|numeric',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
            'max_weight' => 'required|numeric'
        ]);

        $levelExist = Level::where('bay_id', $bayId)->where('code', $request->code)->select('id')->first();
        if ($levelExist) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'code' => 'Level code ' . $request->code . ' already exist in same Bay'
            ]);
            throw $error;
        } else {
            $level = new Level();
            $level->company_id = Auth::user()->company_id;
            $level->name = $request->name;
            $level->code = $request->code;
            $level->bay_id = $bayId;
            $level->volume = $request->volume;
            $level->length = $request->length;
            $level->width = $request->width;
            $level->height = $request->height;
            $level->is_occupied = $request->is_occupied;
            $level->max_weight = $request->max_weight;
            $level->save();

            return redirect()->route('building.show', $buildingCode)->with('success', 'level Created Successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($buildingCode, $sectionCode, $aisleCode, $bayCode, $levelCode)
    {
        $building = Building::where('code', $buildingCode)->select('id', 'code')->first();
        $section = Section::where('building_id', $building->id)->where('code', $sectionCode)->select('id')->first();
        $aisle = Aisle::where('code', $aisleCode)->where('section_id', $section->id)->select('id')->first();
        $bay = Bay::where('code', $bayCode)->where('aisle_id', $aisle->id)->select('id')->first();
        $level = Level::where('code', $levelCode)->where('bay_id', $bay->id)->first();
        $context = $buildingCode . "-" . $sectionCode . "-" . $aisleCode . "-" . $bayCode . "-" . $levelCode;

        return Inertia::render('Building/Levels/View', ['building' => $building, 'level' => $level, 'context' => $context]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $level = Level::find($id);
        $bay = Bay::find($level->bay_id);
        $aisle = Aisle::where('id', $bay->aisle_id)->select('section_id')->first();
        $section = Section::where('id', $aisle->section_id)->select('building_id')->first();
        $buildingCode = Building::where('id', $section->building_id)->select('code')->first();

        return Inertia::render('Building/Levels/Create', ['building_code' => $buildingCode->code, 'level' => $level, 'bay' => $bay]);
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
        $levelId = $ids[0];
        $buildingCode = $ids[1];
        $request->validate([
            'code' => 'required|max:2',
            'volume' => 'required|numeric|gt:0',
            'length' => 'required|numeric',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
            'max_weight' => 'required|numeric'
        ]);

        $level = Level::where('id', $levelId)->first();
        $level->update($request->all());

        return redirect()->route('building.show', $buildingCode)->with('success', 'Shelve Updadted Successfully');
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
        $levelId = $ids[0];
        $buildingCode = $ids[1];
        $level = Level::where('id', $levelId)->first();
        $level->delete();

        return redirect()->route('building.show', $buildingCode)->with('delete', 'Shelve Deleted Successfully');
    }
}
