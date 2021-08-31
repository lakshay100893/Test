<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Agencie extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'phn_no', 'description', 'address', 'password'];

    protected $hidden = ['created_at', 'updated_at'];

    public function Files(): BelongsToMany
    {
        return $this->belongsToMany(File::class, 'agencyFiles', 'agencie_id', 'file_id');
    }
}
