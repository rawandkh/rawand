<?php

namespace App\Http\Controllers\Api;

trait ApiResponse
{
    public function successResponse($data = null, string $message = null, int $status = 200)
    {
        return response()->json([
            'data' => $data,
            'status' => true,
            'message' => $message,
        ], $status);
    }

    public function errorResponse($message = null, $status = 404)
    {
        return response()->json([
            'message' => $message,
        ], $status);
    }
}