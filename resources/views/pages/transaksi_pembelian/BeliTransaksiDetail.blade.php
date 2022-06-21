@extends('adminlte::page')
@section('title')Transaksi Pembelian @endsection
@section('content')
    <div class="col-md-12 pt-3">
    @if ($message = Session::get('error'))
    <x-adminlte-alert theme="danger" title="Danger">
        {{ $message }}
    </x-adminlte-alert>
    @endif

    @if ($message = Session::get('success'))
    <x-adminlte-alert theme="success" title="Success">
        {{ $message }}
    </x-adminlte-alert>
    @endif

        @if($data->edit)
        <div class="row row-deck gutters-tiny">
            <!-- Billing Address -->
            <div class="col-md-12">
                <div class="card card-primary block-rounded">
                    <div class="card-header bg-gd-primary">
                        <h3 class="block-title" style="font-size: 2rem;">Retur Pembelian</h3>
                        <div class="block-options">
                            {{$data->date}}
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('pembelian.faktur_store') }}" method="post" > @csrf
                            <div class="form-group row">
                                <div class="col-12 col-sm-6 col-md-6">
                                    <div class="form-material mb-2">
                                        <label for="id_barang">Kode Barang</label>
                                        <input type="hidden" class="form-control" id="id_retur_beli" name="id_retur_beli"  value="@php echo ($data->retur) ? $data->retur->id_retur_beli: $data->pembelian->id_det_beli; @endphp">
                                        <input type="hidden" class="form-control" id="id_beli" name="id_beli"  value="@php echo ($data->retur) ? $data->retur->id_beli: $data->pembelian->id_beli; @endphp">
                                        <input type="hidden" class="form-control" id="total_retur" name="total_retur"  value="@php echo ($data->retur) ? $data->retur->jml_retur_beli*$data->retur->harga_retur_beli: 0; @endphp">
                                        <input type="hidden" class="form-control" id="total_pembelian" name="total_pembelian"  value="@php echo $data->total; @endphp">
                                        <input type="hidden" id="retur_jml_old" value="@php echo ($data->retur) ? $data->retur->jml_retur_beli: $data->pembelian->jml_beli; @endphp" name="retur_jml_old" >
                                        <input type="text" class="form-control" readonly id="id_barang" value="@php echo ($data->retur) ? $data->retur->id_barang: $data->pembelian->id_barang; @endphp" name="id_barang">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-6">
                                    <div class="form-material mb-2">
                                        <label for="barang">Nama Barang</label>
                                        <input type="text" class="form-control" readonly id="barang" value="@php echo ($data->retur) ? $data->retur->get_barang->nama_barang: $data->pembelian->get_barang->nama_barang; @endphp"  >
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-6">
                                    <div class="form-material mb-2">
                                        <label for="harga_retur_beli">Harga Barang</label>
                                        <input type="number" class="form-control" id="harga_retur_beli" min="0" value="@php echo ($data->retur) ? $data->retur->harga_retur_beli: $data->pembelian->harga_beli; @endphp" name="harga_retur_beli" required >
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-6">
                                    <div class="form-material mb-2">
                                        <label for="jml_retur_beli">Jumlah</label>
                                        <input type="number" min="0" step="0.1" max="{{$data->max}}" class="form-control" id="jml_retur_beli" value="@php echo ($data->retur) ? $data->retur->jml_retur_beli: $data->pembelian->jml_beli; @endphp" name="jml_retur_beli" required >
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row"></div>
                            <div class="dropdown-divider"></div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-plus"></i> Retur Barang
                                    </button>
                                    <button type="reset" class="btn btn-secondary">
                                        <i class="fa fa-minus"></i> Reset
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

        <div class="card card-primary block-rounded">
            <div class="card-header bg-gd-primary">
                <h3 class="block-title" style="font-size: 2rem;">Pembelian Barang No Faktur {{$data->faktur}}</h3>
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
                            <td class="font-w600 text-uppercase text-primary">{{$list->get_barang->nama_barang}} </td>
                            <td class="text-center">{{$list->jml_beli}}</td>
                            <td class="text-right">@rp($list->harga_beli)</td>
                            <td class="text-right">@rp($list->harga_beli*$list->jml_beli)</td>
                            @if($data->type=='retur')
                            <td class="text-center table-secondary">
                                <div class="btn-group">
                                    <a class="btn btn-sm btn-warning"
                                       href="{{ route('pembelian.faktur',[$list->id_beli, 'retur', $list->id_det_beli]) }}" ><i class="fa fa-edit"></i></a>
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

        <div class="card card-primary block-rounded">
            <div class="card-header bg-gd-primary">
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
                                <td class="font-w600 text-uppercase text-primary">{{$list->get_barang->nama_barang}} </td>
                                <td class="text-center">{{$list->jml_retur_beli}}</td>
                                <td class="text-right">@rp($list->harga_retur_beli)</td>
                                <td class="text-right">@rp($list->harga_retur_beli*$list->jml_retur_beli)</td>
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

    </div>
@endsection

