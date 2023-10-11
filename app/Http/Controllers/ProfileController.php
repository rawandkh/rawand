<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ApiResponse;
use App\Http\Controllers\Api\UploadImage;
use App\Http\Requests\ProfileRequest;
use App\Http\Resources\ProfileResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{
    use UploadImage, ApiResponse;
    //

    public function userInfo($user_id)
    {
        try {
            // $user_id = Auth::user()->user_id;
            $user = User::where('uuid', $user_id)->first();
            if ($user) {
                return $this->successResponse(new ProfileResource($user), 'user found', 200);
            }
        } catch (\Throwable $th) {
            return $this->errorResponse("Error . " . $th->getMessage(), 500);
        }
    }

    public function update(Request $request, $user_id)
    {
        try {
            // $user_id = Auth::user()->user_id;
            $user = User::where('uuid', $user_id)->first();
            $users = User::all();
            foreach ($users as $u) {
                if ($u->phone === $request->phone) {
                    throw new Exception("Phone Already Exists");
                }
            }
            if ($user) {
                $this->deletePhoto($user->photo);
                $user->user_name = $request->user_name ?? $user->user_name;
                $user->phone = $request->phone ?? $user->phone;
                $this->uploadImage($request, 'photo', $user, 'profile/');
                $user->save();
                $result = new ProfileResource($user);
                return $this->successResponse(
                    $result,
                    'Updating Successfully',
                    200
                );
            } else {
                // return $this->errorResponse('', 404);
                throw new Exception('User Not Found');
            }
        } catch (\Throwable $th) {
            return $this->errorResponse("Error . " . $th->getMessage(), 500);
        }
    }
}