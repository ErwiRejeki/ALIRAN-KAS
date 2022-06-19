<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Barang;
use App\Models\DetailPenjualan;
use App\Models\Kas;
use App\Helpers\Helper;
use Carbon\Carbon;

class TransaksiPenjualanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        Session(['saldo' => Helper::saldo()]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = null)
    {
        Session(['saldo' => Helper::saldo()]);
        $data =  new \stdClass();
        $data->list = Penjualan::all();
        return view('pages.transaksi_penjualan.JualData',  compact('data'));
    }
    
    public function transaksi($id = null)
    {
        Session(['saldo' => Helper::saldo()]);
        $data =  new \stdClass();
        $data->edit = null;
        $data->list = [];
        //$data->list = DB::table('detail_penjualan')->join('barang', 'barang.id_barang', '=', 'detail_penjualan.id_barang')->whereNull('id_jual')->get();
        $data->barang = Barang::all();
        $data->total = 0;
        $data->date = Carbon::now()->translatedFormat('d F Y');
        if ($data->list) {
            foreach ($data->list as $item) {
                $data->total = $data->total + ($item->harga_jual * $item->jml_jual);
            }
        }
        if ($id != null) {
            //$data->edit = DB::table('detail_penjualan')->join('barang', 'barang.id_barang', '=', 'detail_penjualan.id_barang')->where('id_det_jual', $id)->first();
        }
        return view('pages.transaksi_penjualan.JualTransaksi',  compact('data'));
    }

    public function barang_store(Request $request)
    {
        
        if (is_null($request['id_det_jual'])) {
            $cek =  DB::table('detail_penjualan')->whereNull('id_jual')->where('id_barang', $request->id_barang)->first();
            $request->request->add(['id_det_jual' => Helper::getCode('detail_penjualan', 'id_det_jual', 'JD-')]);
            if($cek){
                $request->request->add(['id_det_jual' => $cek->id_det_jual]);
                $request['jml_jual'] = $cek->jml_jual + $request['jml_jual'];
            }
        }
        $save_barang = DB::table('detail_jual')->updateOrInsert(
            ['id_det_jual' => $request['id_det_jual']],
            $request->except('_token')
        );

        return redirect('penjualan/transaksi');
    }

    public function store(Request $request)
    {
        if (is_null($request['id_jual'])) {
            $request->request->add(['id_jual' => Helper::getCode('penjualan', 'id_jual', 'JL-')]);
        }
        $request->request->add(['tgl_jual' => Carbon::now()]);
        $save_jual = DB::table('penjualan')->updateOrInsert(
            ['id_jual' => $request['id_jual']],
            $request->except('_token')
        );
        $barang_jual = DB::table('detail_jual')->whereNull('id_jual')->get();
        foreach($barang_jual as $barang){
            $get_barang = DB::table('barang')->where('id_barang', $barang->id_barang)->first();
            $update_stok = DB::table('barang')->where('id_barang', $barang->id_barang)->update(['barang_stok' => $get_barang->stok_barang-$barang->jml_jual]);
        }
        $save_barang_beli = DB::table('detail_jual')->whereNull('id_jual')->update(['id_jual' => $request['id_jual']]);
        $insert['kas_id'] =  Helper::getCode('kas', 'kas_id', 'KS-');
        $insert['kas_ket'] = 'penjualan';
        $insert['kas_id_value'] = $request['id_jual'];
        $insert['kas_debet'] = $request['total_jual'];
        $save_kas = DB::table('kas')->insert($insert);
        return redirect('penjualan/list');
    }
    public function barang_delete($id = null)
    {
        $delete_barang = DB::table('detail_jual')->where('id_det_jual', $id)->delete();
        return redirect('penjualan/transaksi');
    }
}
