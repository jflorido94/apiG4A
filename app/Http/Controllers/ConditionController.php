<?php

namespace App\Http\Controllers;

use App\Http\Resources\ConditionResource;
use App\Models\Condition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(ConditionResource::collection(Condition::all()), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Condition  $condition
     * @return \Illuminate\Http\Response
     */
    public function show(Condition $condition)
    {
        return response()->json(new ConditionResource($condition), 200);
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
            'name' => 'required|unique:conditions|max:30',
            'description' => 'required|max:4000',
            'colour' => 'required|unique:conditions|regex:/^#([a-f0-9]{3}){1,2}$/',
        ])->validate();

        if (! Auth::user()->is_admin) {
            return response()->json(['message' => 'You don\'t have permissions'], 403);
        }

        $condition = new Condition();

        $condition->name = $request->input('name');
        $condition->description = $request->input('description');
        $condition->colour = $request->input('colour');

        $res = $condition->save();

        if ($res) {
            return response()->json(['message' => 'Condition create succesfully'], 201);
        }
        return response()->json(['message' => 'Error to create condition'], 500);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Condition  $condition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Condition $condition)
    {
        Validator::make($request->all(),[
            'name' => 'max:30',Rule::unique('conditions')->ignore($condition->id),
            'description' => 'max:4000',
            'colour' => 'regex:/^#([a-f0-9]{3}){1,2}$/i',Rule::unique('conditions')->ignore($condition->id)
        ])->validate();

        if (! Auth::user()->is_admin) {
            return response()->json(['message' => 'You don\'t have permissions'], 403);
        }

        if (!empty($request->input('name'))) {
            $condition->name = $request->input('name');
        }
        if (!empty($request->input('description'))) {
            $condition->description = $request->input('description');
        }
        if (!empty($request->input('colour'))) {
            $condition->colour = $request->input('colour');
        }

        $res = $condition->save();

        if ($res) {
            return response()->json(['message' => 'Condition update succesfully'], 201);
        }
        return response()->json(['message' => 'Error to update condition'], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Condition  $condition
     * @return \Illuminate\Http\Response
     */
    public function destroy(Condition $condition)  //borrar en cascada?
    {
        if (! Auth::user()->is_admin) {
            return response()->json(['message' => 'You don\'t have permissions'], 403);
        }

        $res = $condition->delete();

        if ($res) {
            return response()->json(['message' => 'Condition delete succesfully']);
        }

        return response()->json(['message' => 'Error to delete condition'], 500);
    }
}
