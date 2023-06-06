<?php
namespace App\Http\Controllers\Services;

use App\Http\Controllers\Interface\BookingServiceInterface;
use App\Models\Appointment;
use App\Models\Ticket;

class BookingServices implements BookingServiceInterface
{
    //for dependency injection
    protected $appointment;
    protected $ticket;
    public function __construct(Appointment $appointment,Ticket $ticket)
    {
        $this->appointment = $appointment;
        $this->ticket=$ticket;
    }

    public function bookingIndex()
    {
        $appointmentsCount=$this->appointment->count();
        if($appointmentsCount==0){
            return null;
        }
        $appointments=Appointment::with('buses')->get();
        return $appointments;
    }

    public function bookingShow($id)
    {
        $appointment=$this->appointment->with('buses')->find($id);
        if(!$appointment)
        {
            return null;
        }
        return $appointment;
    }

    public function bookingBookTicket($data)
    {
        $appointmentNotToBook=$this->appointment->find([$data=>'appointment_id']);
        
        return $appointmentNotToBook;
        
    }
    
}