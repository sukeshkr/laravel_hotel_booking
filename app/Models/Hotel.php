<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class Hotel extends Model
{
    use HasFactory ,Cachable;

    protected $fillable = [
        'name',
        'location',
        'description',
        'file_name'
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class,'hotel_id');
    }
}
