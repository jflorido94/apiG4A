<?php

namespace App\Http\Controllers;

use App\Http\Resources\StateResource;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(StateResource::collection(State::all()), 200);
    }

        /**
         * Display the specified resource.
         *
         * @param  \App\Models\State  $state
         * @return \Illuminate\Http\Response
         */
        public function show(State $state)
        {
            return response()->json(new StateResource($state),200);
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
            'name' => 'required|unique:states|max:50',
            'description' => 'required|max:4000',
        ])->validate();

        if (! Auth::user()->is_admin) {
            return response()->json(['message' => 'You don\'t have permissions'], 403);
        }

        $state = new State();

        $state->name = $request->input('name');
        $state->description = $request->input('description');

        $res = $state->save();

        if ($res) {
            return response()->json(['message' => 'State create succesfully'], 201);
        }
        return response()->json(['message' => 'Error to create state'], 500);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, State $state)
    {
        Validator::make($request->all(),[
            'name' => 'max:50',Rule::unique('states')->ignore($state->id),
            'description' => 'max:4000',
        ])->validate();

        if (! Auth::user()->is_admin) {
            return response()->json(['message' => 'You don\'t have permissions'], 403);
        }

        if (!empty($request->input('name'))) {
            $state->name = $request->input('name');
        }
        if (!empty($request->input('description'))) {
            $state->description = $request->input('description');
        }

        $res = $state->save();

        if ($res) {
            return response()->json(['message' => 'State update succesfully'], 201);
        }
        return response()->json(['message' => 'Error to update state'], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function destroy(State $state)
    {
        if (Auth::user()->is_admin) {
            return response()->json(['message' => 'You don\'t have permissions'], 403);
        }

        $res = $state->delete();

        if ($res) {
            return response()->json(['message' => 'State delete succesfully']);
        }

        return response()->json(['message' => 'Error to delete state'], 500);
    }
}
