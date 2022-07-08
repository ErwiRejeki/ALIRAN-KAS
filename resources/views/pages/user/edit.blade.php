@extends('adminlte::page')

@section('content_header')
<h4>Edit Users</h4>
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
                    <h3 class="ml-3">Form Users</h3>
                </div>

            </div>
            <div class="card-body">
                <form method="POST" action="{{route('user.update', [$data->user->id])}}">
                    @method('PUT')
                    @csrf
                    <x-adminlte-input name="id" label="id" placeholder="ID" type="text" igroup-size="sm" value="{{$data->user->id}}" required readonly />
                    <x-adminlte-input name="name" label="Nama Users" placeholder="Nama Users" type="text" igroup-size="sm" value="{{$data->user->name}}" required />
                    <x-adminlte-select2 name="jabatan" label="Jabatan" required>
                        <option value="">Pilih Data</option>
                        <option value="administrator" @if($data->user->jabatan == "administrator") selected @endif>Administrator</option>
                        <option value="kasir" @if($data->user->jabatan == "kasir") selected @endif>Kasir </option>
                        <option value="pembelian" @if($data->user->jabatan == "pembelian") selected @endif>Pembelian </option>
                        <option value="pemilik" @if($data->user->jabatan == "pemilik") selected @endif>Pemilik</option>
                    </x-adminlte-select2>
                    <x-adminlte-input name="email" label="Email" placeholder="Email" type="text" igroup-size="sm" value="{{$data->user->email}}" required />
                    <x-adminlte-input name="password" label="Password *Mengisi berarti mengubah password" placeholder="Password" type="text" igroup-size="sm" />

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