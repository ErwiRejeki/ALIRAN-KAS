<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\supplier;
use App\Models\Pembelian;
use App\Models\Barang;
use App\Models\DetailPembelian;
use App\Models\Kas;
use App\Helpers\Helper;

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
    public function index()
    {
        $detailPembelian = DetailPembelian::all();
        $dataTables = [];
        foreach($detailPembelian as $item){
            $deleteLink = route('transaksi_pembelian.destroy', $item->id_det_beli);
            $dataTables[] = [
                $item->id_det_beli,
                $item->get_barang->nama_barang,
                $item->get_supplier->nama_supplier,
                $item->jml_beli,
                $item->harga_beli,
                Helper::tanggal_indo($item->tgl_beli),
                Helper::rp($item->total_beli),
                Helper::btnEdit('/transaksi_pembelian/' . $item->id_det_beli . '/edit') . Helper::btnDelete("deleteData('$item->id_det_beli', '$deleteLink')") 
            ];
        }

        $data =  new \stdClass();
        $data->heads = [ 
            'ID', 
            'Nama Barang',
            'Nama Supplier',
            'Jumlah Beli',
            'Harga Beli',
            'Tanggal Beli',
            'Total Beli',
            ['label' => 'Actions', 'no-export' => true, 'width' => 15],
        ];

        $data->config = [
            'data' => $dataTables,
            'columnDefs' => [['targets' => "_all"]],
            'order' => [[1, 'asc']],
        ];

        return view('pages.transaksi_pembelian.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data =  new \stdClass();
        $data->pembelian = Pembelian::all();
        return view('pages.transaksi_pembelian.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validasi
        
        $this->validate($request, [
            'id_det_beli' => 'required ',
            'jml_beli' => 'required ',
            'harga_beli' => 'required ',
            'id_barang' => 'required ',
            'id_beli' => 'required ',
        ]);
        $id_det_beli = Helper::getCode('detail_penjualan', 'id_det_beli', 'TPB-');
        $store = new DetailPenjualan($request->all());
        $store->id_det_beli = $id_det_beli;
        $store->save();

        $kas_id = ['kas_id' => Helper::getCode('kas', 'id_kas', 'KAS-')];
        $kas_save = [
            'kas_id' => Helper::getCode('kas', 'id_kas', 'KAS-'),
            'kas_tgl' => $request->tgl_beli,
            'kas_type' =>'PEMBELIAN',
            'kas_ket' =>'pembelian',
            'kas_id_value' =>$id_det_beli,
            'kas_kredit' =>$request->jml_beli,
        ];
        $kas = Kas::updateOrCreate($kas_id, $kas_save);
        return redirect()->route('transaksi_pembelian.index')
            ->with('success','Menambah Transaksi Pembelian telah berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data =  new \stdClass();
        $data->pembelian = Pembelian::all();
        $data->detailpembelian = DetailPembelian::find($id);
        if(!$data->detailPembelian){
            return redirect()->route('transaksi_pembelian.index')
                ->with('error','Transaksi Pembelian tidak ditemukan');
        }
        return view('pages.transaksi_pembelian.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'id_det_beli' => 'required ',
            'jml_beli' => 'required ',
            'harga_beli' => 'required ',
            'id_barang' => 'required ',
            'id_beli' => 'required ',
        ]);
        $update = DetailPembelian::findOrFail($id)->update($request->all());
        if($update){
            $kas_id = ['kas_id_value' => $id];
            $kas_save = [
                'kas_tgl' => $request->tgl_beli,
                'kas_type' =>'PEMBELIAN',
                'kas_ket' =>'pembelian',
                'kas_kredit' =>$request->jml_beli,
            ];
            $kas = Kas::updateOrCreate($kas_id, $kas_save);
        }
        
        return redirect()->route('transaksi_pembelian.index')
        ->with('success','Perubahan Transaksi Pembelian telah berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = DetailPembelian::find($id);
        $delete_kas = Kas::where('kas_id_value', $id);
        try {
            $set = $delete->delete();
            if($set){
                $delete_kas->delete();
            }
        } catch (\Illuminate\Database\QueryException $e) {
            //menampilkan kesalahan
            return $e->getMessage();
        }
    }
}
