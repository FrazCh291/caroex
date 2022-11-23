<?php

namespace App\Http\Controllers\Admin;


use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\Traits\Sort;
use App\Models\Questionnaire;
use App\Services\Traits\Search;
use App\Services\Traits\Filter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Doctrine\DBAL\Query\QueryBuilder;
use App\Services\Traits\DefaultActiveLog;
use Illuminate\Database\Eloquent\Builder;



class QuestionnaireController extends Controller
{
    use Sort;
    use Filter;
    use Search;
    use DefaultActiveLog;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
        $this->authorize('viewAny',Questionnaire::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\Questionnaire',
            'activity' => 'View',
            'type' => 'fulfilment',
            'path' => $slice,
        ];
        $this->defaultFun($module);
        
        $questionnaires = Questionnaire::query();
        $questionnaires = $request->get('enable') ? $questionnaires->where('is_enable', 1) : $questionnaires;
        $questionnaires = $request->get('disable') ? $questionnaires->orWhere('is_enable', 0) : $questionnaires;

        $questionnaires = $this->search($questionnaires, [
            'label',
            'value',
            'type',
            'description',
        ]);

        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $questionnaires = $this->sort($questionnaires, $columns, $request->get('direction'));
        }
        $questionnaires = $questionnaires->where('company_id', Auth::user()->company_id)->paginate(15);
        $params = $request->all();

        $params['enable'] = $request->get('enable') == 'true' ? 'true' : '';
        $params['disable'] = $request->get('disable') == 'true' ? 'true' : '';
     

        if ($request->has('direction') && $request->get('name')) {
            $sortedDta = $questionnaires->getCollection()->sortBy(function ($questionnaire) {
                return $questionnaire->product->name;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $questionnaires->setCollection(collect($sort));
        }
    
        return Inertia::render('Questionnaires/Index',[
            'questionnaires' => $questionnaires->withQueryString(),
            'params' => $params
        ]);
    }
    public function sortables(Request $request): array
    {
        $sorts = [];
        foreach (['label','value','type',
                     'description','is_enable'] as $sort) {
            if ($request->get($sort)) {
                $sorts[] = $sort;
            }
        }

        return $sorts;
    }

    public function logable($module)
    {
        $request = [
            'company_id' => Auth::user()->company_id,
            'user_id' => Auth::user()->id,
            'module' => $module['module'],
            'activity' => $module['activity'],
            'type' => $module['type'],
            'path' => $module['path'],
        ];
       return $this->log($request);
    }

    public function defaultFun($module)
    {
        $request = [
            'company_id' => Auth::user()->company_id,
            'user_id' => Auth::user()->id,
            'module' => $module['module'],
            'activity' => $module['activity'],
            'type' => $module['type'],
            'path' => $module['path'],
        ];

        $this->defaultLog($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $this->authorize('create',Questionnaire::class);

        $module = [
            'message' => 'page',
            'module' => 'App\Module\Questionnaires',
            'activity' => 'Create',
            'type' => 'fulfilment'
        ];
        $this->defaultFun($module);

        return Inertia::render('Questionnaires/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'label' => ['required'],
            'value' => ['required'],
            'type' => ['required'],
            'description' => ['required']
        ]);
        $questionnaire = new Questionnaire();
        $questionnaire->company_id = Auth::user()->company_id;
        $questionnaire->label = $request->label;
        $questionnaire->value = $request->value;
        $questionnaire->type = $request->type;
        $questionnaire->description = $request->description;
        if($request->is_enable == null) {
            $questionnaire->is_enable = false;
        }
        else {
            $questionnaire->is_enable = $request->is_enable;
        }
        $questionnaire->save();

        return redirect()->route('questionnaires.index')->with('success', 'Questionnaire Create Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update',Questionnaire::class);
        $questionnaire = Questionnaire::findOrFail($id);

        return Inertia::render('Questionnaires/Create',[
            'questionnaire' => $questionnaire
        ]);
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
        $validate = $this->validate($request, [
            'label' => ['required'],
            'value' => ['required'],
            'type' => ['required'],
            'description' => ['required']
        ]);

        $questionnaire = Questionnaire::findOrFail($id);
        $questionnaire->company_id = Auth::user()->company_id;
        $questionnaire->label = $request->label;
        $questionnaire->value = $request->value;
        $questionnaire->type = $request->type;
        $questionnaire->description = $request->description;
        if($request->is_enable == null) {
            $questionnaire->is_enable = false;
        }
        else {
            $questionnaire->is_enable = $request->is_enable;
        }
        $questionnaire->save();

        return redirect()->route('questionnaires.index')->with('success', 'Questionnaire Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->authorize('delete',Questionnaire::class);
        $questionnaire = Questionnaire::findOrFail($id);
        $questionnaire->delete();

        return redirect()->route('questionnaires.index')->with('success', 'Questionnaire Delete Successfully');
    }
}
