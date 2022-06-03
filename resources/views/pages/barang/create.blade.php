@extends('adminlte::page')

@section('content_header')
<h4>Tambah Barang</h4>
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
                    <h3 class="ml-3">Form Barang</h3>
                </div>

            </div>
            <div class="card-body">
                <form method="POST" action="{{route('barang.store')}}">
                    @csrf
                    <x-adminlte-input name="nama_barang" label="Nama Barang" placeholder="Nama Barang" type="text" igroup-size="sm" required />
                    <x-adminlte-input name="harga_beli_barang" label="Harga Beli" placeholder="Harga Beli" type="number" igroup-size="sm" min=1 required>
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-dark">
                                Rp.
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-input name="stok_barang" label="Stok Barang" placeholder="Stok Barang" type="number" igroup-size="sm" min=1 required />
                    <x-adminlte-input name="potongan" label="Potongan Harga" placeholder="Potongan Harga" type="number" igroup-size="sm" min=1 required>
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-dark">
                                Rp.
                            </div>
                        </x-slot>
                    </x-adminlte-input>
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