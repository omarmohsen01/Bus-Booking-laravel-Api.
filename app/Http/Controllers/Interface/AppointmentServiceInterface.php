<?php 
namespace App\Http\Controllers\Interface;
interface AppointmentServiceInterface
{
    public function indexAppointment();
    public function appointmentShow(int $id);
    public function appointmentStore(array $data);
    public function appointmentUpdate(int $id, array $data);
    public function appointmentDelete($id);
}