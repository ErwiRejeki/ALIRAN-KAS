@extends('adminlte::page')

@section('content_header')
<h4>Daftar Users</h4>
@stop

@section('content')
@if ($message = Session::get('success'))
<x-adminlte-alert theme="success" title="Success">
    {{ $message }}
</x-adminlte-alert>
@endif
@if ($message = Session::get('error'))
<x-adminlte-alert theme="danger" title="Danger">
    {{ $message }}
</x-adminlte-alert>
@endif
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <a href="user/create" class="btn btn-primary btn-sm shadow">
                    <i class="fa fa-plus"></i>
                    Tambah Users
                </a>
            </div>
            <div class="card-body">
                <x-adminlte-datatable id="table2" :heads="$data->heads" head-theme="dark" :config="$data->config" striped hoverable bordered compressed />
            </div>
        </div>
    </div>
</div>


@stop

@section('css')

@stop

@section('js')

@stop