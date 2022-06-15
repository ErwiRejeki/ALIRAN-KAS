@extends('layouts.app')
@section('title')Jurnal Pembelian @endsection
@section('content')
    <div class="col-md-12">
        @if($data->edit)
        <div class="row row-deck gutters-tiny">
            <!-- Billing Address -->
            <div class="col-md-12">
                <div class="block block-themed block-rounded">
                    <div class="block-header bg-gd-primary">
                        <h3 class="block-title" style="font-size: 2rem;">Retur Pembelian</h3>
                        <div class="block-options">
                            {{$data->date}}
                        </div>
                    </div>

                    <div class="block-content">
                        <form action="{{ route('beli.faktur_store') }}" method="post" > @csrf
                            <div class="form-group row">
                                <div class="col-12 col-sm-6 col-md-6">
                                    <div class="form-material">
                                        <input type="hidden" class="form-control" id="retur_id" name="retur_id"  value="@php echo ($data->retur) ? $data->retur->retur_id: $data->pembelian->beli_detail_id; @endphp">
                                        <input type="hidden" class="form-control" id="beli_id" name="beli_id"  value="@php echo ($data->retur) ? $data->retur->beli_id: $data->pembelian->beli_id; @endphp">
                                        <input type="hidden" class="form-control" id="total_retur" name="total_retur"  value="@php echo ($data->retur) ? $data->retur->retur_jml*$data->retur->retur_harga: 0; @endphp">
                                        <input type="hidden" class="form-control" id="total_pembelian" name="total_pembelian"  value="@php echo $data->total; @endphp">
                                        <input type="hidden" id="retur_jml_old" value="@php echo ($data->retur) ? $data->retur->retur_jml: $data->pembelian->beli_detail_jml; @endphp" name="retur_jml_old" >
                                        <input type="text" class="form-control" readonly id="barang_id" value="@php echo ($data->retur) ? $data->retur->barang_id: $data->pembelian->barang_id; @endphp" name="barang_id">
                                        <label for="barang_id">Kode Barang</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-6">
                                    <div class="form-material">
                                        <input type="text" class="form-control" readonly id="barang" value="@php echo ($data->retur) ? $data->retur->barang_nama: $data->pembelian->barang_nama; @endphp"  >
                                        <label for="barang">Nama Barang</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-6">
                                    <div class="form-material">
                                        <input type="number" class="form-control" id="retur_harga" value="@php echo ($data->retur) ? $data->retur->retur_harga: $data->pembelian->beli_detail_harga; @endphp" name="retur_harga" required >
                                        <label for="retur_harga">Harga Barang</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-6">
                                    <div class="form-material">
                                        <input type="number" min="0" step="0.1" max="{{$data->max}}" class="form-control" id="retur_jml" value="@php echo ($data->retur) ? $data->retur->retur_jml: $data->pembelian->beli_detail_jml; @endphp" name="retur_jml" required >
                                        <label for="retur_jml">Jumlah</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row"></div>
                            <div class="dropdown-divider"></div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-alt-primary">
                                        <i class="fa fa-plus mr-5"></i> Retur Barang
                                    </button>
                                    <button type="reset" class="btn btn-alt-secondary">
                                        <i class="fa fa-minus mr-5"></i> Reset
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END Billing Address -->
        </div>
        @endif

        <div class="block block-themed block-rounded">
            <div class="block-header bg-gd-primary">
                <h3 class="block-title" style="font-size: 2rem;">Pembelian Barang No Faktur {{$data->faktur}}
                    @if($data->type=='retur')
                        <btn class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-fromleft">change</btn>
                    @endif
                </h3>
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
                            @if($data->type=='retur')
                            <th class="text-center table-secondary" style="width: 100px;">Actions</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @php $no=1; @endphp
                        @foreach($data->list as $list)
                        <tr>
                            <td class="font-w600 text-center">{{$no}}</td>
                            <td class="font-w600 text-uppercase text-primary">{{$list->barang_nama}} </td>
                            <td class="text-center">{{$list->beli_detail_jml}}</td>
                            <td class="text-right">@rp($list->beli_detail_harga)</td>
                            <td class="text-right">@rp($list->beli_detail_harga*$list->beli_detail_jml)</td>
                            @if($data->type=='retur')
                            <td class="text-center table-secondary">
                                <div class="btn-group">
                                    <a class="btn btn-sm btn-warning" data-toggle="confirmation" data-popout="true" data-title="Retur barang ini?"
                                       href="{{ route('beli.faktur',[$list->beli_id, 'retur', $list->beli_detail_id]) }}" ><i class="fa fa-refresh"></i></a>
                                </div>
                            </td>
                            @endif
                        </tr>
                        @php $no++; @endphp @endforeach
                        @if($data->total==0)
                            <tr class="table-secondary">
                                <td colspan="6" class="text-left font-w600 text-uppercase">Data Kosong</td>
                            </tr>
                        @else
                            <tr class="table-primary">
                                <td colspan="4" class="text-right font-w600 text-uppercase">Total Pembelian :</td>
                                <td colspan="2" class="text-left font-w600">@rp($data->total)</td>
                            </tr>
                         @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="block block-themed block-rounded">
            <div class="block-header bg-gd-primary">
                <h3 class="block-title" style="font-size: 2rem;">Retur Barang</h3>
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
                        @foreach($data->retur_list as $list)
                            <tr>
                                <td class="font-w600 text-center">{{$no}}</td>
                                <td class="font-w600 text-uppercase text-primary">{{$list->barang_nama}} </td>
                                <td class="text-center">{{$list->retur_jml}}</td>
                                <td class="text-right">@rp($list->retur_harga)</td>
                                <td class="text-right">@rp($list->retur_harga*$list->retur_jml)</td>
                            </tr>
                            @php $no++; @endphp @endforeach
                        @if($data->total_retur==0)
                            <tr class="table-secondary">
                                <td colspan="5" class="text-left font-w600 text-uppercase">Data Kosong</td>
                            </tr>
                        @else
                            <tr class="table-primary">
                                <td colspan="3" class="text-right font-w600 text-uppercase">Total Retur :</td>
                                <td colspan="2" class="text-left font-w600">@rp($data->total_retur)</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

            <div class="modal fade" id="modal-fromleft" tabindex="-1" role="dialog" aria-labelledby="modal-fromleft" aria-hidden="true">
                <div class="modal-dialog modal-dialog-fromleft" role="document">
                    <div class="modal-content">
                        <form action="{{ route('beli.ubah_faktur') }}" method="post" > @csrf
                        <div class="block block-themed block-transparent mb-0">
                            <div class="block-header bg-primary">
                                <h3 class="block-title">Ubah No. Faktur</h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                        <i class="si si-close"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="block-content">
                                    <div class="form-group row">
                                        <div class="col-12">
                                            <div class="form-material">
                                                <input type="hidden" class="form-control" id="beli_id" name="beli_id"  value="{{$data->id}}">
                                                <input type="text" class="form-control" id="beli_faktur" value="{{$data->faktur}}" name="beli_faktur">
                                                <label for="beli_faktur">No. Faktur</label>
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
    </div>
@endsection

