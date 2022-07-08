<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Helper;
use DB;
use Carbon\Carbon;
use App\Models\Kas;

class LaporanController extends Controller
{
    public function lpembelian(Request $request)
    {
        $data =  new \stdClass();
        $data->enddate = ($request->enddate) ? $request->enddate : Carbon::now()->endOfMonth()->format('Y-m-d');
        $data->startdate = ($request->startdate) ? $request->startdate : Carbon::now()->startOfMonth()->format('Y-m-d');
        $data->total = 0;
        $data->list = DB::table('kas')->where('kas_ket', 'pembelian')->whereBetween('kas_tgl', [$data->startdate, $data->enddate])->join('pembelian', 'id_beli', '=', 'kas_id_value')->join('supplier', 'supplier.id_supplier', '=', 'pembelian.id_supplier')->orderby('kas_tgl', 'asc')->get();
        //        dd($data->list);
        if ($data->list) {
            foreach ($data->list as $item) {
                $data->total = $data->total + $item->kas_kredit;
            }
        }
        return view('pages.laporan.LPembelian',  compact('data'));
    }
    public function lpenjualan(Request $request)
    {
        $data =  new \stdClass();
        $data->enddate = ($request->enddate) ? $request->enddate : Carbon::now()->endOfMonth()->format('Y-m-d');
        $data->startdate = ($request->startdate) ? $request->startdate : Carbon::now()->startOfMonth()->format('Y-m-d');
        $data->total = 0;
        $data->list = DB::table('kas')->where('kas_ket', 'penjualan')->whereBetween('kas_tgl', [$data->startdate, $data->enddate])->orderby('kas_tgl', 'asc')->get();
        //        dd($data->list);
        if ($data->list) {
            foreach ($data->list as $item) {
                $data->total = $data->total + $item->kas_debet;
            }
        }
        return view('pages.laporan.LPenjualan',  compact('data'));
    }
    public function lpenerimaankas(Request $request)
    {
        $data =  new \stdClass();
        $data->enddate = ($request->enddate) ? $request->enddate : Carbon::now()->endOfMonth()->format('Y-m-d');
        $data->startdate = ($request->startdate) ? $request->startdate : Carbon::now()->startOfMonth()->format('Y-m-d');
        $data->total = 0;
        $data->list = DB::table('kas')->wherein('kas_ket', ['penjualan', 'retur pembelian'])->whereBetween('kas_tgl', [$data->startdate, $data->enddate])->orderby('kas_tgl', 'asc')->get();
        $data->beli = DB::table('kas')->where('kas_ket', 'retur pembelian')->join('pembelian', 'id_beli', '=', 'kas_id_value')->get();
        $data->fix = array();
        if ($data->list) {
            foreach ($data->list as $item) {
                $object =  new \stdClass();
                $object = $item;
                if ($item->kas_ket == 'retur pembelian') {
                    foreach ($data->beli as $value) {
                        if ($value->id_beli == $item->kas_id_value) {
                            $object->nobuk = $value->faktur_beli;
                        }
                    }
                } else {
                    $object->nobuk = $item->kas_id_value;
                }
                array_push($data->fix, $object);
                $data->total = $data->total + $item->kas_debet;
            }
        }
        return view('pages.laporan.lpenerimaankas',  compact('data'));
    }
    public function lpengeluarankas(Request $request)
    {
        $data =  new \stdClass();
        $data->enddate = ($request->enddate) ? $request->enddate : Carbon::now()->endOfMonth()->format('Y-m-d');
        $data->startdate = ($request->startdate) ? $request->startdate : Carbon::now()->startOfMonth()->format('Y-m-d');
        $data->total = 0;
        $data->list = DB::table('kas')->wherein('kas_ket', ['pembelian', 'biaya', 'retur penjualan'])->whereBetween('kas_tgl', [$data->startdate, $data->enddate])->orderby('kas_tgl', 'asc')->get();
        $data->beli = DB::table('kas')->where('kas_ket', 'pembelian')->join('pembelian', 'id_beli', '=', 'kas_id_value')->get();
        $data->fix = array();
        if ($data->list) {
            foreach ($data->list as $item) {
                $object =  new \stdClass();
                $object = $item;
                if ($item->kas_ket == 'pembelian') {
                    foreach ($data->beli as $value) {
                        if ($value->id_beli == $item->kas_id_value) {
                            $object->nobuk = $value->faktur_beli;
                        }
                    }
                } else {
                    $object->nobuk = $item->kas_id_value;
                }
                array_push($data->fix, $object);
                $data->total = $data->total + $item->kas_kredit;
            }
        }
        return view('pages.laporan.lpengeluarankas',  compact('data'));
    }
    public function lbukubesarkas(Request $request)
    {
        $data =  new \stdClass();
        $data->enddate = ($request->enddate) ? $request->enddate : Carbon::now()->endOfMonth()->format('Y-m-d');
        $data->startdate = ($request->startdate) ? $request->startdate : Carbon::now()->startOfMonth()->format('Y-m-d');
        $data->total_debet = 0;
        $data->total_kredit = 0;
        $data->list = DB::table('kas')->whereBetween('kas_tgl', [$data->startdate, $data->enddate])->orderby('kas_tgl')->get();
        if ($data->list) {
            foreach ($data->list as $item) {
                $data->total_debet = $data->total_debet + $item->kas_debet;
                $data->total_kredit = $data->total_kredit + $item->kas_kredit;
            }
        }
        return view('pages.laporan.LBukuBesarKas',  compact('data'));
    }
    public function laruskas(Request $request)
    {
        $data =  new \stdClass();
        $data->enddate = ($request->enddate) ? $request->enddate : Carbon::now()->endOfMonth()->format('Y-m-d');
        $data->startdate = ($request->startdate) ? $request->startdate : Carbon::now()->startOfMonth()->format('Y-m-d');
        $data->penjualan = DB::table('kas')->whereBetween('kas_tgl', [$data->startdate, $data->enddate])->where('kas_type','TRANSAKSI')->where('kas_ket','penjualan')->sum('kas_debet');
        $data->pembelian = DB::table('kas')->whereBetween('kas_tgl', [$data->startdate, $data->enddate])->where('kas_type','TRANSAKSI')->where('kas_ket','pembelian')->sum('kas_kredit');
        $data->biaya = DB::table('kas')->whereBetween('kas_tgl', [$data->startdate, $data->enddate])->where('kas_type','BIAYA')->where('kas_ket','biaya')->sum('kas_kredit');
        
        return view('pages.laporan.LArusKas',  compact('data'));
    }
}
