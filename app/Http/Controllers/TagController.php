<?php

namespace App\Http\Controllers;

use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TagController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(TagResource::collection(Tag::all()), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        return response()->json(new TagResource($tag), 200);
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
            'name' => 'required|unique:tags|max:30',
            'colour' => 'required|unique:tags|regex:/^#[a-f0-9]{6}$/i',
        ])->validate();

        if (! Auth::user()->is_admin) {
            return response()->json(['message' => 'You don\'t have permissions'], 403);
        }

        $tag = new Tag();

        $tag->name = $request->input('name');
        $tag->colour = $request->input('colour');

        $res = $tag->save();

        if ($res) {
            return response()->json(['message' => 'Tag create succesfully'], 201);
        }
        return response()->json(['message' => 'Error to create tag'], 500);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        Validator::make($request->all(),[
            'name' => 'max:30',Rule::unique('tags')->ignore($tag->id),
            'colour' => 'regex:/^#[a-f0-9]{6}$/i',Rule::unique('tags')->ignore($tag->id)
        ])->validate();

        if (! Auth::user()->is_admin) {
            return response()->json(['message' => 'You don\'t have permissions'], 403);
        }

        if (!empty($request->input('name'))) {
            $tag->name = $request->input('name');
        }
        if (!empty($request->input('colour'))) {
            $tag->colour = $request->input('colour');
        }

        $res = $tag->save();

        if ($res) {
            return response()->json(['message' => 'Tag update succesfully'], 201);
        }
        return response()->json(['message' => 'Error to update tag'], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)  //borrar en cascada?
    {
        if (Auth::user()->is_admin) {
            return response()->json(['message' => 'You don\'t have permissions'], 403);
        }

        $res = $tag->delete();

        if ($res) {
            return response()->json(['message' => 'Tag delete succesfully']);
        }

        return response()->json(['message' => 'Error to delete tag'], 500);
    }
}
