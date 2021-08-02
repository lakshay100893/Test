<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;


class Agencie extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'name', 'email', 'phn_no', 'description', 'address', 'password', ];



    public function Files(): BelongsToMany
    {
        return $this->belongsToMany(UserFile::class, 'agencyFiles', 'agencie_id', 'file_id' );
    }

    
}
