<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Helpers\Helper;

class SupplierController extends Controller
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
        $supplier = Supplier::all();
        $dataTables = [];
        foreach($supplier as $item){
            $deleteLink = route('supplier.destroy', $item->id_supplier);
            $dataTables[] = [
                $item->id_supplier,
                $item->nama_supplier,
                $item->alamat_supplier,
                $item->telp_supplier,
                Helper::btnEdit('/supplier/' . $item->id_supplier . '/edit') . Helper::btnDelete("deleteData('$item->id_supplier', '$deleteLink')") 
            ];
        }

        $data =  new \stdClass();
        $data->heads = [ 
            'ID_Supllier', 
            'Nama Supplier',
            ['label' => 'Alamat'],
            ['label' => 'Telp'],
            ['label' => 'Actions', 'no-export' => true, 'width' => 15],
        ];

        $data->config = [
            'data' => $dataTables,
            'order' => [[1, 'asc']],
            'columns' => [null, null, null, null, ['orderable' => false]],
        ];

        return view('pages.supplier.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.supplier.create');
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
            'nama_supplier' => 'required ',
            'alamat_supplier' => 'required ',
            'telp_supplier' => 'required ',
        ]);
        $store = new Supplier($request->all());
        $store->id_supplier = Helper::getCode('supplier', 'id_supplier', 'SP-');
        $store->save();
        return redirect()->route('supplier.index')
            ->with('success','Menambah Supplier telah berhasil disimpan');
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
        $data->supplier = Supplier::find($id);
        if(!$data->supplier){
            return redirect()->route('supplier.index')
                ->with('error','Supplier tidak ditemukan');
        }
        return view('pages.supplier.edit', compact('data'));
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
            'nama_supplier' => 'required ',
            'alamat_supplier' => 'required ',
            'telp_supplier' => 'required ',
        ]);
        $update = Supplier::findOrFail($id)->update($request->all());
        return redirect()->route('supplier.index')
        ->with('success','Perubahan Supplier telah berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Supplier::find($id);
        try {
            $delete->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            //menampilkan kesalahan
            return $e->getMessage();
        }
    }
}
