<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kas extends Model
{
    use HasFactory;

    protected $table = 'kas';
    protected $primaryKey = 'kas_id';
    public $incrementing = false;
    protected $fillable = [
        'kas_id', 'kas_tgl', 'kas_type', 'kas_ket', 'kas_id_value', 'kas_debet', 'kas_kredit'
    ];
}
