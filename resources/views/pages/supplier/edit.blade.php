@extends('adminlte::page')

@section('content_header')
<h4>Edit Supplier</h4>
@stop

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <button type="button" class="btn btn-primary btn-sm shadow" onclick="history.back()">
                        <i class="fa fa-arrow-left"></i>

                    </button>
                    <h3 class="ml-3">Form Supplier</h3>
                </div>

            </div>
            <div class="card-body">
                <form method="POST" action="{{route('supplier.update', [$data->supplier->id_supplier])}}">
                    @method('PUT')
                    @csrf
                    <x-adminlte-input name="id_supplier" label="ID Supplier" placeholder="ID Supplier" type="text" igroup-size="sm" value="{{$data->supplier->id_supplier}}" required readonly />
                    <x-adminlte-input name="nama_supplier" label="Nama Supplier" placeholder="Nama Supplier" type="text" igroup-size="sm" value="{{$data->supplier->nama_supplier}}" required />
                    <x-adminlte-input name="alamat_supplier" label="Alamat Supplier" placeholder="Alamat Supplier" type="text" igroup-size="sm" value="{{$data->supplier->alamat_supplier}}" required />
                    <x-adminlte-input name="telp_supplier" label="Telp Supplier" placeholder="Telp _supplier" type="text" igroup-size="sm" value="{{$data->supplier->telp_supplier}}" required />

                    <x-adminlte-button class="btn-flat" type="reset" label="Reset" theme="secondary" icon="fas fa-lg fa-arrow-left" />
                    <x-adminlte-button class="btn-flat" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save" />
                </form>
            </div>
        </div>
    </div>

</div>


@stop

@section('css')

@stop

@section('js')

@stop