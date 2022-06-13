@extends('adminlte::page')

@section('content_header')
<h4>Tambah Transaksi Pembelian</h4>
@stop

@section('plugins.Select2', true)
@section('plugins.TempusDominusBs4', true)
@php
$config = ['format' => 'YYYY-MM-DD'];
@endphp

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <button type="button" class="btn btn-primary btn-sm shadow" onclick="history.back()">
                        <i class="fa fa-arrow-left"></i>

                    </button>
                    <h3 class="ml-3">Form Transaksi Pembelian</h3>
                </div>

            </div>
            <div class="card-body">
                <form method="POST" action="{{route('transaksi_pembelian.store')}}">
                    @csrf
                    <x-adminlte-input-date name="tgl_beli" label="Tanggal" placeholder="Tanggal" :config="$config" required />
                    <x-adminlte-select2 name="id_barang" label="Nama Barang" required>
                        <option value="">Pilih Data</option>
                        @foreach($data->barang as $barang)
                        <option value="{{$barang->id_barang}}">{{$barang->nama_barang}}</option>
                        @endforeach
                    </x-adminlte-select2>
                    <x-adminlte-select2 name="id_supplier" label="Nama Supplier" required>
                        <option value="">Pilih Data</option>
                        @foreach($data->supplier as $supllier)
                        <option value="{{$supplier->id_supplier}}">{{$supplier->nama_supplier}}</option>
                        @endforeach
                    </x-adminlte-select2>
                    <x-adminlte-input name="jml_beli" label="Jumlah Beli" placeholder="Jumlah Beli" type="number" igroup-size="sm" required />
                    <x-adminlte-input name="harga_beli" label="Harga Beli" placeholder="Harga Beli" type="number" igroup-size="sm" min=1 required>
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-dark">
                                Rp.
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <x-adminlte-input name="total_beli" label="Total Beli" placeholder="Total Beli" type="number" igroup-size="sm" min=1 required>
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