<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TermRequest;
use App\Http\Resources\TermResource;
use App\Models\College;
use App\Models\Term;
use Exception;
use Illuminate\Http\Request;

class TermController extends Controller
{
    use ApiResponse;
    //
    public function index(Request $request, $id)
    {
        try {
            if ($request->type == "ماستر") {
                $type = true;
            } else {
                $type = false;
            }
            $college = College::where('uuid', $id)->first();
            $terms = TermResource::collection($college->terms()->where('type', $type)->get());
            return $this->successResponse($terms, 'all terms', 200);
        } catch (\Throwable $th) {
            return $this->errorResponse("Error. " . $th->getMessage(), 500);
        }
    }

    public function store(TermRequest $request, $college_id)
    {
        try {
            $college = College::where('uuid', $college_id)->first();
            if ($college) {
                if ($request->type == "ماستر") {
                    $type = true;
                } else {
                    $type = false;
                }
                $term =  $college->terms()->create([
                    'name' => $request->name,
                    'type' => $type
                ]);
                return $this->successResponse($term, 'terms created successfuly', 201);
            } else {
                throw new Exception("college Not Found");
            }
        } catch (\Throwable $th) {
            return $this->errorResponse("Error. " . $th->getMessage(), 500);
        }
    }


    public function update(Request $request, $id)
    {
        //
        try {
            //code...
            $college = College::where('uuid', $id)->first();
            if ($college) {

                $college = $college->terms()->update([
                    'name' => $request->name
                ]);
                return $this->successResponse($college, 'terms updated successfuly', 200);
            } else {
                throw new Exception("college Not Found");
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->errorResponse("Error." . $th->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            $term = Term::where('uuid', $id)->first();
            if ($term) {
                $term->delete();
                return $this->successResponse(null, 'term deleted successfuly', 200);
            } else {
                throw new Exception("Term Not Found");
            }
        } catch (\Throwable $th) {
            return $this->errorResponse("Error => " . $th->getMessage());
        }
    }
}