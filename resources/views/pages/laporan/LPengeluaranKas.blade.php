@extends('layouts.app')
@section('title')Laporan Pengeluaran Kas @endsection
@section('content')
    <div class="col-md-12">
        <div class="block block-themed block-rounded">
            <div class="block-header bg-gd-primary">
                <h3 class="block-title" style="font-size: 2rem;">Laporan Pengeluaran Kas</h3>
                <btn class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modal-fromleft">Periode</btn>
                <btn class="btn btn-secondary btn-sm" onclick="printDiv('print')">Print</btn>
            </div>
            <div id="print" class="block-content">
                <div class="font-w600 text-uppercase text-center">Laporan Pengeluaran Kas per periode</div>
                <div class="font-w600 text-uppercase text-center">pada toko ida</div>
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
                        @foreach($data->fix as $list)
                            <tr>
                                <td class="font-w600 text-center">@date($list->kas_tgl)</td>
                                <td class="text-center font-w600 text-uppercase ">
                                    {{$list->nobuk}}
                                </td>
                                <td class="text-right">@rp($list->kas_kredit)</td>
                            </tr>
                            @php $no++; @endphp @endforeach
                        @if($data->total==0)
                            <tr class="table-secondary">
                                <td colspan="6" class="text-left font-w600 text-uppercase">Data Kosong</td>
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
                <form action="{{ route('laporan.lpengeluarankas') }}" method="get" >
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-primary">
                            <h3 class="block-title">Periode Laporan</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="si si-close"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            <div class="form-group row">
                                <div class="col-6">
                                    <div class="form-material">
                                        <input type="date" class="form-control" id="startdate" value="{{$data->startdate}}" name="startdate">
                                        <label for="startdate">Mulsi</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-material">
                                        <input type="date" class="form-control" id="enddate" value="{{$data->enddate}}" name="enddate">
                                        <label for="enddate">Akhir</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-alt-success" >
                            <i class="fa fa-check"></i> Ubah
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
