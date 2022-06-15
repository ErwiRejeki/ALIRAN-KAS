@extends('layouts.app')
@section('title')Transaksi Pembelian @endsection
@section('content')
    <div class="col-md-12">
        <div class="row row-deck gutters-tiny">
            <!-- Billing Address -->
            <div class="col-md-8">
                <div class="block block-themed block-rounded">
                    <div class="block-header bg-gd-primary">
                        <h3 class="block-title" style="font-size: 2rem;">Pembelian</h3>
                        <div class="block-options">
                            {{$data->date}}
                        </div>
                    </div>

                    <div class="block-content">
                        <form action="{{ route('pembelian.barang_store') }}" method="post" > @csrf
                            <div class="form-group row">
                                <div class="col-12 col-sm-6 col-md-12">
                                    <div class="form-material">
                                        <input type="hidden" class="form-control" id="id_det_beli" name="id_det_beli"  value="@php echo ($data->edit) ? $data->edit->id_det_beli: ''; @endphp">
                                        <select onchange="getharga(this, 'detail_beli')" class="js-select2 form-control" id="id_barang" name="id_barang" required style="width: 100%;" >
                                            <option>--Pilih Data--</option>
                                            @foreach($data->barang as $barang)
                                            <option harga="{{$barang->harga_beli}}" value="{{$barang->id_barang}}" @php echo ($data->edit) ? ($data->edit->id_barang == $barang->id_barang) ? 'selected': '' : null; @endphp>{{$barang->id_barang}} [ {{$barang->nama_barang}} ]</option>
                                            @endforeach
                                        </select>
                                        <label for="id_barang">Kode Barang</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-6">
                                    <div class="form-material">
                                        <input type="number" readonly class="form-control" id="beli_detail_harga" value="@php echo ($data->edit) ? $data->edit->beli_detail_harga: ''; @endphp" name="beli_detail_harga" required >
                                        <label for="beli_detail_harga">Harga Barang</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-6">
                                    <div class="form-material">
                                        <input type="number" min="0" step="0.1" class="form-control" id="beli_detail_jml" value="@php echo ($data->edit) ? $data->edit->beli_detail_jml: ''; @endphp" name="beli_detail_jml" required >
                                        <label for="beli_detail_jml">Jumlah</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row"></div>
                            <div class="dropdown-divider"></div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-alt-primary">
                                        <i class="fa fa-plus mr-5"></i> Tambah Barang
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

            <!-- Shipping Address -->
            <div class="col-md-4">

                    <div class="block block-rounded bg-gd-primary" >
                        <div class="block-content block-content-full ">
                            <span class="text-body-bg-dark font-w700 d-flex justify-content-center text-uppercase">Selesaikan Transaksi</span>
                            <form action="{{ route('beli.store') }}" method="post" > @csrf
{{--                                <input type="hidden" class="form-control" id="beli_id" name="beli_id" >--}}
                                <input type="hidden" class="form-control" id="beli_total" name="beli_total" value="{{$data->total}}">
                                <div class="form-group row">
                                    <div class="col-12 col-sm-6 col-md-6 ">
                                        <div class="form-material floating">
                                            <input type="text" class="form-control text-body-bg-dark" required id="beli_faktur" name="beli_faktur" >
                                            <label for="beli_faktur" class="text-body-bg-dark">Nota</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-6 ">
                                        <div class="form-material floating">
                                            <select class="js-select2 form-control select2-text-body-bg-dark" required id="supplier_id" name="supplier_id" style="width: 100%;" >
                                                <option></option>
                                                @foreach($data->supplier as $supplier)
                                                    <option  value="{{$supplier->supplier_id}}"> {{$supplier->supplier_nama}} </option>
                                                @endforeach
                                            </select>
                                            <label for="supplier_id" class="text-body-bg-dark">Supplier</label>
                                        </div>
                                    </div>
                                </div>
                            <i class="d-flex justify-content-center fa fa-shopping-cart fa-5x text-body-bg-dark"></i>
                            <div class="d-flex justify-content-center font-size-h3 font-w700 text-white-op">@rp($data->total)</div>
                            <div class="col-12 d-flex justify-content-center">
                                <button type="submit"  @if($data->total==0) {{'disabled'}} @endif class="d-flex justify-content-center btn btn-alt-primary">
                                    <i class="fa fa-cc-paypal mr-5"></i> Bayar
                                </button>
                            </div>
                            </form>
                        </div>
                    </div>

            </div>
            <!-- END Shipping Address -->
        </div>
        <div class="block block-themed block-rounded">
            <div class="block-header bg-gd-primary">
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
                            <td class="font-w600 text-uppercase text-primary">{{$list->barang_nama}} </td>
                            <td class="text-center">{{$list->beli_detail_jml}}</td>
                            <td class="text-right">@rp($list->beli_detail_harga)</td>
                            <td class="text-right">@rp($list->beli_detail_harga*$list->beli_detail_jml)</td>
                            <td class="text-center table-secondary">
                                <div class="btn-group">
                                    <a href="{{ route('beli.transaksi',[$list->beli_detail_id]) }}" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a class="btn btn-sm btn-danger" data-toggle="confirmation" data-popout="true" data-title="Hapus Data ini?"
                                       href="{{ route('pembelian.barang_delete',[$list->beli_detail_id]) }}" ><i class="fa fa-times"></i></a>
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

