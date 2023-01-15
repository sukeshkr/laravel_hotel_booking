<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class Room extends Model
{
    use HasFactory ,Cachable;

    protected $fillable = [
        'room_no',
        'hotel_id',
        'price',
        'file',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class,'hotel_id');
    }
    public function specifications()
    {
        return $this->hasMany(Specification::class,'room_id');
    }
}
