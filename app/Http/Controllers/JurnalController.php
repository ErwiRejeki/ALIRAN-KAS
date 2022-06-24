<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Helper;
use DB;
use Carbon\Carbon;
use App\Models\Kas;

class JurnalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function jpembelian()
    {
        $data =  new \stdClass();
        $data->total = 0;
        $data->list = DB::table('kas')->where('kas_ket', 'pembelian')->join('pembelian', 'id_beli', '=', 'kas_id_value')->orderby('kas_tgl', 'asc')->get();
        if ($data->list) {
            foreach ($data->list as $item) {
                $data->total = $data->total + $item->kas_kredit;
            }
        }
        return view('pages.jurnal.JPembelian',  compact('data'));
    }
    public function jpenjualan()
    {
        $data =  new \stdClass();
        $data->total = 0;
        $data->list = DB::table('kas')->where('kas_ket', 'penjualan')->join('penjualan', 'penjualan.id_jual', '=', 'kas_id_value')->orderby('kas_tgl', 'asc')->get();
        if ($data->list) {
            foreach ($data->list as $item) {
                $data->total = $data->total + $item->kas_debet;
            }
        }
        return view('pages.jurnal.JPenjualan',  compact('data'));
    }
    public function jpenerimaankas()
    {
        $data =  new \stdClass();
        $data->total = 0;
        $data->list = DB::table('kas')->wherein('kas_ket', ['penjualan', 'retur_penjualan'])->orderby('kas_tgl', 'asc')->get();
        if ($data->list) {
            foreach ($data->list as $item) {
                $data->total = $data->total + $item->kas_debet;
            }
        }
        return view('pages.jurnal.jpenerimaankas',  compact('data'));
    }
    public function jpengeluarankas()
    {
        $data =  new \stdClass();
        $data->total = 0;
        $data->list = DB::table('kas')->wherein('kas_ket', ['pembelian', 'biaya'])->orderby('kas_tgl', 'asc')->get();
        $data->beli = DB::table('kas')->where('kas_ket', 'pembelian')->join('pembelian', 'id_beli', '=', 'kas_id_value')->get();
        $data->fix = array();
        if ($data->list) {
            foreach ($data->list as $item) {
                $object = $item;
                if ($item->kas_ket == 'pembeli') {
                    foreach ($data->beli as $value) {
                        if ($value->id_beli == $item->kas_id_value) {
                            $object->nobuk = $value->beli_faktur;
                            $object->keterangan = 'Pembelian';
                        }
                    }
                } else {
                    $object->nobuk = $item->kas_id_value;
                    $object->keterangan = 'Biaya';
                }
                array_push($data->fix, $object);
                $data->total = $data->total + $item->kas_kredit;
            }
        }
        return view('pages.jurnal.JPengeluaranKas',  compact('data'));
    }
}
