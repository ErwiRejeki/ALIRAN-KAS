<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\supplier;
use App\Models\Pembelian;
use App\Models\Barang;
use App\Models\DetailPembelian;
use App\Models\ReturPembelian;
use App\Models\Kas;
use App\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
        $data->list = Pembelian::with('get_supplier')->get();
        return view('pages.transaksi_pembelian.BeliData',  compact('data'));
    }
    
    public function transaksi($id = null)
    {
        Session(['saldo' => Helper::saldo()]);
        $data =  new \stdClass();
        $data->edit = null;
        $data->list = [];
        $data->list = DetailPembelian::with('get_barang')->whereNull('id_beli')->get();
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
            $data->edit = DetailPembelian::where('id_det_beli', $id)->first();
        }
        return view('pages.transaksi_pembelian.BeliTransaksi',  compact('data'));
    }

    public function barang_store(Request $request)
    {
        
        if (is_null($request['id_det_beli'])) {
            $cek =  DetailPembelian::whereNull('id_beli')->where('id_barang', $request->id_barang)->first();
            $request->request->add(['id_det_beli' => Helper::getCode('detail_pembelian', 'id_det_beli', 'BD-')]);
            if($cek){
                $request->request->add(['id_det_beli' => $cek->id_det_beli]);
                $request['jml_beli'] = $cek->jml_beli + $request['jml_beli'];
            }
            
        }
        $save_barang = DetailPembelian::updateOrCreate(['id_det_beli' => $request['id_det_beli']],  $request->except('_token'));

        return redirect('transaksi_pembelian/transaksi');
    }

    public function store(Request $request)
    {
        
        try{
            DB::beginTransaction();
            if (is_null($request['id_beli'])) {
                $request->request->add(['id_beli' => Helper::getCode('pembelian', 'id_beli', 'BL-')]);
            }
            $request->request->add(['tgl_beli' => Carbon::now()]);
            $save_beli =  new Pembelian($request->except('_token'));
            $save_beli->save();
            $barang_beli = DetailPembelian::whereNull('id_beli')->get();
            foreach($barang_beli as $barang){
                $get_barang = Barang::where('id_barang', $barang->id_barang)->first();
                $update_stok = Barang::where('id_barang', $barang->id_barang)->update(['stok_barang' => $get_barang->stok_barang+$barang->jml_beli]);
            }
            $save_barang_beli = DetailPembelian::whereNull('id_beli')->update(['id_beli' => $request['id_beli']]);
    
            $kas_id = ['kas_id' => Helper::getCode('kas', 'kas_id', 'KAS-')];
            $kas_save = [
                'kas_id' => Helper::getCode('kas', 'kas_id', 'KAS-'),
                'kas_type' =>'TRANSAKSI',
                'kas_ket' =>'pembelian',
                'kas_id_value' =>$request['id_beli'],
                'kas_kredit' =>$request['total_beli'],
            ];
            $kas = Kas::updateOrCreate($kas_id, $kas_save);
    
            DB::commit();
            return redirect('transaksi_pembelian');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('transaksi_pembelian/transaksi')->with('error', 'Gagal Menyimpan Data');
        }
        
    }
    public function barang_delete(Request $request)
    {
        try {
            $delete = DetailPembelian::where('id_det_beli', $request->id)->delete();
            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Data gagal dihapus'], 500);
        }
        
    }

    public function faktur($id, $type, $retur = null)
    {
        $data =  new \stdClass();
        $data->id = $id;
        $data->faktur = Pembelian::where('id_beli', $id)->first()->faktur_beli;
        $data->type = $type;
        $data->edit = null;
        $data->retur = null;
        $data->pembelian = null;
        $data->list = DetailPembelian::with('get_barang')->where('id_beli', $id)->get();
        $data->retur_list = ReturPembelian::with('get_barang')->where('id_beli', $id)->get();
        $data->max = 0;
        $data->total = 0;
        $data->total_retur = 0;
        $data->date = Carbon::now()->translatedFormat('d F Y');
        if ($data->list) {
            foreach ($data->list as $item) {
                $data->total = $data->total + ($item->harga_beli * $item->jml_beli);
            }
        }
        if ($data->retur_list) {
            foreach ($data->retur_list as $item) {
                $data->total_retur = $data->total_retur + ($item->harga_retur_beli * $item->jml_retur_beli);
            }
        }
        if ($retur != null) {
            $data->retur = ReturPembelian::with('get_barang')->where('id_retur_beli', $retur)->first();
            $data->pembelian = DetailPembelian::with('get_barang')->where('id_det_beli', $retur)->first();
            $data->max = $data->pembelian->jml_beli;
            $data->edit = 'change';
        }
        return view('pages.transaksi_pembelian.BeliTransaksiDetail',  compact('data'));
    }

    public function faktur_store(Request $request)
    {

        try{
            DB::beginTransaction();
            $save_retur = ReturPembelian::updateOrCreate(
                ['id_retur_beli' => $request['id_retur_beli']],
                $request->except('_token', 'total_pembelian', 'total_retur', 'retur_jml_old')
            );
            $get_barang = Barang::where('id_barang', $request->id_barang)->first();
            $update_stok = Barang::where('id_barang', $request->id_barang)->update(['stok_barang' => $get_barang->stok_barang+$request->retur_jml_old-$request->jml_retur_beli]); 
            $set = Pembelian::where('id_beli', $request['id_beli'])->first();
            $retur_nominal = ($set->total_retur_beli == 0) ? ($request['harga_retur_beli'] * $request['jml_retur_beli']) : $set->total_retur_beli - $request['total_retur'] + ($request['harga_retur_beli'] * $request['jml_retur_beli']);
            $save_nominal_retur = Pembelian::where('id_beli', $request['id_beli'])->update(['total_retur_beli' => $retur_nominal]);

            $kas = Kas::where('kas_ket', 'retur pembelian')->where('kas_id_value', $request['id_beli'])->first();
            $insert['kas_id'] = ($kas) ? $kas->kas_id : Helper::getCode('kas', 'kas_id', 'KAS-');
            $insert['kas_type'] = ($kas) ? $kas->kas_type : 'TRANSAKSI';
            $insert['kas_ket'] = ($kas) ? $kas->kas_ket : 'retur pembelian';
            $insert['kas_id_value'] = $request['id_beli'];
            $insert['kas_debet'] = $retur_nominal;
            $kas = Kas::updateOrCreate(['kas_id' => $insert['kas_id']], $insert);
            DB::commit();
            return redirect("transaksi_pembelian/faktur/" . $request['id_beli'] . "/retur")->with('success', 'Retur Pembelian berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect("transaksi_pembelian/faktur/" . $request['id_beli'] . "/retur/".$request['id_retur_beli'])->with('error', 'Gagal Menyimpan Data');
        }
    }
}
