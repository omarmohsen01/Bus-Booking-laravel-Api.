<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Traits\ApiResponseTrait;
use App\Http\Controllers\Api\Traits\ValidateTrait;
use App\Http\Controllers\Interface\BusServiceInterface;
use App\Models\Bus;
use Illuminate\Support\Facades\Validator;


class BusController extends Controller
{
    use ApiResponseTrait,ValidateTrait;
    //for dependency injection
    protected $bus;
    protected $busService;
    public function __construct(Bus $bus,BusServiceInterface $busService)
    {
        $this->bus = $bus;
        $this->busService=$busService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bus=$this->busService->busIndex();
        if(!$bus)
        {
            return $this->ApiResponse('','Bus not found',404);
        }
        return $this->ApiResponse($bus,'ok',200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),$this->BusValidate());
        if($validator->fails())
        {
            return $this->ApiResponse($validator->errors(),null,400);
        }
        $bus=$this->busService->busStore($validator->validated());
        if($bus)
        {
            return $this->ApiResponse($bus,'bus created successfully',200);
        }
        return $this->ApiResponse($bus,'bus not saved',400);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bus=$this->busService->busShow($id);
        if(!$bus)
        {
            return $this->ApiResponse(['error' => 'bus not found'],'',404);
        }
        return $this->ApiResponse($bus,'' ,200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator=Validator::make($request->all(),$this->BusValidate());
        if($validator->fails())
        {
            return $this->ApiResponse($validator->errors(),null,400);
        }
        $bus=$this->busService->busUpdate($id,$validator->validated());
        if(!$bus)
        {
            return $this->ApiResponse(null,'this bus not found',404);
        }
        return $this->ApiResponse($bus,'bus updated successfully',200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bus=$this->busService->busDelete($id);

        if(!$bus)
        {
            return $this->apiResponse(null,'the bus not found',404);
        }
        else
        {
            return $this->apiResponse(null,'the bus deleted',200);
        }        
        
    }
    
}