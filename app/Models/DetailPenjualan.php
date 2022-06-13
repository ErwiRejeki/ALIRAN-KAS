<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    use HasFactory;
    protected $table = 'detail_penjualan';
    protected $primaryKey = 'id_det_jual';
    public $incrementing = false;
    protected $fillable = [
        'id_det_jual', 'jml_jual', 'harga_jual', 'id_jual','id_barang'
    ];

    public function get_jual()
    {
        return $this->belongsTo(Penjualan::class, 'id_jual', 'id_jual');
    }
    public function get_barang()
    {
        return $this->belongsTo(barang::class, 'id_barang', 'id_barang');
    }
}
