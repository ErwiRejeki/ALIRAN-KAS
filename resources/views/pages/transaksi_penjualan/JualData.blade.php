@extends('adminlte::page')

@section('content')
    <div class="col-md-12 pt-3">
        <div class="card card-primary">
            <div class="card-header bg-gd-primary">
                <h3 class="block-title" style="font-size: 2rem;">
                    Daftar Penjualan 
                    <a  href="{{route('penjualan.transaksi')}}" class="btn btn-success">
                        <i class="fa fa-plus "></i> Tambah Penjualan
                    </a>
                    
                </h3>
            </div>
            <div class="block-content">
                <!-- Orders Table -->
                <div class="table-responsive p-3">
                    <table id="table_custome" class="table table-borderless table-striped js-dataTable-full-pagination">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 10%;">#</th>
                            <th>No Faktur</th>
                            <th>Tanggal</th>
                            <th class="text-right">Penjualan</th>
                            <th class="text-right">Retur</th>
                            <th class="text-right">Total</th>
                        </tr>
                        </thead>
                        @php $no=1; @endphp
                        @foreach ($data->list as $list)
                        <tbody>
                            <tr>
                                <td class="text-center font-w600 text-secondary text-uppercase">
                                   {{$no}}
                                </td>
                                <td class="text-center font-w600 text-secondary text-uppercase">
                                    <a href="{{ route('penjualan.faktur',[$list->id_jual, 'faktur']) }}">{{$list->id_jual}}</a>
                                </td>
                                <td class="font-w600 text-primary text-uppercase">
                                    @date($list->tgl_jual)
                                </td>
                                <td class="text-right font-w600 text-secondary ">
                                    @rp($list->total_jual)
                                </td>
                                <td class="text-right font-w600 text-secondary ">
                                    <a href="{{ route('penjualan.faktur',[$list->id_jual, 'retur']) }}">@rp($list->total_retur_jual)</a> 
                                </td>
                                <td class="text-right font-w600 text-secondary ">
                                    @rp($list->total_jual-$list->total_retur_jual)
                                </td>
                            </tr>
                        </tbody>
                        @php $no++; @endphp @endforeach
                    </table>
                </div>
                <!-- END Orders Table -->

            </div>
        </div>
    </div>
@endsection
