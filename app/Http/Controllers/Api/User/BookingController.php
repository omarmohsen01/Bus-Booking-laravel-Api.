<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Traits\ApiResponseTrait;
use App\Http\Controllers\Api\Traits\ValidateTrait;
use App\Http\Controllers\Interface\BookingServiceInterface;
use App\Http\Controllers\Services\BookingServices;
use App\Models\Ticket;
use Illuminate\Support\Facades\Validator;


class BookingController extends Controller
{
    use ApiResponseTrait,ValidateTrait;
    protected $bookingServices;
    protected $ticket;
    protected $appointment;
    public function __construct(BookingServiceInterface $bookingServices,Ticket $ticket,Appointment $appointment)
    {
        $this->ticket=$ticket;
        $this->appointment=$appointment;
        $this->bookingServices=$bookingServices;
        $this->middleware('auth:sanctum');
    }
    
    public function index()
    {
        $appointment=$this->bookingServices->bookingIndex();
        if(!$appointment){
            return $this->ApiResponse('','no appointments found',404);
        }
        return $this->ApiResponse($appointment,'ok',200);
    } 

    public function show($id)
    {
        $appointment=$this->bookingServices->bookingShow($id);
        if(!$appointment)
        {
            return $this->ApiResponse(['error' => 'appointment not found'],'',404);
        }
        return $this->ApiResponse($appointment,'' ,200);
    }

    public function bookTicket(Request $request)
    {
        $validator=Validator::make($request->all(),$this->BookingValidate());
        if($validator->fails())
        {
            return $this->ApiResponse($validator->errors(),null,400);
        }
        $appointment=$this->appointment->find($request->appointment_id);
        
        if(!$appointment){
            return $this->ApiResponse(null,'appointment not found',404);
        }
        
        if($appointment->available_seats==0){
            return $this->ApiResponse(null,'this appointment is not available',422);
        }
    
        $user = $request->user();
        $ticket=$this->ticket->create([
            'user_id'=>$user->id,
            'appointment_id'=>$request->appointment_id,
            'seat_number'=>$request->seat_number
        ]);
        $ticket->save();
        $appointment->available_seats--;
        return $this->ApiResponse($ticket->with('appointments','users'),'ticket booked successfully');
        
    }
    

    //under maintenance
    public function cancelTicket(Request $request)
    {
        $user=$request->user();
        $ticketSearch=$this->ticket->where('user_id',$user->id)->get();

        if(!$ticketSearch)
        {
            return $this->apiResponse(null,'you don"t have any ticket',404);
        }
        $ticketSearch->delete($ticketSearch->id);
        if($ticketSearch)
        {
            return $this->apiResponse(null,'the ticket deleted',200);
        }
        
    }
}