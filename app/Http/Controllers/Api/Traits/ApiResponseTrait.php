<?php 
namespace App\Http\Controllers\Api\Traits;

trait ApiResponseTrait
{
    public function ApiResponse($data=null,$message=null,$status=null){
        $array=[
            'data'=>$data,
            'message'=>$message,
            'status'=>$status
        ];
         return response()->json($array);
    }

    public function ApiMessageResponse($data,$dataDisplay=null,$Message=null,$status=null){
        if($data) 
        {
             $this->ApiResponse($dataDisplay, $Message, $status);
        }
    }
}