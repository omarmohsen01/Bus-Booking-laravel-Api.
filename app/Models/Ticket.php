<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $table='tickets';
    protected $fillable=[
        'seat_number',
        'status',
        'user_id',
        'appointment_id'
    ];
    
    public function appointments()
    {
        return $this->belongsTo(Appointment::class,'appointment_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}