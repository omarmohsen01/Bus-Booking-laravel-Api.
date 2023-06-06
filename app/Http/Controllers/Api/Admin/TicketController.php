<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Traits\ApiResponseTrait;
use App\Http\Controllers\Api\Traits\ValidateTrait;
use App\Http\Controllers\Interface\TicketServiceInterface;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    use ApiResponseTrait,ValidateTrait;
    //for dependency injection
    protected $ticket;
    protected $ticketService;
    public function __construct(ticket $ticket,TicketServiceInterface $ticketService)
    {
        $this->ticket = $ticket;
        $this->ticketService=$ticketService;
    }
    /**
     * Display a listing of the tickets.
     */
    public function index()
    {
        $ticket=$this->ticketService->ticketIndex();
        if(!$ticket)
        {
            return $this->ApiResponse('','Ticket not found',404);
        }
        return $this->ApiResponse($ticket,'ok',200);
        
    }

    /**
     * Display a listing of the inactiveTickets.
     */
    public function showInactiveTicket()
    {
        $ticket=$this->ticketService->TicketShowInactiveTicket();
        if(!$ticket)
        {
            return $this->ApiResponse('','there is no inactive tickets',404);
        }
        return $this->ApiResponse($ticket,'ok',200);
    }
    
    /**
     * Update All tickets statuses to active.
     */

    public function activeAllTickets()
    {
        $ticketsNotActive=$this->ticketService->TicketActiveAllTicket();
        if(!$ticketsNotActive)
        {
            return $this->ApiResponse(['error' => 'there is no inactive tickets'],'',404);
        }
        return $this->ApiResponse('','all tickets activated',200);
    }

    /**
     * Update selected ticket status to active.
     */

    public function activeTicket($id)
    {
        $ticket=$this->ticket->find($id);
        if(!$ticket)
        {
            return $this->ApiResponse(['error' => 'ticket not found'],'',404);
        }
        
        $ticketAlreadyActive=$this->ticketService->TicketActiveTicket($id);
        if($ticketAlreadyActive){
            return $this->ApiResponse(['error' => 'ticket is already in active status',$ticketAlreadyActive],'',404);
        }
        return $this->ApiResponse($ticket,'the ticket activated successfully',200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),$this->TicketValidate());
        if($validator->fails())
        {
            return $this->ApiResponse($validator->errors(),null,400);
        }
        $ticket=$this->ticketService->ticketStore($validator->validated());
        
        if($ticket)
        {
            return $this->ApiResponse($ticket,'ticket created successfully',200);
        }
        return $this->ApiResponse($ticket,'ticket not saved',400);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ticket=Ticket::with(['users','appointments'])->find($id);
        if(!$ticket)
        {
            return $this->ApiResponse(['error' => 'ticket not found'],'',404);
        }
        return $this->ApiResponse($ticket,'' ,200);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator=Validator::make($request->all(),$this->TicketValidate());
        if($validator->fails())
        {
            return $this->ApiResponse($validator->errors(),'',400);
        }
        $ticket=$this->ticketService->ticketUpdate($id,$validator->validated());
        if(!$ticket)
        {
            return $this->ApiResponse(null,'this ticket not found',404);
        }
        return $this->ApiResponse($ticket,'ticket updated successfully',200);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ticket=$this->ticketService->ticketDelete($id);
        if(!$ticket)
        {
            return $this->apiResponse(null,'the ticket not found',404);
        }
        if($ticket)
        {
            return $this->apiResponse(null,'the ticket deleted',200);
        }
    }
}