<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ApiResponse;
use App\Http\Resources\ChoiceResource;
use App\Models\Choice;
use App\Models\Question;
use Illuminate\Http\Request;

class ChoiceController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($choice_id)
    {
        //
        try {
            $question_id = Question::where('uuid', $choice_id)->first();
            $choices = ChoiceResource::collection($question_id->choices()->get());
            return $this->successResponce($choices, 'all choices', 200);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->errorResponse("Error." . $th->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $question_id)
    {
        //
        try {
            //code...
            $question = Question::where('uuid', $question_id)->first();
            $choice = Choice::create([
                'content' => $request->content
            ]);
            $status = $request->status == 'true' ? 1 : 0;
            $question->choices()->attach($choice->id, ['status' => $status]);
            return $this->successResponse($question->choices()->get(), 'choice created successfuly', 201);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->errorResponse("Error." . $th->getMessage(), 500);
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
        try {
            //code...
            $question_id = Question::where('uuid', $id)->first();
            $choice = $question_id->choices()->update([
                'content' => $request->content
            ]);
            return $this->successResponse($choice, 'choice update successfuly', 200);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->errorResponce("Error." . $th->getMessage(), 500);
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
        //
        try {
            $choice_id = Choice::where('uuid', $id)->first();
            $choice_id->delete();
            return $this->successResponse(null, 'deleted successfuly', 200);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->errorResponse("Error." . $th->getMessage(), 500);
        }
    }
}