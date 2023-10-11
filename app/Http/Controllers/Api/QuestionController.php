<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use App\Http\Resources\ChoiceResource;
use App\Http\Resources\QuestionResource;
use App\Models\College;
use App\Models\Question;
use App\Models\Subject;
use App\Models\Term;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    use ApiResponse;

    public function subjectQuestions($id)
    {
        try {
            $subject = Subject::where('uuid', $id)->first();
            $questions = ($subject->questions()->WhereNotNull('term_id')
                ->inRandomOrder()->limit(50)->get());
            foreach ($questions as $question) {
                $subject = Subject::find($question->subject_id);
                $choices = $question->choices()->inRandomOrder()->get();
                $question['subject_name'] = $subject->name;
                $question['choices'] = $choices;
            }
            return $this->successResponse(QuestionResource::collection($questions), 'all questions', 200);
        } catch (\Throwable $th) {
            return $this->errorResponse('Error => ' . $th->getMessage(), 500);
        }
    }
    public function index($id)
    {

        try {

            if ($subject = Subject::where('uuid', $id)->first()) {
                $questions = $subject->questions()
                    ->inRandomOrder()->limit(50)->get();
            } elseif ($term = Term::where('uuid', $id)->first()) {
                $questions = ($term->questions()->inRandomOrder()->limit(50)->get());
            } else {
                $college = College::where('uuid', $id)->first();
                $questions = $college->questions()
                    ->inRandomOrder()
                    ->limit(50)->get();
            }
            foreach ($questions as $question) {
                $subject = Subject::find($question->subject_id);
                $choices = $question->choices()->inRandomOrder()->get();
                $question['subject_name'] = $subject->name;
                $question['choices'] = $choices;
            }
            return $this->successResponse(QuestionResource::collection($questions), 'all questions', 200);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->errorResponse("Error." . $th->getMessage(), 500);
        }
    }


    public function store(Request $request, $id)
    {
        //

        try {
            $subject = Subject::where('uuid', $id)->first();
            if ($request->has('term_id')) {
                $term =  Term::where('uuid', $request->term_id)->first();
                $question['term_name'] = $term->name;
            }
            $question = new QuestionResource($subject->questions()->create(
                [
                    'content' => $request->content,
                    'reference' => $request->reference,
                    'college_id' => $subject->college_id,
                    'term_id' => $term->id ?? null
                ]
            ));
            $question['subject_name'] = $subject->name;
            return $this->successResponse($question, 'question created successfuly', 201);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->errorResponse("Error. " . $th->getMessage(), 500);
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
            $question_id = Question::where('uuid', $id)->first();
            $question_id->delete();
            return $this->successResponse(null, 'deleted successfuly', 200);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->errorResponse("Error." . $th->getMessage());
        }
    }

    public function correctQuestions(Request $request)
    {
        try {
            static $correct_questions = 0;
            static $incorrect_questions = 0;
            $collectoin = array();
            $correct = array();
            $incorrect = array();
            $q = $request->questions_answres;
            foreach ($q as $question) {
                $qu = Question::where('uuid', $question['question_id'])->first();
                $c = $qu->choices()->where('uuid', $question['choice_id'])->first();
                if ($c->pivot->status == 1) {
                    $correct_questions += 1;
                    $correct[] = new QuestionResource($qu);
                } else {
                    $incorrect_questions += 1;
                    $incorrect[] = new QuestionResource($qu);
                }
                $subject = Subject::find($qu->subject_id);
                $choices = $qu->choices()->inRandomOrder()->get();
                $qu['subject_name'] = $subject->name;
                $qu['choices'] = $choices;
                foreach ($qu['choices'] as $choice) {
                }
            }
            $collectoin['correct_questions'] = $correct;
            $collectoin['correct_questions_count'] = $correct_questions;
            $collectoin['incorrect_questions'] = $incorrect;
            $collectoin['incorrect_questions_count'] = $incorrect_questions;
            return $this->successResponse($collectoin, 'answres', 200);
        } catch (\Throwable $th) {
            return $this->errorResponse("Error => " . $th->getMessage(), 500);
        }
    }
}