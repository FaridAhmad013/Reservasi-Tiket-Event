<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'nama_event',
        'deskripsi',
        'waktu_event',
        'foto',
        'kordinat',
        'lokasi',
    ];

    public function detailEvents()
    {
        return $this->hasMany(DetailEvent::class);
    }
}
