<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReportResource;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //

        try {
            $code = Auth::user();

            $user = User::where('uuid', $code->user_id)->first();
            $reports = ReportResource::collection($user->reports()->get());
            return $this->successResponse($reports, 'all reports', 200);
        } catch (\Throwable $th) {

            return $this->errorResponse("Error." . $th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        //
        try {
            $user = User::where('uuid', $id)->first();
            $report = $user->reports()->create([

                'content' => $request->content
            ]);
            return $this->successResponse($report, 'choice created successfuly', 201);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->errorResponse("Error." . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try {
            $report = Report::where('uuid', $id)->first();
            $report->delete();
            return $this->successResponse(null, 'deleted successfuly', 200);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->errorResponse("Error." . $th->getMessage());
        }
    }
}