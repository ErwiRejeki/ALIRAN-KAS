@extends('adminlte::page')

@section('title')Jurnal Penerimaan Kas @endsection
@section('content')
    <div class="col-md-12 pt-3">
        <div class="card card-primary block-rounded">
            <div class="card-header bg-gd-primary">
                <h3 class="block-title" style="font-size: 2rem;">Jurnal Penerimaan Kas</h3>
            </div>
            <div class="block-content">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th rowspan="2" class="text-center" >Tanggal</th>
                            <th rowspan="2">Keterangan</th>
                            <th rowspan="2" class="text-center" style="width: 30%;">No. Bukti Transaksi</th>
                            <th rowspan="2" class="text-right" style="width: 20%;">Debet (KAS)</th>
                            <th colspan="2" class="text-center" style="width: 20%;">Kredit</th>
                        </tr>
                        <tr>
                            <th class="text-right" style="width: 20%;">Penjualan</th>
                            <th class="text-right" style="width: 20%;">Retur Pembelian</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $no=1; @endphp
                        @foreach($data->list as $list)
                            <tr>
                                <td class="font-w600 text-center">@date($list->kas_tgl)</td>
                                <td class="font-w600 text-uppercase">
                                {{$list->kas_type}} {{$list->kas_ket}}
                                </td>
                                <td class="text-center font-w600 text-uppercase text-primary">
                                   {{$list->kas_id_value}}
                                </td>
                                <td class="text-right">@rp($list->kas_debet)</td>
                                @if($list->kas_ket=='penjualan')
                                <td class="text-right">@rp($list->kas_debet)</td>
                                <td class="text-right">@rp(0)</td>
                                @elseif($list->kas_ket=='retur pembelian')
                                <td class="text-right">@rp(0)</td>
                                <td class="text-right">@rp($list->kas_debet)</td>
                                @endif
                            </tr>
                            @php $no++; @endphp @endforeach
                        @if($data->total==0)
                            <tr class="table-secondary">
                                <td colspan="6" class="text-left font-w600 text-uppercase">Data Kosong</td>
                            </tr>
                        @else
                            <tr class="table-primary">
                                <td colspan="4" class="text-right font-w600 text-uppercase">Jumlah :</td>
                                <td colspan="2" class="text-left font-w600">@rp($data->total)</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
