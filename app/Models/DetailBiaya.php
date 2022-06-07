<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailBiaya extends Model
{
    use HasFactory;
    protected $table = 'detail_biaya';
    protected $primaryKey = 'id_det_biaya';
    public $incrementing = false;
    protected $fillable = [
        'id_det_biaya', 'tgl_biaya', 'jml_biaya', 'id_biaya'
    ];

    public function get_biaya()
    {
        return $this->belongsTo(Biaya::class, 'id_biaya', 'id_biaya');
    }
}
