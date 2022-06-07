<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class users extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = [
        'id_barang', 'nama_barang', 'harga_beli_barang','margin_barang','stok_barang','satuan_barang','potongan'
    ];
}
