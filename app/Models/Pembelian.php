<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;
    protected $table = 'pembelian';
    protected $primaryKey = 'id_beli';
    public $incrementing = false;
    protected $fillable = [
        'id_beli', 'faktur_beli', 'tgl_beli','total_beli', 'total_retur_beli','id_supplier'
    ];
    public function get_supplier()
    {
        return $this->belongsTo(supplier::class, 'id_supplier', 'id_supplier');
    }
}
