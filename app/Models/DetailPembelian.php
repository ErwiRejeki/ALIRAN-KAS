<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    use HasFactory;
    protected $table = 'detail_pembelian';
    protected $primaryKey = 'id_det_beli';
    public $incrementing = false;
    protected $fillable = [
        'id_det_beli', 'jml_beli', 'harga_beli', 'id_barang','id_beli'
    ];

    public function get_barang()
    {
        return $this->belongsTo(barang::class, 'id_barang', 'id_barang');
    }

    public function get_beli()
    {
        return $this->belongsTo(Pembelian::class, 'id_beli', 'id_beli');
    }
}
