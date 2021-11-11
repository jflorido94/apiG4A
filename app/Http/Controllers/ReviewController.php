<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReviewResource;
use App\Models\Review;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(ReviewResource::collection(Review::latest()->paginate()),206);  // sin sentido mostrarlas todas
    }

        /**
         * Display the specified resource.
         *
         * @param  \App\Models\Review  $review
         * @return \Illuminate\Http\Response
         */
        public function show(Review $review)
        {
            return response()->json($review,200);
        }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(),[
            'title' => 'required|max:180',
            'start' => 'required|integer|between:1,10',
            'comment' => 'required|max:4000',
            'transaction_id' => 'required|exists:transactions,id',
        ])->validate();

        $user = Auth::user();
        $transaction = Transaction::find($request->input('transaction_id'));

        $review = new Review();

        $review->user()->associate($user);
        $review->transaction()->associate($transaction);
        $review->title = $request->input('title');
        $review->stars = $request->input('stars');
        $review->comment = $request->input('comment');

        $res = $review->save();

        if ($res) {
            return response()->json(['message' => 'Review create succesfully'], 201);
        }
        return response()->json(['message' => 'Error to create review'], 500);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        Validator::make($request->all(),[
            'title' => 'required|max:180',
            'start' => 'required|integer|between:1,10',
            'comment' => 'required|max:4000',
        ])->validate();

        if (Auth::id() !== $review->user->id) {
            return response()->json(['message' => 'You don\'t have permissions'], 403);
        }

        if (!empty($request->input('title'))) {
            $review->title = $request->input('title');
        }
        if (!empty($request->input('start'))) {
            $review->stars = $request->input('start');
        }
        if (!empty($request->input('comment'))) {
            $review->comment = $request->input('comment');
        }

        $res = $review->save();

        if ($res) {
            return response()->json(['message' => 'Review update succesfully'],204);
        }

        return response()->json(['message' => 'Error to update review'], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        //
    }
}
