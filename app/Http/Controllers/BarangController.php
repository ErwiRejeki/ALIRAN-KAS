<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Helpers\Helper;

class BarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang = Barang::all();
        $dataTables = [];
        foreach($barang as $item){
            $deleteLink = route('barang.destroy', $item->id_barang);
            $dataTables[] = [
                $item->id_barang,
                $item->nama_barang,
                Helper::rp($item->harga_beli_barang),
                $item->margin_barang,
                $item->stok_barang,
                $item->satuan_barang,
                Helper::rp($item->potongan),
                Helper::btnEdit('/barang/' . $item->id_barang . '/edit') . Helper::btnDelete("deleteData('$item->id_barang', '$deleteLink')") 
            ];
        }

        $data =  new \stdClass();
        $data->heads = [ 
            'ID', 
            'Barang',
            ['label' => 'Harga Beli'],
            ['label' => 'Margin Barang'],
            ['label' => 'Stok Barang'],
            ['label' => 'Satuan Barang'],
            ['label' => 'Potongan Harga'],
            ['label' => 'Actions', 'no-export' => true, 'width' => 15],
        ];

        $data->config = [
            'data' => $dataTables,
            'order' => [[1, 'asc']],
            'columns' => [null, null, null, null, null, null, null, ['orderable' => false]],
        ];

        return view('pages.barang.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.barang.create');
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
            'nama_barang' => 'required ',
            'harga_beli_barang' => 'required ',
            'margin_barang' => 'required ',
            'stok_barang' => 'required ',
            'satuan_barang' => 'required ',
            'potongan' => 'required',
        ]);
        $store = new Barang($request->all());
        $store->id_barang = Helper::getCode('barang', 'id_barang', 'BR-');
        $store->save();
        return redirect()->route('barang.index')
            ->with('success','Menambah Barang telah berhasil disimpan');
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
        $data->barang = Barang::find($id);
        if(!$data->barang){
            return redirect()->route('barang.index')
                ->with('error','Barang tidak ditemukan');
        }
        return view('pages.barang.edit', compact('data'));
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
            'nama_barang' => 'required ',
            'harga_beli_barang' => 'required ',
            'margin_barang' => 'required ',
            'stok_barang' => 'required ',
            'satuan_barang' => 'required ',
            'potongan' => 'required',
        ]);
        $update = Barang::findOrFail($id)->update($request->all());
        return redirect()->route('barang.index')
        ->with('success','Perubahan Barang telah berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Barang::find($id);
        try {
            $delete->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            //menampilkan kesalahan
            return $e->getMessage();
        }
    }
}
