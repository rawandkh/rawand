<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionResource;
use App\Models\Question;
use App\Models\Subject;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImportantQuestionController extends Controller
{
    use ApiResponse;
    //

    public function getImportantQuestions()
    {
        try {
            $user_id = Auth::user()->user_id;
            $user = User::find($user_id);
            $questions = $user->questions()->get();
            foreach ($questions as $question) {
                $subject = Subject::find($question->subject_id);
                $choices = $question->choices()->get();
                $question['subject_name'] = $subject->name;
                $question['choices'] = $choices;
            }
            return $this->successResponse(QuestionResource::collection($questions), 'Important Question', 200);
        } catch (\Throwable $th) {
            return $this->errorResponse('Error => ' . $th->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $user_id = Auth::user()->user_id;
            $user = User::find($user_id);
            $question = Question::where('uuid', $request->question_id)->first();
            if ($user->questions()->where('question_id', $question->id)->get()) {
                throw new Exception("Question Already exist in your importants");
            }
            $user->questions()->attach($question->id);
            return $this->successResponse($question, 'adding a new question to imporatnt done', 201);
        } catch (\Throwable $th) {
            return $this->errorResponse('Error => ' . $th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $user_id = Auth::user()->user_id;
            $user = User::find($user_id);
            $question = Question::where('uuid', $request->question_id)->first();
            if ($question) {
                if ($user->questions()->detach($question->id)) {
                    return $this->successResponse($question, 'important question deleted successfully', 201);
                } else {
                    throw new Exception("Question Not Found in Your importatns");
                }
            } else {
                throw new Exception("Question Not Found ");
            }
        } catch (\Throwable $th) {
            return $this->errorResponse('Error => ' . $th->getMessage());
        }
    }
}