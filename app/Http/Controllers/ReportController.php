<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReportResource;
use App\Models\BanReason;
use App\Models\Product;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(ReportResource::collection(Report::latest()->paginate()),200); //util para admins
    }

        /**
         * Display the specified resource.
         *
         * @param  \App\Models\Report  $report
         * @return \Illuminate\Http\Response
         */
        public function show(Report $report)
        {
            return response()->json(new ReportResource($report),200);
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
            'request' => 'required|max:4000',
            'ban_reason_id' => 'required|exists:ban_reasons,id',
            'item_reportable' => 'required|exists:products,id',  //no se como hacerlo
        ])->validate();

        $user = Auth::user();
        $ban_reason = BanReason::find($request->input('ban_reason_id'));
        $item_reportable = Product::find($request->input('item_reportable'));

        $report = new Report();

        $report->user()->associate($user);
        $report->ban_reason()->associate($ban_reason);
        $report->reportable()->associate($item_reportable);

        $report->request = $request->input('request');

        $res = $report->save();

        if ($res) {
            return response()->json(['message' => 'Report create succesfully'], 201);
        }
        return response()->json(['message' => 'Error to create report'], 500);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        Validator::make($request->all(),[
            'respond' => 'required|max:4000',
            'is_warning' => 'required|boolean',
        ])->validate();

        if (Auth::user()->is_admin) {
            return response()->json(['message' => 'You don\'t have permissions'], 403);
        }

        if (!empty($request->input('respond'))) {
            $report->respond = $request->input('respond');
        }
        if (!empty($request->input('is_warning'))) {
            $report->is_warning = $request->input('is_warning');
        }

        $res = $report->save();

        if ($res) {
            return response()->json(['message' => 'Report update succesfully'],204);
        }

        return response()->json(['message' => 'Error to update report'], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        if (Auth::id() !== $report->user->id) {
            return response()->json(['message' => 'You don\'t have permissions'], 403);
        }

        $res = $report->delete();

        if ($res) {
            return response()->json(['message' => 'Report delete succesfully']);
        }

        return response()->json(['message' => 'Error to delete report'], 500);
    }
}
