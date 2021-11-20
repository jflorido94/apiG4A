<?php

namespace App\Http\Controllers;

use App\Http\Resources\BanReasonResource;
use App\Models\BanReason;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BanReasonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(BanReasonResource::collection(BanReason::all()), 200);
    }

        /**
         * Display the specified resource.
         *
         * @param  \App\Models\BanReason  $banReason
         * @return \Illuminate\Http\Response
         */
        public function show(BanReason $banReason)
        {
            return response()->json($banReason,200);
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
            'name' => 'required|max:180',
            'rule' => 'required|max:4000',
        ])->validate();

        if (! Auth::user()->is_admin) {
            return response()->json(['message' => 'You don\'t have permissions'], 403);
        }

        $banReason = new BanReason();

        $banReason->name = $request->input('name');
        $banReason->rule = $request->input('rule');

        $res = $banReason->save();

        if ($res) {
            return response()->json(['message' => 'BanReason create succesfully'], 201);
        }
        return response()->json(['message' => 'Error to create banReason'], 500);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BanReason  $banReason
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BanReason $banReason)
    {
        Validator::make($request->all(),[
            'name' => 'max:180',
            'rule' => 'max:4000',
        ])->validate();

        if (! Auth::user()->is_admin) {
            return response()->json(['message' => 'You don\'t have permissions'], 403);
        }

        if (!empty($request->input('name'))) {
            $banReason->name = $request->input('name');
        }
        if (!empty($request->input('rule'))) {
            $banReason->rule = $request->input('rule');
        }

        $res = $banReason->save();

        if ($res) {
            return response()->json(['message' => 'BanReason create succesfully'], 201);
        }
        return response()->json(['message' => 'Error to create banReason'], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BanReason  $banReason
     * @return \Illuminate\Http\Response
     */
    public function destroy(BanReason $banReason)  //borrar en cascada?
    {

        if (Auth::user()->is_admin) {
            return response()->json(['message' => 'You don\'t have permissions'], 403);
        }

        $res = $banReason->delete();

        if ($res) {
            return response()->json(['message' => 'BanReason delete succesfully']);
        }

        return response()->json(['message' => 'Error to delete banReason'], 500);
    }
}
