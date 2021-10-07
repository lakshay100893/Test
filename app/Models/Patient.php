<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'phone', 'hospital_id', 'department_id'];

    public function dep()
    {
        return $this->hasOne(Department::class, 'id');
    }

    public function hospital()
    {
        return $this->hasOne(Hospital::class, 'id');
    }
}
