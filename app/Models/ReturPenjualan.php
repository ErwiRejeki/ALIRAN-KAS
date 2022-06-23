<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturPenjualan extends Model
{
    use HasFactory;
    protected $table = 'retur_penjualan';
    protected $primaryKey = 'id_retur_jual';
    public $incrementing = false;
    protected $fillable = [
        'id_retur_jual', 'jml_retur_jual', 'harga_retur_jual', 'id_barang','id_jual'
    ];

    public function get_barang()
    {
        return $this->belongsTo(barang::class, 'id_barang', 'id_barang');
    }

    public function get_jual()
    {
        return $this->belongsTo(Penjualan::class, 'id_jual', 'id_jual');
    }
}
