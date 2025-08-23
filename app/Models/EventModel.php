<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventModel extends Model
{
    protected $fillable = [
        'nama_event',
        'deskripsi',
        'waktu_event',
        'lokasi_event',
        'gambar',
    ];

    public function detailEvents()
    {
        return $this->hasMany(DetailEventModel::class);
    }
}
