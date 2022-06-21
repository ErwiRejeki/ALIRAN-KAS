@extends('adminlte::page')

@section('content')
    <div class="col-md-12 pt-3">
        <div class="card card-primary">
            <div class="card-header bg-gd-primary">
                <h3 class="block-title" style="font-size: 2rem;">
                    Daftar Pembelian 
                    <a  href="{{route('pembelian.transaksi')}}" class="btn btn-success">
                        <i class="fa fa-plus "></i> Tambah Pembelian
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
                            <th>Supplier</th>
                            <th>Tanggal</th>
                            <th class="text-right">Pembelian</th>
                            <th class="text-right">Retur</th>
                            <th class="text-right">Total</th>
                        </tr>
                        </thead>
                        @foreach ($data->list as $list)
                        <tbody>
                            <tr>
                                <td class="text-center font-w600 text-secondary text-uppercase">
                                   1
                                </td>
                                <td class="text-center font-w600 text-secondary text-uppercase">
                                    <a href="{{ route('pembelian.faktur',[$list->id_beli, 'faktur']) }}">{{$list->faktur_beli}}</a>
                                </td>
                                <td class="font-w600 text-secondary text-uppercase">
                                    {{$list->get_supplier->nama_supplier}}
                                </td>
                                <td class="font-w600 text-primary text-uppercase">
                                    @date($list->tgl_beli)
                                </td>
                                <td class="text-right font-w600 text-secondary ">
                                    @rp($list->total_beli)
                                </td>
                                <td class="text-right font-w600 text-secondary ">
                                    <a href="{{ route('pembelian.faktur',[$list->id_beli, 'retur']) }}">@rp($list->total_retur_beli)</a> 
                                </td>
                                <td class="text-right font-w600 text-secondary ">
                                    @rp($list->total_beli-$list->total_retur_beli)
                                </td>
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
                <!-- END Orders Table -->

            </div>
        </div>
    </div>
@endsection
