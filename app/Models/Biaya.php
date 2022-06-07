<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biaya extends Model
{
    use HasFactory;
    protected $table = 'biaya';
    protected $primaryKey = 'id_biaya';
    public $incrementing = false;
    protected $fillable = [
        'id_biaya', 'nama_biaya'
    ];
}
