@extends('adminlte::page')
@section('title')Transaksi Penjualan @endsection
@section('content')
    <div class="col-md-12 pt-3">
        @if ($message = Session::get('error'))
        <x-adminlte-alert theme="danger" title="Danger">
            {{ $message }}
        </x-adminlte-alert>
        @endif
        <div class="row row-deck gutters-tiny">
            <!-- Billing Address -->
            <div class="col-md-8">
                <div class="card card-primary mb-0">
                    <div class="card-header bg-gd-primary">
                        <h3 class="block-title" style="font-size: 2rem;">Penjualan</h3>
                        <div class="block-options">
                            {{$data->date}}
                        </div>
                    </div>

                    <div class="card-body">
                        <form  method="post" action="{{route('penjualan.barang_store')}}" > @csrf
                            <div class="form-group row">
                                <div class="col-12 col-sm-6 col-md-12 mb-3">
                                    <div class="form-material">
                                        <label for="id_barang">Kode Barang</label>
                                        <input type="hidden" class="form-control" id="id_det_jual" name="id_det_jual"  value="@php echo ($data->edit) ? $data->edit->id_det_jual: ''; @endphp">
                                        <select onchange="getharga(this, 'detail_jual')" class="js-select2 form-control" id="id_barang" name="id_barang" required style="width: 100%;" >
                                            <option>--Pilih Data--</option>
                                            @foreach($data->barang as $barang)
                                            <option harga_beli="{{$barang->harga_beli_barang}}" harga="{{$barang->harga_beli_barang + ( ($barang->harga_beli_barang/100)*$barang->margin_barang ) }}" stok="{{$barang->stok_barang}}" value="{{$barang->id_barang}}" @php echo ($data->edit) ? ($data->edit->id_barang == $barang->id_barang) ? 'selected': '' : null; @endphp>{{$barang->id_barang}} [ {{$barang->nama_barang}} ]</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-6">
                                    <div class="form-material">
                                        <label for="harga_jual">Harga Barang</label>
                                        <input type="number" min="0" readonly="readonly" class="form-control" id="harga_jual" value="@php echo ($data->edit) ? $data->edit->harga_jual: ''; @endphp" name="harga_jual" required >
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-6">
                                    <div class="form-material">
                                        <label for="jml_jual">Jumlah</label>
                                        <input type="number" min="0" step="0.1" @php echo ($data->edit) ? 'max="'.$data->edit->get_barang->stok_barang.'"': ''; @endphp onchange="enableHarga()" class="form-control" id="jml_jual" value="@php echo ($data->edit) ? $data->edit->jml_jual: ''; @endphp" name="jml_jual" required >
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row"></div>
                            <div class="dropdown-divider"></div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-plus"></i> Tambah Barang
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

            <!-- Shipping Address -->
            <div class="col-md-4">

                    <div class="card card-secondary h-100" >
                        <div class="card-header block-content-full h-100" >
                            <span class="text-body-bg-dark font-w700 d-flex justify-content-center text-uppercase mb-5">Selesaikan Transaksi</span>
                            <form method="post" action="{{route('penjualan.store')}}" > @csrf
                                <input type="hidden" class="form-control" id="total_jual" name="total_jual" value="{{$data->total}}">
                                
                            <i class="d-flex justify-content-center fa fa-shopping-cart fa-5x text-body-bg-dark mb-3"></i>
                            <div class="d-flex justify-content-center h1 font-w700 text-white-op mb-3">@rp($data->total)</div>
                            <div class="col-12 d-flex justify-content-center">
                                <button type="submit"  @if($data->total==0) {{'disabled'}} @endif class="d-flex justify-content-center btn btn-success">
                                    Bayar
                                </button>
                            </div>
                            </form>
                        </div>
                    </div>

            </div>
            <!-- END Shipping Address -->
        </div>
        <div class="card  mt-5 block-rounded">
            <div class="card-header bg-gd-primary">
                <h3 class="block-title" style="font-size: 2rem;">Barang</h3>
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
                            <th class="text-center table-secondary" style="width: 100px;">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $no=1; @endphp
                        @foreach($data->list as $list)
                        <tr>
                            <td class="font-w600 text-center">{{$no}}</td>
                            <td class="font-w600 text-uppercase text-primary">{{$list->get_barang->nama_barang}} </td>
                            <td class="text-center">{{$list->jml_jual}}</td>
                            <td class="text-right">@rp($list->harga_jual)</td>
                            <td class="text-right">@rp($list->harga_jual*$list->jml_jual)</td>
                            <td class="text-center table-secondary">
                                <div class="btn-group">
                                    <a href="{{ route('penjualan.transaksi',[$list->id_det_jual]) }}" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    @php $link = route('penjualan.barang_delete') @endphp
                                    <a class="btn btn-sm btn-danger" onclick="deleteData('{{$list->id_det_jual}}', '{{$link}}')"><i class="fa fa-times"></i></a>
                                </div>
                            </td>
                        </tr>
                        @php $no++; @endphp @endforeach
                        @if($data->total==0)
                            <tr class="table-secondary">
                                <td colspan="6" class="text-left font-w600 text-uppercase">Data Kosong</td>
                            </tr>
                        @else
                            <tr class="table-primary">
                                <td colspan="4" class="text-right font-w600 text-uppercase">Total Penjualan :</td>
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
@section('js')
<script>
var total = @php echo($data->total) ; @endphp ;
</script>
@endsection

