<?php


namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class Helper
{
    public static function rp($p)
    {
        return 'Rp. ' . number_format($p,2,'.',',');
    }
    public static function saldo(){
        $modal = 0;
        $transaksi = 0;
        $get_modal = DB::table('kas')->where('kas_type', 'modal')->get();
        foreach($get_modal as $get){
            $modal = $modal + $get->kas_debet;
        }
        $get_transaksi = DB::table('kas')->where('kas_type', 'transaksi')->get();
        foreach($get_transaksi as $get){
            $transaksi = $transaksi + $get->kas_debet - $get->kas_kredit;
        }
        return $modal + $transaksi;
    }
    public static function tanggal_indo($p){
        \Carbon\Carbon::setLocale('id');
        return \Carbon\Carbon::parse($p)->translatedFormat('d F Y');;
    }
    public static function getCode($table, $field, $code){
        $data = DB::table($table)->orderBy('created_at', 'DESC')->first();
        if(is_null($data)){
            return $code.'1';
        }
        $code_now = substr($data->$field,strlen($code));
        $code_after = intval($code_now)+1;
        $code_generate = $code.$code_after;
        return $code_generate;
    }
    public static function btnEdit($route)
    {
        return '<a href="' . $route . '" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                <i class="fa fa-lg fa-fw fa-pen"></i>
                </a>';
    }
    public static function btnDetails($route)
    {
        return '<a href="' . $route . '" class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                <i class="fa fa-lg fa-fw fa-eye"></i>
                </a>';
    }
    public static function btnDelete($onclick)
    {
        return '<button onclick="' . $onclick . '" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
        <i class="fa fa-lg fa-fw fa-trash"></i>
    </button>';
    }
}
