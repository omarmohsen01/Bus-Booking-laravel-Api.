<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\Traits\ApiResponseTrait;
use App\Http\Controllers\Api\Traits\ValidateTrait;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public $user;
    use ApiResponseTrait,ValidateTrait;
    
    public function setUser(User $user)
    {
        $this->user=$user;
    }
    
    public function register(Request $request)
    {
        $validator=Validator::make($request->all(),$this->UserValidate());
        
        if($validator->fails())
        {
            return $this->ApiResponse(['errors'=>$validator->errors()],null,422);
        }
        $user=User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]));
        $token=$user->createToken('MyApp')->plainTextToken;
        
        return $this->ApiResponse(['Token'=>$token,'user'=>$user],'User successfully registered',200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), $this->LoginValidate());
    
        if ($validator->fails()) {
            return $this->ApiResponse($validator->errors(),null,422);
        }
    
        $credentials = $validator->validated();
    
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token=$request->user()->createToken('api-token');
            $user->api_token=$token->plainTextToken;
          
            $data=['token' => $token->plainTextToken,
                'token_type'=>'Bearer',
                'abilities'=>$token->accessToken->abilities,
                'data'=>$user];
            return $this->ApiResponse($data,null,200);
        } else { 
            return $this->ApiResponse(['error' => 'Invalid credentials'],null,401);
        }
          
    }
    
    public function logout()
    {
        Auth::logout();
        
        return $this->ApiResponse(null,'Successfully logged out',200);
    }

    
    public function userProfile() {
        return $this->ApiResponse(auth()->user());
    }
}