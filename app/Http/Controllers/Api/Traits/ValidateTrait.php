<?php
namespace App\Http\Controllers\Api\Traits;

use Illuminate\Validation\Rule;



trait ValidateTrait
{
    public function LoginValidate()
    {
        return ['email' => 'required|email',
        'password' => 'required|integer|min:6',
        ];
    }
    public function UserValidate()
    {
        return  ['name'=>'required|string|between:2,120',
                'email'=>'required|email|string|max:255|unique:users',
                'password'=>'required|integer|min:6',
                'phone'=>'required|digits:10|integer',
    ];
    }

    public function UserUpdateValidate($id)
    {
        return ['name'=>'required|string|between:2,120',
                'email'=>'required|string|email|max:255|unique:users,email,'.$id,
                'password'=>'nullable|integer|min:6',
                'phone'=>'required|digits:10|integer',
                'status' =>['required',Rule::in(['admin','user'])]
    ];
    }
    
    public function AppointmentValidate()
    {
        return [
            'from'=>'string|required',
            'to'=>'string|required',
            'ticket_price'=>'integer|required',
            'date'=>'required|date|after:now()',
            'available_seats'=>'string|required',
            'bus_id'=>'required|integer|exists:buses,id'
        ];
    }

    public function BusValidate()
    {
        return[
            'name'=>'string|required',
            'description'=>'string|required'
        ]; 
    }

    public function TicketValidate()
    {
        return[
          'seat_number'=>'string|required',
          'status'=> ['string',Rule::in(['active','inactive'])],
          'user_id'=>'exists:users,id|required|string',
          'appointment_id'=>'exists:appointments,id|required|string'
        ];
    }
    

    public function BookingValidate()
    {
        return[
          'seat_number'=>'string|required',
          'appointment_id'=>'exists:appointments,id|required|string'
        ];
    }

    public function ProfileUpdate($id)
    {
        return[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'phone' => 'required|string|max:255,',
            'password' => 'nullable|string|min:8',
        ];
    }

    
}