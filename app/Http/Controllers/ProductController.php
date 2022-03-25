<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Models\Condition;
use App\Models\Tag;
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
        return response()->json(ProductResource::collection(Product::latest()->paginate()), 200);
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
            'image' => '',
            'price' => 'required|numeric|min:0|max:9999.99',
            'condition_id' => 'required|exists:conditions,id',
            'tags' => 'present|array',
            'tags.*' => 'required|exists:tags,id',
        ])->validate();

        $user = Auth::user();
        $condition = Condition::find($request->input('condition_id'));

        $product = new Product();

        $product->user()->associate($user);
        $product->condition()->associate($condition);


        if (!empty($request->input('image'))) {
            $url_image = $request->input('image');
        } else {
            $url_image = "data:image/png;base64,/9j/4QAYRXhpZgAASUkqAAgAAAAAAAAAAAAAAP/sABFEdWNreQABAAQAAAA4AAD/4QMraHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjMtYzAxMSA2Ni4xNDU2NjEsIDIwMTIvMDIvMDYtMTQ6NTY6MjcgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDUzYgKFdpbmRvd3MpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOkQyMUQxNDdFMDEzODExRTNBMjIyREM0REEyQzRGMEI1IiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOkQyMUQxNDdGMDEzODExRTNBMjIyREM0REEyQzRGMEI1Ij4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6RDIxRDE0N0MwMTM4MTFFM0EyMjJEQzREQTJDNEYwQjUiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6RDIxRDE0N0QwMTM4MTFFM0EyMjJEQzREQTJDNEYwQjUiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz7/7gAOQWRvYmUAZMAAAAAB/9sAhAAHBQUFBQUHBQUHCgcGBwoMCQcH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";
        }

        $product->image = $url_image;
        $product->title = $request->input('title');
        $product->description = $request->input('description');
        $product->price = $request->input('price');

        $res = $product->save();

        $product->tags()->sync($request->input('tags'));
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
            'image' => '',
            'price' => 'numeric|min:0|max:9999.99',
            'condition_id' => 'exists:conditions,id',
            'tags' => 'present|array',
            'tags.*' => 'required|exists:tags,id',
        ])->validate();

        if (Auth::id() !== $product->user->id) {
            return response()->json(['message' => 'You don\'t have permissions'], 403);
        }

        if (!empty($request->input('condition_id'))) {
            $condition = Condition::find($request->input('condition_id'));
            $product->condition()->associate($condition);
        }

        if (!empty($request->input('title'))) {
            $product->title = $request->input('title');
        }
        if (!empty($request->input('description'))) {
            $product->description = $request->input('description');
        }
        if (!empty($request->input('image'))) {
            $product->image = $request->input('image');
        }
        if (!empty($request->input('price'))) {
            $product->price = $request->input('price');
        }
        $product->tags()->sync($request->input('tags'));

        $res = $product->save();

        if ($res) {
            return response()->json(['message' => 'Product update succesfully'], 201);
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

}
