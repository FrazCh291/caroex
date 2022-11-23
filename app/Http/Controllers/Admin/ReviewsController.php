<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Review;
use App\Models\Lookup;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\SalesChannel;
use Illuminate\Http\Request;
use App\Services\Traits\Sort;
use App\Services\Traits\Search;
use App\Services\Traits\Filter;
use App\Services\Traits\Logger;
use App\Models\ActivityLogsDetails;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Reviews\ReviewExport;
use Illuminate\Support\Facades\Redirect;
use App\Services\Traits\DefaultActiveLog;
use Illuminate\Database\Eloquent\Builder;

class ReviewsController extends Controller
{
    use Sort;
    use Filter;
    use Search;
    use Logger;
    use DefaultActiveLog;

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny',Review::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'grid',
            'module' => 'App\Module\Reviews',
            'activity' => 'View',
            'type' => 'erp',
            'path' => $slice,
        ];
        $this->defaultFun($module);

        $reviews = Review::query();
        $reviews = $request->get('review_unapproved') ? $reviews->where('status', 'review_unapproved') : $reviews;
        $reviews = $request->get('review_approved') ? $reviews->orWhere('status', 'review_approved') : $reviews;
        $reviews = $request->get('1') ? $reviews->orWhere('rating', 1) : $reviews;
        $reviews = $request->get('2') ? $reviews->orWhere('rating', 2) : $reviews;
        $reviews = $request->get('3') ? $reviews->orWhere('rating', 3) : $reviews;
        $reviews = $request->get('4') ? $reviews->orWhere('rating', 4) : $reviews;
        $reviews = $request->get('5') ? $reviews->orWhere('rating', 5) : $reviews;

        $reviews = $this->search($reviews, [
            'name',
            'email',
            'comment',
            'rating',
            'status',
        ]);
        if ($request->has('query')) {
            $reviews = $reviews->orWhereHas('products', function (Builder $query) {
                $this->search($query, ['name']);
            });
        }

        if ($request->has('query')) {
            $reviews = $reviews->orWhereHas('channels', function (Builder $query) {
                $this->search($query, ['name']);
            });
        }

        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $reviews = $this->sort($reviews, $columns, $request->get('direction'));
        }

        $params = $request->all();
        $params['unapproved'] = $request->get('unapproved') == 'true' ? 'true' : '';
        $params['approved'] = $request->get('approved') == 'true' ? 'true' : '';
        $params['rating1'] = $request->get('rating1') == 'true' ? 'true' : '';
        $params['rating2'] = $request->get('rating2') == 'true' ? 'true' : '';
        $params['rating3'] = $request->get('rating3') == 'true' ? 'true' : '';
        $params['rating4'] = $request->get('rating4') == 'true' ? 'true' : '';
        $params['rating5'] = $request->get('rating5') == 'true' ? 'true' : '';

        $reviews = $reviews->with(['products','users','channels'])->paginate(15);

        $review1 = Review::distinct('status')->pluck('status')->toArray();
        $review2 = Review::distinct('rating')->pluck('rating')->toArray();

        if ($request->has('direction') && $request->get('name')) {
            $sortedDta = $reviews->getCollection()->sortBy(function ($review) {
                return $review->channels->name;
            }, 3, $request->get('direction') == 'desc' ? true : false);
            $sort = [];
            foreach ($sortedDta as $item) {
                $sort[] = $item;
            }
            $reviews->setCollection(collect($sort));
        }

        return Inertia::render('Reviews/Index',[
            'reviews' => $reviews->withQueryString(),
            'params' => $params,
            'review1' => $review1,
            'review2' => $review2,
        ]);
    }

    public function sortables(Request $request): array
    {
        $sorts = [];
        foreach (['name',
                     'email',
                     'channel_id',
                     'rating',
                     'comment',
                     'status'] as $sort) {
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
     * @return \Inertia\Response
     */
    public function create()
    {
        $this->authorize('create',Review::class);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => 'page',
            'module' => 'App\Module\Reviews',
            'activity' => 'Create',
            'type' => 'erp',
            'path' => $slice
        ];
        $this->defaultFun($module);

        $products = Product::Select('name', 'id')->orderBy('name')->get();
        $review_statuses = Lookup::where('type', 'review_status')->orderBy('value')->get();
        $salesChannels = SalesChannel::Select('name', 'id')->orderBy('name')->get();
        $currentDate = date("Y-m-d", strtotime(Carbon::today()));

        return Inertia::render('Reviews/Create',[
            'products' => $products,
            'review_statuses' => $review_statuses,
            'salesChannels' => $salesChannels,
            'currentDate' => $currentDate,
        ]);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required'],
            'email' => ['required'],
            'channel_id' => ['required'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required'],
        ]);

        $review = new Review();
        $review->company_id = Auth::user()->company_id;
        $review->product_id = $request->product_id;
        $review->channel_id = $request->channel_id;
        $review->customer_id = $request->customer_id;
        $review->name = $request->name;
        $review->email = $request->email;
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->url = $request->url;
        $review->status = $request->status;
        $review->is_active = $request->is_active;
        $review->last_sent_at = $request->last_sent_at;
        $review->save();
        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');
        $module = [
            'message' => '{' . $review->id  .'}',
            'module' => $review,
            'activity' => 'Store',
            'type' => 'erp',
            'path' => $slice.'/'.$review->id,
        ];
        $this->logable($module);

        if($request->customer_id){
            return Redirect::route('customers.show', $request->customer_id)->with('success', 'Review Create Successfully');
        }else{
        return Redirect::route('reviews.index')->with('success', 'Review Create Successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function show($id)
    {
        $this->authorize('view',Review::class);

        $review = Review::where('id',$id)->with(['products','users','channels'])->first();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $review->id  .'}',
            'module' => $review,
            'activity' => 'Show',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        return Inertia::render('Reviews/Show',[
            'review' => $review,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function edit($id)
    {

        $this->authorize('update',Review::class);

        $review = Review::findOrFail($id);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $review->id  .'}',
            'module' => $review,
            'activity' => 'Edit',
            'type' => 'erp',
            'path' => $slice,
        ];

        $this->logable($module);

        $products = Product::Select('name', 'id')->orderBy('name')->get();
        $review_statuses = Lookup::where('type', 'review_status')->orderBy('value')->get();
        $salesChannels = SalesChannel::Select('name', 'id')->orderBy('name')->get();
        $currentDate = date("Y-m-d", strtotime(Carbon::today()));

        return Inertia::render('Reviews/Create',[
            'review' => $review,
            'products' => $products,
            'review_statuses' => $review_statuses,
            'salesChannels' => $salesChannels,
            'currentDate' => $currentDate
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Review $review)
    {
        $this->validate($request, [
            'name' => ['required'],
            'email' => ['required'],
            'channel_id' => ['required'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required'],
        ]);

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $module = [
            'message' => '{' . $review->id  .'}',
            'module' => $review,
            'activity' => 'Update',
            'type' => 'erp',
            'path' => $slice,
        ];
        $logData =  $this->logable($module);
        $details = $review;

		$final_data = json_encode($details);
        
        $LogDetail = new ActivityLogsDetails();
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->is_old = 1;
        $LogDetail->details = $final_data;
        $LogDetail->save();
     
        $review->company_id = Auth::user()->company_id;
        $review->product_id = $request->product_id;
        $review->channel_id = $request->channel_id;
        $review->name = $request->name;
        $review->email = $request->email;
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->url = $request->url;
        $review->status = $request->status;
        $review->is_active = $request->is_active;
        $review->last_sent_at = $request->last_sent_at;
        $review->save();

        $currentURL = url()->current();
        $slice = Str::after($currentURL, '8000');

        $details = $review;
        
		$final_data = json_encode($details);
        
        $LogDetail = new ActivityLogsDetails();
        $LogDetail->company_id = Auth::user()->company_id;
        $LogDetail->activity_log_id = $logData->id;
        $LogDetail->is_old = 0;
        $LogDetail->details = $final_data;
        $LogDetail->save();
     
        return Redirect::route('reviews.index')->with('success', 'Review Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->authorize('delete',Review::class);

        $review = Review::findOrFail($id);
        $review->delete();

        $module = [
            'message' => '{' . $review->id  .'}',
            'module' => $review,
            'activity' => 'Delete',
            'type' => 'erp',
            'path' => null,
        ];

        $this->logable($module);

        return Redirect::route('reviews.index')->with('success', 'Review Delete Successfully');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export()
    {
//        $this->authorize('view',Review::class);

        return Excel::download(new ReviewExport(), 'Reviews.csv');
    }

    /**
     * @param $module
     * @param $message
     */

}
