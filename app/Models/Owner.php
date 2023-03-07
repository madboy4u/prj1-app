<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;
    
    protected $table = 'owners';
    protected $primaryKey = 'codicefiscale';
    public $timestamps = true;

    public function car(): BelongsToMany
    {
        return $this->belongsToMany(Car::class);
    }
}