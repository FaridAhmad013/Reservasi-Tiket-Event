<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiModel extends Model
{
    protected $fillable = [
        'detail_event_id',
        'bukti_transaksi',
        'status_transaksi',
        'approved_at',
        'approved_by',
        'rejected_at',
        'rejected_by',
        'harga',
        'user_id',
    ];

    public function detailEvent()
    {
        return $this->belongsTo(DetailEventModel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function rejector()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }
}
