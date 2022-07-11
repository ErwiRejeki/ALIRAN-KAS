<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Helper;
use DB;
use Carbon\Carbon;
use App\Models\Kas;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        Session(['saldo' => Helper::saldo()]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data =  new \stdClass();
        $data->penjualan = DB::table('kas')->where('kas_type','TRANSAKSI')->where('kas_ket','penjualan')->sum('kas_debet');
        $data->pembelian = DB::table('kas')->where('kas_type','TRANSAKSI')->where('kas_ket','pembelian')->sum('kas_kredit');
        $data->total = 0;
        $data->list = DB::table('kas')->wherein('kas_ket', ['penjualan', 'retur pembelian'])->orderby('kas_tgl', 'asc')->get();
        if ($data->list) {
            foreach ($data->list as $item) {
                $data->total = $data->total + $item->kas_debet;
            }
        }
        $data->total1 = 0;
        $data->list = DB::table('kas')->wherein('kas_ket', ['biaya', 'pembelian', 'retur penjualan'])->orderby('kas_tgl', 'asc')->get();
        if ($data->list) {
            foreach ($data->list as $item) {
                $data->total1 = $data->total1 + $item->kas_kredit;
            }
        }
        return view('home',  compact('data'));
    }
}
