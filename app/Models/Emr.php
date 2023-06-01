<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emr extends Model
{
    use HasFactory;
        protected $fillable=[ 
            'patient_id','alergies','tobacco_intake','illegal_drugs','current_drugs','alchol_intake',
            'patient_dcm_diagnose','patient_dcm_normal','blood_type','history','patient_symptoms','doctor_report'
        ];
        public function patient(){
        return $this->belongsTo(Patient::class);
        }
}
