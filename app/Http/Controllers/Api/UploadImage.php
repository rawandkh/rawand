<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\File;

trait UploadImage
{
    /**
     * $request => git file from requset 

     * $input => name of input ex: $request->file('logo') -> $input = logo

     * $data => object from data which you want to insert file into 

     * $folder_name => name of folder stored in public path 

     * file will stored in this $folder_name ex : public/profile/file -> $folder_name = profile
     */
    public function uploadImage($request, $input = "image", $data, $folder_name)
    {
        try {


            if ($request->hasFile($input)) {
                $file = $request->file($input);
                $file_contents = $file->get();
                $photo64 = base64_encode($file_contents);
                $file_name = uniqid() . '.' . $file->getClientOriginalExtension();
                $path = 'photo/' . $folder_name;
                $file_full_name = asset($path . $file_name);
                $file->move($path, $file_name);
                // file_put_contents($file_full_name, $photo64);

                $data->$input = $file_full_name;

            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function deletePhoto($file_name)
    {

        if (File::exists($file_name)) {
            File::delete($file_name);
            return;
        } else {
            return false;
        }
    }
}