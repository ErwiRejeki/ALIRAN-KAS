<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    protected $table = 'penjualan';
    protected $primaryKey = 'id_jual';
    public $incrementing = false;
    protected $fillable = [
        'id_jual', 'tgl_jual','total_jual'
    ];
}
