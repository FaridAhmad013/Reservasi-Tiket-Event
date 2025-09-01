<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailEvent extends Model
{
    protected $fillable = [
        'event_id',
        'area',
        'deskripsi',
        'jumlah_tiket',
        'status',
        'harga',
        'dibuka_pada',
        'ditutup_pada'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}
