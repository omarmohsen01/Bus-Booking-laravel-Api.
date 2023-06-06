<?php 
namespace App\Http\Controllers\Services;

use App\Http\Controllers\Interface\AppointmentServiceInterface;
use App\Models\Appointment;

class AppointmentServices implements AppointmentServiceInterface
{
    //for dependency injection
    protected $appointment;
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }
    
    public function indexAppointment()
    {
        $appointmentsCount=$this->appointment->count();
        if($appointmentsCount==0)
        {
            return null;
        }
        $appointments=$this->appointment->with('buses')->get();
        return $appointments;
    }
    
    public function appointmentShow(int $id)
    {
        $appointment=$this->appointment->with('buses')->find($id);
        return $appointment;
    }

    public function appointmentStore(array $data)
    {
        $appointment=$this->appointment->create($data);
        return $appointment;    
    }

    public function appointmentUpdate(int $id, array $data)
    {
        $appointment = $this->appointment->with('buses')->find($id);
        if (!$appointment) {
            return null;
        }
        $appointment->update($data);
        $appointment->save();

        return $appointment;
    }

    public function appointmentDelete($id)
    {
        $appointment=$this->appointment->find($id);
        if(!$appointment)
        {
            return null;
        }
        else{
            $appointment->delete($id);
            return 1;
        }
    }
    
}