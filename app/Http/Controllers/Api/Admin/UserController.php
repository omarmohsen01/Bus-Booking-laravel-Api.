<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\Traits\ApiResponseTrait;
use App\Http\Controllers\Api\Traits\ValidateTrait;
use App\Http\Controllers\Interface\UserServiceInterface;


class UserController extends Controller
{
    use ApiResponseTrait,ValidateTrait;
    //for dependency injection
    protected $user;
    protected $userService;

    public function __construct(User $user,UserServiceInterface $userService)
    {
        $this->user = $user;
        $this->userService=$userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users=$this->userService->userIndex();
        if(empty($users)){
            return $this->ApiResponse('','user not found',404);
        }
        return $this->ApiResponse($users,'ok',200);
    }

    /**
     * show user data was selected
     */
    public function show($id)
    {
        $user=$this->userService->userShow($id);
        if (!$user) {
            return $this->ApiResponse(['error' => 'User not found'],'',404);
        }
        return $this->ApiResponse($user,'' ,200);
        
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validators=Validator::make($request->all(),$this->UserValidate());
        if($validators->fails()){
            $this->ApiResponse($validators->errors(),'',404);   
        }
        $user=$this->userService->userStore($validators->validated());
        $userSaved=$user->save();
        if($userSaved){
            return $this->apiResponse($user,'user successfully created',200);
        }
        return $this->apiResponse(null,'the user not save',400);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator=Validator::make($request->all(),$this->UserUpdateValidate($id));
        if($validator->fails())
        {
            return $this->ApiResponse($validator->errors(),null,422);
        }
        $user=$this->userService->userUpdate($id,$validator->validated());
        if($user){
            return $this->ApiResponse($user,'User updated successfully',200);
        }
        return $this->ApiResponse(null,'this user not found',404);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user=$this->userService->userDelete($id);
        if($user){
            return $this->apiResponse(null,'the user deleted',200);
        }else{
            return $this->apiResponse(null,'the user not found',404);
        }
        
    }
}