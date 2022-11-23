<?php

namespace App\Http\Controllers\Admin\ReviewApi;

use App\Models\Review;
use App\Models\SalesChannel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
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
            $this->validate($request, [
            'name' => ['required'],
            'email' => ['required'],
            'slug' => ['required','exists:sales_channels,slug'],
            'product_id' => ['nullable','exists:products,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required'],
            'token' => ['required','exists:settings,value']
        ]);

        if($request['status'] === null) {
            $request['status'] = 'review_unapproved';
        }

        $channel_id = SalesChannel::where('slug',$request->slug)->first()->id;
        $review = new Review();
        $review->company_id = 1;
        $review->product_id = $request->product_id;
        $review->channel_id = $channel_id;
        $review->name = $request->name;
        $review->email = $request->email;
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->url = $request->url;
        $review->status = $request->status;
        $review->is_active = $request->is_active;
        $review->last_sent_at = $request->last_sent_at;
        $review->save();

        return response()->json($review, 201);
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
