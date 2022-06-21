@extends('adminlte::page')
@section('title')Transaksi Pembelian @endsection
@section('content')
    <div class="col-md-12 pt-3">
    @if ($message = Session::get('error'))
    <x-adminlte-alert theme="danger" title="Danger">
        {{ $message }}
    </x-adminlte-alert>
    @endif
        <div class="row">
            <!-- Billing Address -->
            <div class="col-md-8">
                <div class="card card-primary mb-0">
                    <div class="card-header bg-gd-primary">
                        <h3 class="block-title" style="font-size: 2rem;">Pembelian</h3>
                        <div class="block-options">
                            {{$data->date}}
                        </div>
                    </div>

                    <div class="card-body ">
                        <form action="{{route('pembelian.barang_store')}}"  method="post" > @csrf
                            <div class="form-group row">
                                <div class="col-12 col-sm-6 col-md-12 mb-3">
                                    <div class="form-material">
                                        <label for="id_barang">Kode Barang</label>
                                        <input type="hidden" class="form-control" id="id_det_beli" name="id_det_beli"  value="@php echo ($data->edit) ? $data->edit->id_det_beli: ''; @endphp">
                                        <select onchange="getharga(this, 'detail_beli')" class="js-select2 form-control" id="id_barang" name="id_barang" required style="width: 100%;" >
                                            <option>--Pilih Data--</option>
                                            @foreach($data->barang as $barang)
                                            <option harga="{{$barang->harga_beli_barang}}" value="{{$barang->id_barang}}" @php echo ($data->edit) ? ($data->edit->id_barang == $barang->id_barang) ? 'selected': '' : null; @endphp>{{$barang->id_barang}} [ {{$barang->nama_barang}} ]</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-6">
                                    <div class="form-material">
                                        <label for="harga_beli">Harga Barang</label>
                                        <input type="number" readonly class="form-control" id="harga_beli" value="@php echo ($data->edit) ? $data->edit->harga_beli: ''; @endphp" name="harga_beli" required >
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-6">
                                    <div class="form-material">
                                        <label for="jml_beli">Jumlah</label>
                                        <input type="number" min="0" step="0.1" class="form-control" id="jml_beli" value="@php echo ($data->edit) ? $data->edit->jml_beli: ''; @endphp" name="jml_beli" required >
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
                            <form method="post" action="{{route('pembelian.store')}}" > @csrf
                                <input type="hidden" class="form-control" id="total_beli" name="total_beli" value="{{$data->total}}">
                                <div class="form-group row">
                                    <div class="col-12 col-sm-6 col-md-6 ">
                                        <div class="form-material floating">
                                            <label for="faktur_beli" class="text-body-bg-dark">Nota</label>
                                            <input type="text" class="form-control text-body-bg-dark" required id="faktur_beli" name="faktur_beli" >
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-6 ">
                                        <div class="form-material floating">
                                            <label for="id_supplier" class="text-body-bg-dark">Supplier</label>
                                            <select class="js-select2 form-control select2-text-body-bg-dark" required id="id_supplier" name="id_supplier" style="width: 100%;" >
                                                <option></option>
                                                @foreach($data->supplier as $supplier)
                                                    <option  value="{{$supplier->id_supplier}}"> {{$supplier->nama_supplier}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <i class="d-flex justify-content-center fa fa-shopping-cart fa-5x text-body-bg-dark"></i>
                            <div class="d-flex justify-content-center font-size-h3 font-w700 text-white-op">@rp($data->total)</div>
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
        <div class="card mt-5 block-themed block-rounded ">
            <div class="card-header">
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
                            <td class="text-center">{{$list->jml_beli}}</td>
                            <td class="text-right">@rp($list->harga_beli)</td>
                            <td class="text-right">@rp($list->harga_beli*$list->jml_beli)</td>
                            <td class="text-center table-secondary">
                                <div class="btn-group">
                                    <a href="{{ route('pembelian.transaksi',[$list->id_det_beli]) }}" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    @php $link = route('pembelian.barang_delete') @endphp
                                    <a class="btn btn-sm btn-danger" onclick="deleteData('{{$list->id_det_beli}}', '{{$link}}')"><i class="fa fa-trash"></i></a>
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
                                <td colspan="4" class="text-right font-w600 text-uppercase">Total Pembelian :</td>
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

