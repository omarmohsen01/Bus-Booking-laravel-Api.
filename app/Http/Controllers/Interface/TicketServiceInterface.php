<?php
namespace App\Http\Controllers\Interface;
interface TicketServiceInterface{
    public function ticketIndex();
    public function ticketShow($id);
    public function ticketStore($data);
    public function ticketUpdate($id,$data);
    public function ticketDelete($id);
    public function TicketShowInactiveTicket();
    public function TicketActiveAllTicket();
    public function TicketActiveTicket($id);
}