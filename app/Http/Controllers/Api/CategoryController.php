<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
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
            $categories = CategoryResource::collection(Category::all());
            return $this->successResponse($categories, "all categories");
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
    public function store(CategoryRequest $request)
    {
        try {
            $category = new Category();
            $category->name = $request->name;
            $this->uploadImage($request, 'logo', $category, 'CategoryLogo/');
            $category->save();
            return $this->successResponse($category, "category created successfuly!", 201);
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
            $category = Category::where('uuid', $uuid)->fisrt();
            if ($category) {
                $category->name = $request->name ?? $category->name;
                $this->uploadImage($request, 'logo', $category, 'CategoryLogo/');
                $category->save();
                return $this->successResponse('the category updated successfuly');
            } else {
                throw new Exception("Category Not Found");
            }
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
    public function destroy($id)
    {
        try {
            $category = Category::where('uuid', $id)->first();
            if ($category) {
                $category->delete($category->id);
                $this->deletePhoto($category->logo);
                return $this->successResponse(null, "the category deleted successfully", 200);
            } else {
                throw new Exception("Category Not Found");
            }
        } catch (\Exception $e) {
            return $this->errorResponse("ERROR. " . $e->getMessage(), 500);
        }
    }
}