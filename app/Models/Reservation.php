<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable=['reserved_doctor_id', 'reserved_patient_id','symptoms','reservation_time',
    'reservation_symptoms','urgent'];
    public function patient(){
        return $this->belongsTo(Patient::class);
    }
    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }
}
