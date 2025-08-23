<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailEventModel extends Model
{
    protected $fillable = [
        'event_id',
        'area',
        'deskripsi',
        'jumlah_tiket',
        'status',
        'harga',
    ];

    public function event()
    {
        return $this->belongsTo(EventModel::class);
    }

    public function transaksis()
    {
        return $this->hasMany(TransaksiModel::class);
    }
}
