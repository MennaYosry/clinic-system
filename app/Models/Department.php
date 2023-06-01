<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $fillable=['department_name'];
    public function doctor(){
        return $this->hasMany(Doctor::class,'department_id');
    }
}
