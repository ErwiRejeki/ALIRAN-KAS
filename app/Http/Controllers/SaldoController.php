<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kas;
use App\Helpers\Helper;
use Carbon\Carbon;

class SaldoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        Session(['saldo' => Helper::saldo()]);
    }
    public function store(Request $request)
    {
        //validasi
        
        $this->validate($request, [
            'saldo' => 'required ',
        ]);
        
        $kas_id = ['kas_id' => Helper::getCode('kas', 'kas_id', 'KAS-')];
        $kas_save = [
            'kas_id' => Helper::getCode('kas', 'kas_id', 'KAS-'),
            'kas_tgl' => Carbon::now(),
            'kas_type' =>'MODAL',
            'kas_ket' =>'modal awal',
            'kas_debet' =>$request->saldo,
        ];
        $kas = Kas::updateOrCreate($kas_id, $kas_save);
        return redirect()->back()
            ->with('success','Saldo berhasil ditambah');
    }

    
}
