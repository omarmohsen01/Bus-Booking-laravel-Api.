<?php
namespace App\Http\Controllers\Services;

use App\Http\Controllers\Interface\TicketServiceInterface;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class TicketServices implements TicketServiceInterface
{
    //for dependency injection
    protected $ticket;
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function ticketIndex(){
        $ticketCount=$this->ticket->count();
        if($ticketCount==0) {
            return null;
        }
        $ticket=$this->ticket->with(['users','appointments'])->get();
        return $ticket;
    }

    public function ticketShow($id)
    {
        $ticket=$this->ticket->with(['users','appointments'])->find($id);
        if(!$ticket)
        {
            return null;
        }
        return $ticket;
    }

    public function ticketStore($data){
        $ticket=$this->ticket->create($data);
        return $ticket;
    }
    
    public function ticketUpdate($id,$data){
        $ticket = $this->ticket->find($id);
        if (!$ticket) {
            return null;
        }
        $ticket->update($data);
        $ticket->save();
        return $ticket;
    }
    
    public function ticketDelete($id){
        $ticket=$this->ticket->find($id);
        if(!$ticket)
        {
            return null;
        }
        else{
            $ticket->delete($id);
            return 1;
        }
    }
    
    public function TicketShowInactiveTicket(){
        $ticketCount=$this->ticket->where('status','=','inactive')->count();
        if($ticketCount==0)
        {
            return null;
        }
        $ticket=$this->ticket->with(['users','appointments'])->where('status','=','inactive')->get();
        return $ticket;
    }
    
    public function TicketActiveAllTicket(){
        $ticketsNotActive=$this->ticket->where('status','=','inactive')->get();
        if(!$ticketsNotActive)
        {
            return null;
        }
        return DB::table('tickets')->where('status','=','inactive')->update(['status'=>'active']);
    }
    
    public function TicketActiveTicket($id){
        $ticketAlreadyActive=$this->ticket->where('status','=','active')->find($id);
        if($ticketAlreadyActive){
            return null;
        }
        else{
            $ticket=$this->ticket->find($id);
            $ticket->update(['status'=>'active']);
            $ticket->save();
        }
    }
}