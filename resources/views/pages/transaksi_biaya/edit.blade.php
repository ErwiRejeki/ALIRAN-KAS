@extends('adminlte::page')

@section('content_header')
<h4>Edit Transaksi Biaya</h4>
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
                    <h3 class="ml-3">Form Transaksi Biaya</h3>
                </div>

            </div>
            <div class="card-body">
                <form method="POST" action="{{route('transaksi_biaya.update', [$data->detailbiaya->id_det_biaya])}}">
                    @method('PUT')
                    @csrf
                    <x-adminlte-input name="id_det_biaya" label="ID" placeholder="ID" type="text" igroup-size="sm" value="{{$data->detailbiaya->id_det_biaya}}" required readonly />
                    <x-adminlte-input-date name="tgl_biaya" label="Tanggal" placeholder="Tanggal" :config="$config" value="{{$data->detailbiaya->tgl_biaya}}" required />
                    <x-adminlte-select2 name="id_biaya" label="Jenis Biaya" required>
                        <option value="">Pilih Data</option>
                        @foreach($data->biaya as $biaya)
                        <option value="{{$biaya->id_biaya}}" @if($data->detailbiaya->id_biaya == $biaya->id_biaya) selected @endif>{{$biaya->nama_biaya}}</option>
                        @endforeach
                    </x-adminlte-select2>
                    <x-adminlte-input name="jml_biaya" label="Nominal Biaya" placeholder="Nominal Biaya" type="number" igroup-size="sm" min=1 value="{{$data->detailbiaya->jml_biaya}}" required>
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