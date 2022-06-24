@extends('layouts.app')
@section('title')Jurnal Penjualan @endsection
@section('content')
    <div class="col-md-12">
        <div class="block block-themed block-rounded">
            <div class="block-header bg-gd-primary">
                <h3 class="block-title" style="font-size: 2rem;">Jurnal Penjualan</h3>
            </div>
            <div class="block-content">
                <div class="table-responsive">
                    <table class="table table-borderless table-striped">
                        <thead>
                        <tr>
                            <th class="text-center" >Tanggal</th>
                            <th>Keterangan</th>
                            <th class="text-center" style="width: 30%;">No. Bukti Transaksi</th>
                            <th class="text-right" style="width: 20%;">Jumlah</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $no=1; @endphp
                        @foreach($data->list as $list)
                            <tr>
                                <td class="font-w600 text-center">@date($list->kas_tgl)</td>
                                <td class="font-w600 text-uppercase">Penjualan</td>
                                <td class="text-center font-w600 text-uppercase text-primary">
                                    <a href="{{ route('jual.faktur',[$list->jual_id]) }}">{{$list->jual_id}}</a>
                                </td>
                                <td class="text-right">@rp($list->kas_debet)</td>
                            </tr>
                            @php $no++; @endphp @endforeach
                        @if($data->total==0)
                            <tr class="table-secondary">
                                <td colspan="6" class="text-left font-w600 text-uppercase">Data Kosong</td>
                            </tr>
                        @else
                            <tr class="table-primary">
                                <td colspan="3" class="text-right font-w600 text-uppercase">Jumlah :</td>
                                <td class="text-left font-w600">@rp($data->total)</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
