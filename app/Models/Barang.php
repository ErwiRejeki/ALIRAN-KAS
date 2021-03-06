<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    public $incrementing = false;
    protected $fillable = [
        'id_barang', 'nama_barang', 'harga_beli_barang','margin_barang','stok_barang','satuan_barang','potongan'
    ];
}
