<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Patient extends Authenticatable 
{  
    use HasFactory, Notifiable;
    protected $fillable=['first_name','last_name','national_id','email','password',
    'phone_number','city','gender','birth_date','image_name'];
    public function emr(){
        return $this->hasOne(Emr::class);
    }
    public function question(){
        return $this->hasMany(Question::class,'patient_id');
    }
    public function reservation(){
        return $this->hasMany(Reservation::class, 'reserved_patient_id');
    }
    
}


