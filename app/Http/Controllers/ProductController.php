<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Models\Condition;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(ProductResource::collection(Product::latest()->paginate()), 206);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response()->json(new ProductResource($product), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'title' => 'required|max:180',
            'description' => 'required|max:4000',
            'image' => 'image|max:1024',
            'price' => 'required|numeric|min:0|max:999999999.99',
            'condition_id' => 'required|exists:conditions,id',
        ])->validate();

        $user = Auth::user();
        $condition = Condition::find($request->input('condition_id'));

        $product = new Product();

        $product->user()->associate($user);
        $product->condition()->associate($condition);
        // $url_image = $this->upload($request->file('image'));
        // $product->image = $url_image;
        $product->title = $request->input('title');
        $product->description = $request->input('description');
        $product->price = $request->input('price');

        $res = $product->save();

        if ($res) {
            return response()->json(['message' => 'Product create succesfully'], 201);
        }
        return response()->json(['message' => 'Error to create product'], 500);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        Validator::make($request->all(), [
            'title' => 'max:180',
            'description' => 'max:4000',
            'image' => 'image|max:1024',
            'price' => 'numeric|min:0|max:999999999.99',
            'condition_id' => 'exists:conditions,id',
        ])->validate();

        if (Auth::id() !== $product->user->id) {
            return response()->json(['message' => 'You don\'t have permissions'], 403);
        }

        if (!empty($request->input('condition_id'))) {
            $condition = Condition::find($request->input('condition_id'));
            $product->condition()->associate($condition);
        }

        // if (!empty($request->file('image'))) {
        //     $url_image = $this->upload($request->file('image'));
        //     $product->image = $url_image;
        // }
        if (!empty($request->input('title'))) {
            $product->title = $request->input('title');
        }
        if (!empty($request->input('description'))) {
            $product->description = $request->input('description');
        }
        if (!empty($request->input('price'))) {
            $product->price = $request->input('price');
        }

        $res = $product->save();

        if ($res) {
            return response()->json(['message' => 'Product update succesfully'], 204);
        }

        return response()->json(['message' => 'Error to update product'], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {

        if (Auth::id() !== $product->user->id) {
            return response()->json(['message' => 'You don\'t have permissions'], 403);
        }

        $product->erased = true;

        $res = $product->save();

        if ($res) {
            return response()->json(['message' => 'Product delete succesfully']);
        }

        return response()->json(['message' => 'Error to delete product'], 500);
    }

    private function upload($image)
    {
        $path_info = pathinfo($image->getClientOriginalName());
        $product_path = 'images/product';

        $rename = uniqid() . '.' . $path_info['extension'];
        $image->move(public_path() . "/$product_path", $rename);
        return "$product_path/$rename";
    }
}
