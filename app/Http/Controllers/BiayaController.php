<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Biaya;
use App\Helpers\Helper;

class BiayaController extends Controller
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
        $biaya = Biaya::all();
        $dataTables = [];
        foreach($biaya as $item){
            $deleteLink = route('biaya.destroy', $item->id_biaya);
            $dataTables[] = [
                $item->id_biaya,
                $item->nama_biaya,
                Helper::btnEdit('/biaya/' . $item->id_biaya . '/edit') . Helper::btnDelete("deleteData('$item->id_biaya', '$deleteLink')") 
            ];
        }

        $data =  new \stdClass();
        $data->heads = [ 
            'ID_Biaya', 
            'Nama Biaya',
            ['label' => 'Actions', 'no-export' => true, 'width' => 15],
        ];

        $data->config = [
            'data' => $dataTables,
            'columnDefs' => [['targets' => "_all"]],
            'order' => [[1, 'asc']],
        ];

        return view('pages.biaya.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.biaya.create');
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
            'nama_biaya' => 'required ',
        ]);
        $store = new Biaya($request->all());
        $store->id_biaya = Helper::getCode('biaya', 'id_biaya', 'SP-');
        $store->save();
        return redirect()->route('biaya.index')
            ->with('success','Menambah Biaya telah berhasil disimpan');
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
        $data->biaya = Biaya::find($id);
        if(!$data->biaya){
            return redirect()->route('biaya.index')
                ->with('error','Biaya tidak ditemukan');
        }
        return view('pages.biaya.edit', compact('data'));
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
            'nama_biaya' => 'required ',
        ]);
        $update = Biaya::findOrFail($id)->update($request->all());
        return redirect()->route('biaya.index')
        ->with('success','Perubahan Biaya telah berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Biaya::find($id);
        try {
            $delete->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            //menampilkan kesalahan
            return $e->getMessage();
        }
    }
}
