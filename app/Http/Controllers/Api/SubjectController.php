<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubjectRequest;
use App\Http\Resources\SubjectResource;
use App\Models\College;
use App\Models\Subject;
use Illuminate\Support\Arr;

class SubjectController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($college_id)
    {
        try {
            $college = College::where('uuid', $college_id)->first();
            $subjects = SubjectResource::collection($college->subjects()->get());
            return $this->successResponse($subjects, 'Subjects Found', 200);
        } catch (\Throwable $th) {
            return $this->errorResponse("Error . " . $th->getMessage(), 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\SubjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubjectRequest $request, $id)
    {
        try {
            $college = College::where('uuid', $id)->first();
            $subject = $college->subjects()->create([
                'name' => $request->name
            ]);
            return $this->successResponse(new SubjectResource($subject), "Subject Created Successfully", 201);
        } catch (\Throwable $th) {
            return $this->errorResponse("Error . " . $th->getMessage(), 400);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $subject = Subject::where('uuid', $id)->first();
            $subject->delete();
            return $this->successResponse(null, "Subject Deleted Successfully", 200);
        } catch (\Throwable $th) {
            return $this->errorResponse("Error . " . $th->getMessage(), 400);
        }
    }
}