@extends('layouts.app')
@section('title')Faktur Penjualan @endsection
@section('content')
    <div class="col-md-12">

        <div class="block block-themed block-rounded">
            <div class="block-header bg-gd-primary">
                <h3 class="block-title" style="font-size: 2rem;">Detail No Faktur {{$data->id}} Pada @date($data->date)</h3>
            </div>
            <div class="block-content">
                <div class="table-responsive">
                    <table class="table table-borderless table-striped">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th>Barang</th>
                            <th class="text-center" style="width: 10%;">QTY</th>
                            <th class="text-right" style="width: 10%;">@harga</th>
                            <th class="text-right" style="width: 10%;">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $no=1; @endphp
                        @foreach($data->list as $list)
                            <tr>
                                <td class="font-w600 text-center">{{$no}}</td>
                                <td class="font-w600 text-uppercase text-primary">{{$list->barang_nama}} </td>
                                <td class="text-center">{{$list->jual_detail_jml}}</td>
                                <td class="text-right">@rp($list->jual_detail_harga)</td>
                                <td class="text-right">@rp($list->jual_detail_harga*$list->jual_detail_jml)</td>
                            </tr>
                            @php $no++; @endphp @endforeach
                        @if($data->total==0)
                            <tr class="table-secondary">
                                <td colspan="6" class="text-left font-w600 text-uppercase">Data Kosong</td>
                            </tr>
                        @else
                            <tr class="table-primary">
                                <td colspan="4" class="text-right font-w600 text-uppercase">Total Penjualan :</td>
                                <td colspan="2" class="text-left font-w600">@rp($data->total)</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    <p>Notice : Barang yang dijual tidak dapat dikembalikan</p>
                </div>
            </div>
        </div>
    </div>
@endsection
