<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CollegeRequest;
use App\Http\Resources\CollegeResource;
use App\Models\Category;
use App\Models\College;
use Exception;
use Illuminate\Http\Request;

class CollegeController extends Controller
{
    use ApiResponse, UploadImage;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $colleges = CollegeResource::collection(College::all());
            return $this->successResponse($colleges, "all colleges", 200);
        } catch (\Exception $e) {
            return $this->errorResponse("ERROR. " . $e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CollegeRequest $request, $id)
    {
        try {
            $category = Category::where('uuid', $id)->first();
            if ($category) {
                $college = $category->colleges()->create([
                    'name' => $request->name
                ]);
                $this->uploadImage($request, 'logo', $college, 'CollegeLogo/');
                $college->save();
                return $this->successResponse($college, 'collage created successfuly', 201);
            } else {
                throw new Exception("Category Not Found");
            }
        } catch (\Exception $e) {
            return $this->errorResponse("ERROR. " . $e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        try {
            $college = College::where('uuid', $uuid)->first();
            // $college->name = $request->name ?? $college->name;
            $this->deletePhoto($college->logo);
            $this->uploadImage($request, 'logo', $college, 'CollegeLogo/');
            $college->save();
            return $this->successResponse($college, 'the college updated successfuly', 200);
        } catch (\Exception $e) {
            return $this->errorResponse("ERROR. " . $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        try {
            $college = College::where('uuid', $uuid)->get();
            $college->delete();
            $this->deletePhoto($college->logo);
            return $this->successResponse(null, "the category deleted successfully", 200);
        } catch (\Exception $e) {
            return $this->errorResponse("ERROR. " . $e->getMessage(), 500);
        }
    }
}