@extends('adminlte::page')

@section('title')Jurnal Pembelian @endsection
@section('content_header')
<h4>Daftar Supplier</h4>
@stop
@section('content_header')
    <div class="col-md-12">
        <div class="block block-themed block-rounded">
            <div class="block-header bg-gd-primary">
                <h3 class="block-title" style="font-size: 2rem;">Jurnal Pembelian</h3>
            </div>
            <div class="block-content">
                <div class="table-responsive">
                    <table class="table table-borderless table-striped">
                        <thead>
                        <tr>
                            <th class="text-center" >Tanggal</th>
                            <th>Keterangan</th>
                            <th class="text-center" style="width: 30%;">No. Bukti Transaksi</th>
                            <th class="text-right" style="width: 20%;">Debet (Pembelian)</th>
                            <th class="text-right" style="width: 20%;">Kredit (KAS)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $no=1; @endphp
                        @foreach($data->list as $list)
                            <tr>
                                <td class="font-w600 text-center">@date($list->kas_tgl)</td>
                                <td class="font-w600 text-uppercase">Pembelian</td>
                                <td class="text-center font-w600 text-uppercase text-primary">
                                    <a href="{{ route('beli.faktur',[$list->beli_id, 'faktur']) }}">{{$list->beli_faktur}}</a>
                                </td>
                                <td class="text-right">@rp($list->kas_kredit)</td>
                                <td class="text-right">@rp($list->kas_kredit)</td>
                            </tr>
                            @php $no++; @endphp @endforeach
                        @if($data->total==0)
                            <tr class="table-secondary">
                                <td colspan="6" class="text-left font-w600 text-uppercase">Data Kosong</td>
                            </tr>
                        @else
                            <tr class="table-primary">
                                <td colspan="4" class="text-right font-w600 text-uppercase">Jumlah :</td>
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
