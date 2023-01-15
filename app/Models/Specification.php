<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;


class Specification extends Model
{
    use HasFactory ,Cachable;

    protected $fillable = [
        'room_id',
        'specification',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
