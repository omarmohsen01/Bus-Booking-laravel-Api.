<?php
namespace App\Http\Controllers\Interface;
interface BookingServiceInterface{
    public function bookingIndex();
    public function bookingShow($id);
    public function bookingBookTicket($data);
}