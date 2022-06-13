<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\Helper;

class UserController extends Controller
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
        $user = User::all();
        $dataTables = [];
        foreach($user as $item){
            $deleteLink = route('user.destroy', $item->id);
            $dataTables[] = [
                $item->id,
                $item->name,
                $item->jabatan,
                $item->email,
                $item->password,
                Helper::btnEdit('/user/' . $item->id . '/edit') . Helper::btnDelete("deleteData('$item->id', '$deleteLink')") 
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
            'columns' => [null, null, null, null, null, ['orderable' => false]],
        ];

        return view('pages.user.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.user.create');
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
        $store = new User($request->all());
        $store->save();
        return redirect()->route('user.index')
            ->with('success','Menambah User telah berhasil disimpan');
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
        $data->user = User::find($id);
        if(!$data->user){
            return redirect()->route('user.index')
                ->with('error','User tidak ditemukan');
        }
        return view('pages.user.edit', compact('data'));
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
        $update = User::findOrFail($id)->update($request->all());
        return redirect()->route('user.index')
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
        $delete = User::find($id);
        try {
            $delete->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            //menampilkan kesalahan
            return $e->getMessage();
        }
    }
}
