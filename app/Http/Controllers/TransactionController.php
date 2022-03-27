<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransactionResource;
use App\Models\Product;
use App\Models\Review;
use App\Models\State;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     return response()->json(TransactionResource::collection(Transaction::latest()->paginate()),200);  //maybe solo las del usuario conectado?
    // }

        /**
         * Display the specified resource.
         *
         * @param  \App\Models\Transaction  $transaction
         * @return \Illuminate\Http\Response
         */
        // public function show(Transaction $transaction)
        // {
        //     return response()->json(new TransactionResource($transaction),200);
        // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     Validator::make($request->all(),[
    //         'product_id' => 'required|exists:products,id',
    //     ])->validate();

    //     $user = Auth::user();
    //     $product = Product::find($request->input('product_id'));
    //     $state = State::find('2');

    //     $transaction = new Transaction();

    //     $transaction->user()->associate($user);
    //     $transaction->product()->associate($product);
    //     $transaction->state()->associate($state);
    //     $transaction->amount = $transaction->product->price;

    //     $res = $transaction->save();

    //     if ($res) {
    //         return response()->json(['message' => 'Transaction create succesfully'], 201);
    //     }
    //     return response()->json(['message' => 'Error to create transaction'], 500);
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, Transaction $transaction)
    // {
    //     Validator::make($request->all(),[
    //         'state_id' => 'exists:states,id',
    //     ])->validate();

    //     //Segun el estado lo podrá poner el comprador o el dueño del producto (vendedor)
    //     if (Auth::id() !== $transaction->user->id) {
    //         return response()->json(['message' => 'You don\'t have permissions'], 403);
    //     }

    //     if (!empty($request->input('state_id'))) {
    //         $state = State::find($request->input('state_id'));
    //         $transaction->state()->associate($state);
    //     }

    //     $res = $transaction->save();

    //     if ($res) {
    //         return response()->json(['message' => 'Transaction update succesfully'],204);
    //     }

    //     return response()->json(['message' => 'Error to update transaction'], 500);
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    // public function destroy(Transaction $transaction)
    // {
    //     if (Auth::id() !== $transaction->user->id) {
    //         return response()->json(['message' => 'You don\'t have permissions'], 403);
    //     }

    //     $transaction->state='1';

    //     $res = $transaction->save();

    //     if ($res) {
    //         return response()->json(['message' => 'Transaction delete succesfully']);
    //     }

    //     return response()->json(['message' => 'Error to delete transaction'], 500);
    // }

    /**
     * Display a listing of the transactions like buyer.
     *
     * @return \Illuminate\Http\Response
     */
    public function manage()
    {
        $user = Auth::user();

        return response()->json(TransactionResource::collection($user->shoppings),200);  //maybe solo las del usuario conectado?
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function review(Request $request, Transaction $transaction)
    {
        Validator::make($request->all(),[
            'title' => 'required|string',
            'comment' => 'required|string',
            'stars' => 'required|integer|between:1,10'
        ])->validate();

        if (Auth::id() == $transaction->seller->id) {
            return response()->json(['message' => 'You can\'t review your own sell'], 403);
        }

        $user = Auth::user();

        $res = Review::create([
            'title' => $request->input('title'),
            'comment' => $request->input('comment'),
            'stars' => $request->input('stars'),
            'user_id' => $user->id,
            'transaction_id' => $transaction->id
        ]);

        if ($res) {
            return response()->json(['message' => 'Review create succesfully'], 201);
        }
        return response()->json(['message' => 'Error to create review'], 500);
    }

}
