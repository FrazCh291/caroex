<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use Inertia\Inertia;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Services\Traits\Sort;
use App\Services\Traits\Search;
use App\Services\Traits\Filter;
use App\Services\Traits\Logger;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

use function Symfony\Component\String\s;

class LogsController extends Controller
{
    use Sort;
    use Logger;
    use Filter;
    use Search;
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $activeUser = Auth::user()->role_id;
        $role = Role::where('id', $activeUser)->first();
        $activityLogs = ActivityLog::query();
        if ($request->get('view')) {
            $activityLogs = $request->get('view') ? $activityLogs->where('activity', 'View') : $activityLogs;
        }
        if ($request->get('create')) {
            $activityLogs = $request->get('create') ? $activityLogs->orWhere('activity', 'Create') : $activityLogs;
        }
        if ($request->get('store')) {
            $activityLogs = $request->get('store') ? $activityLogs->orWhere('activity', 'Store') : $activityLogs;
        }
        if ($request->get('edit')) {
            $activityLogs = $request->get('edit') ? $activityLogs->orWhere('activity', 'Edit') : $activityLogs;
        }
        if ($request->get('update')) {
            $activityLogs = $request->get('update') ? $activityLogs->orWhere('activity', 'Update') : $activityLogs;
        }
        if ($request->get('delete')) {
            $activityLogs = $request->get('delete') ? $activityLogs->orWhere('activity', 'Delete') : $activityLogs;
        }
        if ($request->get('show')) {
            $activityLogs = $request->get('show') ? $activityLogs->orWhere('activity', 'Show') : $activityLogs;
        }

        if (Auth::user()->is_super == 1) {
            $activityLogs = $activityLogs->where('company_id', Auth::user()->company_id);
        } else if ($role->slug == 'erp_admin') {
            $activityLogs = $activityLogs->where([['company_id', Auth::user()->company_id], ['type', 'erp']]);
        } else if ($role->slug == 'fulfilment_admin') {
            $activityLogs = $activityLogs->where([['company_id', Auth::user()->company_id], ['type', 'fulfilment']]);
        } else {
            $activityLogs = $activityLogs->where([['company_id', Auth::user()->company_id], ['user_id', Auth::user()->id]]);
        }
        $parameter = $request->all();
        $query = $request['query'];
        if (substr($query, 0, 1) === '/') {
            $request['query'] = explode("/", $query)[1];
        }
        $activityLogs = $this->search($activityLogs, [
            'type',
            'user_id',
            'path',
            'logable_id',
            'activity',
            'logable_type',
            'created_at'
        ]);
        
        if ($request->has('query')) {
            $activityLogs = $activityLogs->orWhereHas('user', function (Builder $query) {
                $this->search($query, ['name']);
            });
        }

        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $activityLogs = $this->sort($activityLogs, $columns, $request->get('direction'));
        }

        $activityLogs = $activityLogs->with(['user', 'activityLogDetail' => function($query){
            $query->orderBy('id', 'desc')->get();
        }, 'order.orderItems.product', 'purchaseOrder.purchaseOrderItem.product'])
            ->orderBy('id', 'desc')->paginate(10);
        $params = $parameter;
        $params['enable'] = $request->get('enable') == 'true' ? 'true' : '';
        $params['disable'] = $request->get('disable') == 'true' ? 'true' : '';

        if ($request->has('direction') && $request->get('user_id')) {
            $sortedDta = $activityLogs->getCollection()->sortBy(function ($activityLog) {
                return $activityLog->user->name;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $activityLogs->setCollection(collect($sort));
        }

        return Inertia::render('Logs/Index', [
            'logs' => $activityLogs->withQueryString(),
            'params' => $params,
        ]);
    }

    public function sortables(Request $request)
    {
        $sorts = [];

        foreach ([
            'logable_type',
            'created_at',
            'activity',
        ] as $sort) {
            if ($request->get($sort)) {
                $sorts[] = $sort;
            }
        }

        return $sorts;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function show($id)
    {
        $activitylog = ActivityLog::with('user', 'product', 'email', 'order.orderItems.product', 'cases', 'purchaseOrder.purchaseOrderItem.product')
            ->where('id', $id)->first();

        return Inertia::render('Logs/Show', [
            'logsData' => $activitylog,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
