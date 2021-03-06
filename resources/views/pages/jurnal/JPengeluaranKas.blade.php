@extends('adminlte::page')
@section('title')Jurnal Pengeluaran Kas @endsection
@section('content')
    <div class="col-md-12 pt-3">
        <div class="card card-primary block-themed block-rounded">
            <div class="card-header bg-gd-primary">
                <h3 class="block-title" style="font-size: 2rem;">Jurnal Pengeluaran Kas</h3>
            </div>
            <div class="block-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered ">
                        <thead>
                        <tr>
                            <th rowspan="2" class="text-center" style="width: 20%;">Tanggal</th>
                            <th rowspan="2">Keterangan</th>
                            <th rowspan="2" class="text-center" style="width: 10%;">No. Bukti Transaksi</th>
                            <th colspan="3" class="text-center" style="width: 40%;">Debet</th>
                            <th class="text-right" style="width: 20%;">Kredit</th>
                        </tr>
                        <tr>
                            <th class="text-right" style="width: 10%;">Pembelian</th>
                            <th class="text-right" style="width: 20%;">Retur Penjualan</th>
                            <th class="text-right" style="width: 10%;">Biaya</th>
                            <th class="text-right" style="width: 20%;">Kas</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $no=1; @endphp
                        @foreach($data->list as $list)
                            <tr>
                                <td class="font-w600 text-center">@date($list->kas_tgl)</td>
                                <td class="font-w600 text-uppercase">
                                    {{$list->kas_ket}}
                                </td>
                                <td class="text-center font-w600 text-uppercase text-primary">
                                   {{$list->kas_id_value}}
                                </td>
                                @if($list->kas_ket=='pembelian')
                                <td class="text-right">@rp($list->kas_kredit)</td>
                                <td class="text-right">@rp(0)</td>
                                <td class="text-right">@rp(0)</td>
                                @elseif($list->kas_ket=='retur penjualan')
                                <td class="text-right">@rp(0)</td>
                                <td class="text-right">@rp($list->kas_kredit)</td>
                                <td class="text-right">@rp(0)</td>
                                @elseif($list->kas_ket=='biaya')
                                <td class="text-right">@rp(0)</td>
                                <td class="text-right">@rp(0)</td>
                                <td class="text-right">@rp($list->kas_kredit)</td>
                                @endif
                                <td class="text-right">@rp($list->kas_kredit)</td>
                            </tr>
                            @php $no++; @endphp @endforeach
                        @if($data->total==0)
                            <tr class="table-secondary">
                                <td colspan="7" class="text-left font-w600 text-uppercase">Data Kosong</td>
                            </tr>
                        @else
                            <tr class="table-primary">
                                <td colspan="6" class="text-right font-w600 text-uppercase">Jumlah :</td>
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
