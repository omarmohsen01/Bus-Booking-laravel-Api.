<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $table='appointments';
    protected $fillable=[
        'from',
        'to',
        'date',
        'available_seats',
        'ticket_price',
        'bus_id'
    ];

    public function buses()
    {
        return $this->belongsTo(Bus::class,'bus_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class,'appointment_id');
    }
}