@extends('adminlte::page')
@section('title')Laporan Arus Kas @endsection
@section('content')
    <div class="col-md-12 pt-3">
        <div class="card card-primary block-rounded">
            <div class="card-header bg-gd-primary">
                <h3 class="block-title" style="font-size: 2rem;">Laporan Arus Kas</h3>
                <btn class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modal-fromleft">Periode</btn>
                <btn class="btn btn-secondary btn-sm" onclick="printDiv('print')">Print</btn>
            </div>
            <div id="print" class="block-content">
                <div class="font-w600 text-uppercase text-center">Laporan Arus Kas per periode</div>
                <div class="font-w600 text-uppercase text-center">pada toko sumber rejeki</div>
                <div class="font-w600 text-uppercase text-center">periode @date($data->startdate) s.d @date($data->enddate)</div><br/>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="text-center" >Nama Akun</th>
                            <th class="text-right" style="width: 20%;">Nominal</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="font-w600 text-center">Arus Kas dari Aktivitas Operasional</td>
                                <td class="font-w600 text-center"></td>
                            </tr>
                            <tr>
                                <td class="text-left">Penerimaan dari Pelanggan</td>
                                <td class="text-right">@rp($data->penjualan)</td>
                            </tr>
                            <tr>
                                <td class="text-left">Pembayaran ke Supplier</td>
                                <td class="text-right">@rp($data->pembelian)</td>
                            </tr>
                            <tr>
                                <td class="text-left">Pengeluaran Operasional</td>
                                <td class="text-right">@rp($data->biaya)</td>
                            </tr>
                            <tr class="table-secondary">
                                <td class="text-right font-w600 text-uppercase">Kas Bersih yang diperoleh dari Aktivitas Operasional</td>
                                <td class="text-right font-w600">@rp($data->penjualan-$data->pembelian-$data->biaya)</td>
                            </tr>

                            <tr>
                                <td class="font-w600 text-center">Arus Kas dari Aktivitas Investasi</td>
                                <td class="font-w600 text-center"></td>
                            </tr>
                            <tr>
                                <td class="text-left">Perolehan / Penjualan Aset</td>
                                <td class="text-right">Rp. 0</td>
                            </tr>
                            <tr>
                                <td class="text-left">Aktivitas investasi lainnya</td>
                                <td class="text-right">Rp. 0</td>
                            </tr>
                            <tr class="table-secondary">
                                <td class="text-right font-w600 text-uppercase">Kas Bersih yang diperoleh dari Aktivitas Investasi</td>
                                <td class="text-right font-w600">Rp. 0</td>
                            </tr>

                            <tr>
                                <td class="font-w600 text-center">Arus Kas dari Aktivitas Keuangan</td>
                                <td class="font-w600 text-center"></td>
                            </tr>
                            <tr>
                                <td class="text-left">Pembayaran / Penerimaan Pinjaman</td>
                                <td class="text-right">Rp. 0</td>
                            </tr>
                            <tr>
                                <td class="text-left">Ekuitas /  Modal</td>
                                <td class="text-right">Rp. 0</td>
                            </tr>
                            <tr class="table-secondary">
                                <td class="text-right font-w600 text-uppercase">Kas Bersih yang diperoleh dari Aktivitas Investasi</td>
                                <td class="text-right font-w600">Rp. 0</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-fromleft" tabindex="-1" role="dialog" aria-labelledby="modal-fromleft" aria-hidden="true">
        <div class="modal-dialog modal-dialog-fromleft" role="document">
            <div class="modal-content">
                <form action="{{ route('laporan.laruskas') }}" method="get" >
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
