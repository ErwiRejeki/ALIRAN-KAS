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
        Session(['saldo' => Helper::saldo()]);
    }

    public function jpenerimaankas()
    {
        $data =  new \stdClass();
        $data->total = 0;
        $data->list = DB::table('kas')->wherein('kas_ket', ['penjualan', 'retur pembelian'])->orderby('kas_tgl', 'asc')->get();
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
        $data->list = DB::table('kas')->wherein('kas_ket', ['biaya', 'pembelian', 'retur penjualan'])->orderby('kas_tgl', 'asc')->get();
        if ($data->list) {
            foreach ($data->list as $item) {
                $data->total = $data->total + $item->kas_kredit;
            }
        }
        return view('pages.jurnal.JPengeluaranKas',  compact('data'));
    }
}
