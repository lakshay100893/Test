<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function dep()
    {
        return $this->hasMany(Department::class,'id','department_id');
    }
}

