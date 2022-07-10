<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Helper;
use Illuminate\Support\Facades\DB;

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
        $penjualangraph = DB::table(DB::table(DB::raw("(select extract(YEAR_MONTH from tgl_jual) as alias, concat(MONTHNAME(tgl_jual), ' ', year(tgl_jual)) as name, sum(total_jual) as jual from penjualan group by extract(YEAR_MONTH from tgl_jual), concat(MONTHNAME(tgl_jual), ' ', year(tgl_jual))) x")))->limit(6)->get();
        return view('home', [
            'countPenjualan' =>  DB::table('penjualan')->count(),
            'countPembelian' =>  DB::table('pembelian')->count(),
            'penjualangraph' => $penjualangraph,
        ]);
    }
}
