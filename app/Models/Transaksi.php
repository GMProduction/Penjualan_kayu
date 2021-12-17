<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'tanggal',
        'no_transaksi',
        'sub_total',
        'ongkir',
        'total',
        'ekspedisi',
        'alamat',
        'status_transaksi',
        'status_pembayaran',
        'url',
        'estimasi'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function keranjang()
    {
        return $this->hasMany(Keranjang::class);
    }
}
