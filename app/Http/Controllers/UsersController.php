<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
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
        $users = Users::all();
        $dataTables = [];
        foreach($users as $item){
            $deleteLink = route('users.destroy', $item->id);
            $dataTables[] = [
                $item->id,
                $item->name,
                $item->jabatan,
                $item->email,
                $item->password,
                Helper::btnEdit('/users/' . $item->id . '/edit') . Helper::btnDelete("deleteData('$item->id', '$deleteLink')") 
            ];
        }

        $data =  new \stdClass();
        $data->heads = [ 
            'ID', 
            'Name',
            ['label' => 'Jabatan'],
            ['label' => 'Email'],
            ['label' => 'Password'],
            ['label' => 'Actions', 'no-export' => true, 'width' => 15],
        ];

        $data->config = [
            'data' => $dataTables,
            'order' => [[1, 'asc']],
            'columns' => [null, null, null, null, ['orderable' => false]],
        ];

        return view('pages.users.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.users.create');
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
            'name' => 'required ',
            'jabatan' => 'required ',
            'email' => 'required ',
            'password' => 'required ',
        ]);
        $store = new Users($request->all());
        $store->id = Helper::getCode('users', 'id', 'U-');
        $store->save();
        return redirect()->route('users.index')
            ->with('success','Menambah Users telah berhasil disimpan');
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
        $data->users = Users::find($id);
        if(!$data->users){
            return redirect()->route('users.index')
                ->with('error','Users tidak ditemukan');
        }
        return view('pages.users.edit', compact('data'));
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
            'name' => 'required ',
            'jabatan' => 'required ',
            'email' => 'required ',
            'password' => 'required ',
        ]);
        $update = Users::findOrFail($id)->update($request->all());
        return redirect()->route('users.index')
        ->with('success','Perubahan Users telah berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Users::find($id);
        try {
            $delete->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            //menampilkan kesalahan
            return $e->getMessage();
        }
    }
}
