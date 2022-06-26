<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Biaya;
use App\Models\DetailBiaya;
use App\Models\Kas;
use App\Helpers\Helper;

class TransaksiBiayaController extends Controller
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
        $detailbiaya = DetailBiaya::all();
        $dataTables = [];
        foreach($detailbiaya as $item){
            $deleteLink = route('transaksi_biaya.destroy', $item->id_det_biaya);
            $dataTables[] = [
                $item->id_det_biaya,
                $item->get_biaya->nama_biaya,
                Helper::tanggal_indo($item->tgl_biaya),
                Helper::rp($item->jml_biaya),
                Helper::btnEdit('/transaksi_biaya/' . $item->id_det_biaya . '/edit') . Helper::btnDelete("deleteData('$item->id_det_biaya', '$deleteLink')") 
            ];
        }

        $data =  new \stdClass();
        $data->heads = [ 
            'ID', 
            'Biaya',
            'Tanggal',
            'Jumlah',
            ['label' => 'Actions', 'no-export' => true, 'width' => 15],
        ];

        $data->config = [
            'data' => $dataTables,
            'columnDefs' => [['targets' => "_all"]],
            'order' => [[1, 'asc']],
        ];

        return view('pages.transaksi_biaya.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data =  new \stdClass();
        $data->biaya = Biaya::all();
        return view('pages.transaksi_biaya.create', compact('data'));
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
            'tgl_biaya' => 'required ',
            'jml_biaya' => 'required ',
            'id_biaya' => 'required ',
        ]);
        $id_det_biaya = Helper::getCode('detail_biaya', 'id_det_biaya', 'TBY-');
        $store = new DetailBiaya($request->all());
        $store->id_det_biaya = $id_det_biaya;
        $store->save();

        $kas_id = ['kas_id' => Helper::getCode('kas', 'kas_id', 'KAS-')];
        $kas_save = [
            'kas_id' => Helper::getCode('kas', 'kas_id', 'KAS-'),
            'kas_tgl' => $request->tgl_biaya,
            'kas_type' =>'BIAYA',
            'kas_ket' =>'biaya',
            'kas_id_value' =>$id_det_biaya,
            'kas_kredit' =>$request->jml_biaya,
        ];
        $kas = Kas::updateOrCreate($kas_id, $kas_save);
        return redirect()->route('transaksi_biaya.index')
            ->with('success','Menambah Transaksi Biaya telah berhasil disimpan');
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
        $data->biaya = Biaya::all();
        $data->detailbiaya = DetailBiaya::find($id);
        if(!$data->detailbiaya){
            return redirect()->route('transaksi_biaya.index')
                ->with('error','Transaksi Biaya tidak ditemukan');
        }
        return view('pages.transaksi_biaya.edit', compact('data'));
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
            'tgl_biaya' => 'required ',
            'jml_biaya' => 'required ',
            'id_biaya' => 'required ',
        ]);
        $update = DetailBiaya::findOrFail($id)->update($request->all());
        if($update){
            $kas_id = ['kas_id_value' => $id];
            $kas_save = [
                'kas_tgl' => $request->tgl_biaya,
                'kas_type' =>'BIAYA',
                'kas_ket' =>'biaya',
                'kas_kredit' =>$request->jml_biaya,
            ];
            $kas = Kas::updateOrCreate($kas_id, $kas_save);
        }
        
        return redirect()->route('transaksi_biaya.index')
        ->with('success','Perubahan Transaksi Biaya telah berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = DetailBiaya::find($id);
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
