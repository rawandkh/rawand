<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Http\Resources\SliderResource;
use App\Models\Slider;
use Exception;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    //
    use ApiResponse, UploadImage;

    public function index()
    {

        try {
            $sliders = SliderResource::collection(Slider::all());
            return $this->successResponse($sliders, 'all sliders', 200);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->errorResponse("Error." . $th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SliderRequest $request)
    {
        try {
            $slider = Slider::create([
                'image_url' => $request->image_url,
                'link' => $request->link
            ]);
            $this->uploadImage($request, 'image_url', $slider, 'sliders/');
            $slider->save();
            return $this->successResponse($slider, 'slider created successfully', 201);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->errorResponse("Error." . $th->getMessage());
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
            //code...
            $slider = Slider::where('uuid', $id)->first();
            if ($slider) {
                $this->deletePhoto($slider->image_url);
                $slider->delete();
                return $this->successResponse(null, 'deleted successfuly', 200);
            } else {
                throw new Exception("Slider Not Found");
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->errorResponse("Error." . $th->getMessage());
        }
    }
}