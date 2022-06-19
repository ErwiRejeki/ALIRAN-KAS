<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\supplier;
use App\Models\Pembelian;
use App\Models\Barang;
use App\Models\DetailPembelian;
use App\Models\Kas;
use App\Helpers\Helper;
use Carbon\Carbon;

class TransaksiPembelianController extends Controller
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
        $data->list = Pembelian::all();
        // $data->list = DB::table('pembelian')->join('supplier', 'supplier.id_supplier', '=', 'pembelian.id_supplier')->get();
        return view('pages.transaksi_pembelian.BeliData',  compact('data'));
    }
    
    public function transaksi($id = null)
    {
        Session(['saldo' => Helper::saldo()]);
        $data =  new \stdClass();
        $data->edit = null;
        $data->list = [];
        // $data->list = DB::table('detail_beli')->join('barang', 'barang.id_barang', '=', 'detail_beli.id_barang')->whereNull('id_beli')->get();
        $data->barang = Barang::all();
        $data->supplier = supplier::all();
        $data->total = 0;
        $data->date = Carbon::now()->translatedFormat('d F Y');
        if ($data->list) {
            foreach ($data->list as $item) {
                $data->total = $data->total + ($item->harga_beli * $item->jml_beli);
            }
        }
        if ($id != null) {
            // $data->edit = DB::table('detail_beli')->where('id_det_beli', $id)->first();
        }
        return view('pages.transaksi_pembelian.BeliTransaksi',  compact('data'));
    }

    public function barang_store(Request $request)
    {
        
        if (is_null($request['id_det_beli'])) {
            $cek =  DB::table('detail_beli')->whereNull('id_beli')->where('id_barang', $request->id_barang)->first();
            $request->request->add(['id_det_beli' => Helper::getCode('detail_beli', 'id_det_beli', 'BD-')]);
            if($cek){
                $request->request->add(['id_det_beli' => $cek->id_det_beli]);
                $request['jml_beli'] = $cek->jml_beli + $request['jml_beli'];
            }
            
        }
        $save_barang = DB::table('detail_beli')->updateOrInsert(
            ['id_det_beli' => $request['id_det_beli']],
            $request->except('_token')
        );

        return redirect('pembelian/transaksi');
    }

    public function store(Request $request)
    {
        if (is_null($request['id_beli'])) {
            $request->request->add(['id_beli' => Helper::getCode('pembelian', 'id_beli', 'BL-')]);
        }
        $request->request->add(['tgl_beli' => Carbon::now()]);
        $save_beli = DB::table('pembelian')->insert($request->except('_token'));
        $barang_beli = DB::table('detail_beli')->whereNull('id_beli')->get();
        foreach($barang_beli as $barang){
            $get_barang = DB::table('barang')->where('id_barang', $barang->id_barang)->first();
            $update_stok = DB::table('barang')->where('id_barang', $barang->id_barang)->update(['stok_barang' => $get_barang->stok_barang+$barang->jml_beli]);
        }
        $save_barang_beli = DB::table('detail_beli')->whereNull('id_beli')->update(['id_beli' => $request['id_beli']]);
        $insert['kas_id'] =  Helper::getCode('kas', 'kas_id', 'KS-');
        $insert['kas_ket'] = 'pembelian';
        $insert['kas_id_value'] = $request['id_beli'];
        $insert['kas_kredit'] = $request['total_beli'];
        $save_kas = DB::table('kas')->insert($insert);
        return redirect('pembelian/list');
    }
    public function barang_delete($id = null)
    {
        $delete_barang = DB::table('detail_beli')->where('id_det_beli', $id)->delete();
        return redirect('pembelian/transaksi');
    }
}
