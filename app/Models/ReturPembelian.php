<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturPembelian extends Model
{
    use HasFactory;
    protected $table = 'retur_pembelian';
    protected $primaryKey = 'id_retur_beli';
    public $incrementing = false;
    protected $fillable = [
        'id_retur_beli', 'jml_retur_beli', 'harga_retur_beli', 'id_barang','id_beli'
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
