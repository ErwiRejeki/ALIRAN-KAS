@extends('adminlte::page')
@section('title')Laporan Penjualan @endsection
@section('content')
    <div class="col-md-12 pt-3">
        <div class="card card-primary block-rounded">
            <div class="card-header bg-gd-primary">
                <h3 class="block-title" style="font-size: 2rem;">Laporan Penjualan</h3>
                <btn class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modal-fromleft">Periode</btn>
                <btn class="btn btn-secondary btn-sm" onclick="printDiv('print')">Print</btn>
            </div>
            <div id="print" class="block-content">
                <div class="font-w600 text-uppercase text-center">Laporan Penjualan per periode</div>
                <div class="font-w600 text-uppercase text-center">pada toko Sumber Rejeki</div>
                <div class="font-w600 text-uppercase text-center">periode @date($data->startdate) s.d @date($data->enddate)</div><br/>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="text-center" >Tanggal</th>
                            <th class="text-center" style="width: 30%;">No. Faktur</th>
                            <th class="text-right" style="width: 20%;">Subtotal</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $no=1; @endphp
                        @foreach($data->list as $list)
                            <tr>
                                <td class="font-w600 text-center">@date($list->kas_tgl)</td>
                                <td class="text-center font-w600 text-uppercase ">
                                    <a href="{{ route('penjualan.faktur',[$list->kas_id_value, 'faktur']) }}">{{$list->kas_id_value}}</a>
                                </td>
                                <td class="text-right">@rp($list->kas_debet)</td>
                            </tr>
                            @php $no++; @endphp @endforeach
                        @if($data->total==0)
                            <tr class="table-secondary">
                                <td colspan="3" class="text-left font-w600 text-uppercase">Data Kosong</td>
                            </tr>
                        @else
                            <tr class="table-secondary">
                                <td colspan="2" class="text-right font-w600 text-uppercase">Total :</td>
                                <td class="text-left font-w600">@rp($data->total)</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-fromleft" tabindex="-1" role="dialog" aria-labelledby="modal-fromleft" aria-hidden="true">
        <div class="modal-dialog modal-dialog-fromleft" role="document">
            <div class="modal-content">
                <form action="{{ route('laporan.lpenjualan') }}" method="get" >
                    <div class="card card-primary block-transparent mb-0">
                        <div class="card-header bg-primary">
                            <h3 class="block-title">Periode Laporan</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-6">
                                    <div class="form-material">
                                        <label for="startdate">Mulai</label>
                                        <input type="date" class="form-control" id="startdate" value="{{$data->startdate}}" name="startdate">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-material">
                                        <label for="enddate">Akhir</label>
                                        <input type="date" class="form-control" id="enddate" value="{{$data->enddate}}" name="enddate">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" >
                            <i class="fa fa-check"></i> Ubah
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
