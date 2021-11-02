<?php

namespace App\Http\Controllers;

use App\Models\BanReason;
use Illuminate\Http\Request;

class BanReasonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(BanReason::all(),200);
    }

        /**
         * Display the specified resource.
         *
         * @param  \App\Models\BanReason  $banReason
         * @return \Illuminate\Http\Response
         */
        public function show(BanReason $banReason)
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BanReason  $banReason
     * @return \Illuminate\Http\Response
     */
    public function destroy(BanReason $banReason)
    {
        //
    }
}
