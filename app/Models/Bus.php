<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;
    protected $table='buses';
    protected $fillable=[
        'name',
        'description'
    ];

    public function appointments(){
        return $this->hasMany(Appointment::class);
    }
}