<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Doctor extends Authenticatable 
{
    use HasFactory;
    protected $fillable=['first_name','last_name','national_id','email','password',
    'categories','department_id','image_name','reservation_phone_number'];
    public function reservation(){
        return $this->hasMany(Reservation::class,'reserved_doctor_id');
    }
    public function department(){
        return $this->belongsTo(Department::class);
    }
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
