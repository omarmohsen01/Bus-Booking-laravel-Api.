<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Traits\ApiResponseTrait;
use App\Http\Controllers\Api\Traits\ValidateTrait;
use App\Models\Appointment;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Interface\AppointmentServiceInterface;

class AppointmentController extends Controller
{
    use ApiResponseTrait,ValidateTrait;
    //for dependency injection
    protected $appointment;
    protected $appointmentService;

    public function __construct(Appointment $appointment,AppointmentServiceInterface $appointmentService)
    {
        $this->appointment = $appointment;
        $this->appointmentService=$appointmentService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointment=$this->appointmentService->indexAppointment();
        if(!$appointment){
            return $this->ApiResponse('','appointments not found',404);
        }
        return $this->ApiResponse($appointment,'ok',200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),$this->AppointmentValidate());
        if($validator->fails())
        {
            return $this->ApiResponse($validator->errors(),null,400);
        }
        $appointment=$this->appointmentService->appointmentStore($validator->validated());
        if($appointment)
        {
            return $this->ApiResponse($appointment,'appointment created successfully',200);
        }
        return $this->ApiResponse($appointment,'appointment not saved',400);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $appointment=$this->appointmentService->appointmentShow($id);
        if(!$appointment)
        {
            return $this->ApiResponse(['error' => 'appointment not found'],'',404);
        }
        return $this->ApiResponse($appointment,'' ,200);
        
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator=Validator::make($request->all(),$this->AppointmentValidate());
        if($validator->fails())
        {
            return $this->ApiResponse($validator->errors(),'',400);
        }
        $appointment=$this->appointmentService->appointmentUpdate($id,$validator->validated());
        if(!$appointment)
        {
            return $this->ApiResponse(null,'this appointment not found',404);
        }
        return $this->ApiResponse($appointment,'appointment updated successfully',200);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $appointment=$this->appointmentService->appointmentDelete($id);

        if(!$appointment)
        {
            return $this->apiResponse(null,'the appointment not found',404);
        }
        if($appointment)
        {
            return $this->apiResponse(null,'the appointment deleted',200);
        }
    }
}