<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\Traits\ApiResponseTrait;
use App\Http\Controllers\Api\Traits\ValidateTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    use ApiResponseTrait,ValidateTrait;
    
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $user = $request->user();

        if ($user) {
            return response()->json([
                'user' => $user,
            ]);
        } else {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }
    
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user=$request->user();

        if (!$user) {
            return $this->ApiResponse(null, 'User not found', 404);
        }

        $validator = Validator::make($request->all(), $this->ProfileUpdate($user->id));

        if ($validator->fails()) {
            return $this->ApiResponse($validator->errors(), null, 422);
        }

        $user->fill($validator->validated());

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return $this->ApiResponse($user, 'User profile updated successfully');
    }

}