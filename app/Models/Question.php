<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable=['title','body','patient_id','doctor_id','attatchments','status','category'];
    public function reply(){
        return $this->hasOne(Reply::class);
    }
    public function patient(){
        return $this->belongsTo(Patient::class);
    }
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
