<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Penjualan;
use App\Models\Barang;
use App\Models\DetailPenjualan;
use App\Models\ReturPenjualan;
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
        $data->list = DetailPenjualan::with('get_barang')->whereNull('id_jual')->get();
        $data->barang = Barang::all();
        $data->total = 0;
        $data->date = Carbon::now()->translatedFormat('d F Y');
        if ($data->list) {
            foreach ($data->list as $item) {
                $data->total = $data->total + ($item->harga_jual * $item->jml_jual);
            }
        }
        if ($id != null) {
            $data->edit = DetailPenjualan::with('get_barang')->where('id_det_jual', $id)->first();
        }
        return view('pages.transaksi_penjualan.JualTransaksi',  compact('data'));
    }

    public function barang_store(Request $request)
    {
        
        if (is_null($request['id_det_jual'])) {
            $cek =  DetailPenjualan::whereNull('id_jual')->where('id_barang', $request->id_barang)->first();
            $request->request->add(['id_det_jual' => Helper::getCode('detail_penjualan', 'id_det_jual', 'BD-')]);
            if($cek){
                $request->request->add(['id_det_jual' => $cek->id_det_jual]);
            }
            
        }
        $save_barang = DetailPenjualan::updateOrCreate(['id_det_jual' => $request['id_det_jual']],  $request->except('_token'));

        return redirect('transaksi_penjualan/transaksi');
    }

    public function store(Request $request)
    {
        try{
            DB::beginTransaction();
            if (is_null($request['id_jual'])) {
                $request->request->add(['id_jual' => Helper::getCode('penjualan', 'id_jual', 'JL-')]);
            }
            $request->request->add(['tgl_jual' => Carbon::now()]);
            $save_jual =  new Penjualan($request->except('_token'));
            $save_jual->save();
            $barang_jual = DetailPenjualan::whereNull('id_jual')->get();
            foreach($barang_jual as $barang){
                $get_barang = Barang::where('id_barang', $barang->id_barang)->first();
                $update_stok = Barang::where('id_barang', $barang->id_barang)->update(['stok_barang' => $get_barang->stok_barang-$barang->jml_jual]);
            }
            $save_barang_jual = DetailPenjualan::whereNull('id_jual')->update(['id_jual' => $request['id_jual']]);
    
            $kas_id = ['kas_id' => Helper::getCode('kas', 'kas_id', 'KAS-')];
            $kas_save = [
                'kas_id' => Helper::getCode('kas', 'kas_id', 'KAS-'),
                'kas_type' =>'TRANSAKSI',
                'kas_ket' =>'penjualan',
                'kas_id_value' =>$request['id_jual'],
                'kas_debet' =>$request['total_jual'],
            ];
            $kas = Kas::updateOrCreate($kas_id, $kas_save);
    
            DB::commit();
            return redirect('transaksi_penjualan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('transaksi_penjualan/transaksi')->with('error', 'Gagal Menyimpan Data');
        }
    }
    public function barang_delete(Request $request)
    {
        try {
            $delete = DetailPenjualan::where('id_det_jual', $request->id)->delete();
            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Data gagal dihapus'], 500);
        }
    }

    public function faktur($id, $type, $retur = null)
    {
        $data =  new \stdClass();
        $data->id = $id;
        $data->faktur = Penjualan::where('id_jual', $id)->first()->id_jual;
        $data->type = $type;
        $data->edit = null;
        $data->retur = null;
        $data->penjualan = null;
        $data->list = DetailPenjualan::with('get_barang')->where('id_jual', $id)->get();
        $data->retur_list = ReturPenjualan::with('get_barang')->where('id_jual', $id)->get();
        $data->max = 0;
        $data->total = 0;
        $data->total_retur = 0;
        $data->date = Carbon::now()->translatedFormat('d F Y');
        if ($data->list) {
            foreach ($data->list as $item) {
                $data->total = $data->total + ($item->harga_jual * $item->jml_jual);
            }
        }
        if ($data->retur_list) {
            foreach ($data->retur_list as $item) {
                $data->total_retur = $data->total_retur + ($item->harga_retur_jual * $item->jml_retur_jual);
            }
        }
        if ($retur != null) {
            $data->retur = ReturPenjualan::with('get_barang')->where('id_retur_jual', $retur)->first();
            $data->penjualan = DetailPenjualan::with('get_barang')->where('id_det_jual', $retur)->first();
            $data->max = $data->penjualan->jml_jual;
            $data->edit = 'change';
        }
        return view('pages.transaksi_penjualan.JualTransaksiDetail',  compact('data'));
    }

    public function faktur_store(Request $request)
    {

        try{
            DB::beginTransaction();
            $save_retur = ReturPenjualan::updateOrCreate(
                ['id_retur_jual' => $request['id_retur_jual']],
                $request->except('_token', 'total_penjualan', 'total_retur', 'retur_jml_old')
            );
            $set = Penjualan::where('id_jual', $request['id_jual'])->first();
            $retur_nominal = ($set->total_retur_jual == 0) ? ($request['harga_retur_jual'] * $request['jml_retur_jual']) : $set->total_retur_jual - $request['total_retur'] + ($request['harga_retur_jual'] * $request['jml_retur_jual']);
            $save_nominal_retur = Penjualan::where('id_jual', $request['id_jual'])->update(['total_retur_jual' => $retur_nominal]);

            $kas = Kas::where('kas_ket', 'retur penjualan')->where('kas_id_value', $request['id_jual'])->first();
            $insert['kas_id'] = ($kas) ? $kas->kas_id : Helper::getCode('kas', 'kas_id', 'KAS-');
            $insert['kas_type'] = ($kas) ? $kas->kas_type : 'TRANSAKSI';
            $insert['kas_ket'] = ($kas) ? $kas->kas_ket : 'retur penjualan';
            $insert['kas_id_value'] = $request['id_jual'];
            $insert['kas_kredit'] = $retur_nominal;
            $kas = Kas::updateOrCreate(['kas_id' => $insert['kas_id']], $insert);
            DB::commit();
            return redirect("transaksi_penjualan/faktur/" . $request['id_jual'] . "/retur")->with('success', 'Retur Penjualan berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect("transaksi_penjualan/faktur/" . $request['id_jual'] . "/retur/".$request['id_retur_jual'])->with('error', 'Gagal Menyimpan Data');
        }
    }
}
