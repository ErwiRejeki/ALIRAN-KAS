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
                    <x-adminlte-input name="jabatan" label="jabatan" placeholder="jabatan" type="text" igroup-size="sm" value="{{$data->user->jabatan}}" required />
                    <x-adminlte-input name="email" label="Email" placeholder="Email" type="text" igroup-size="sm" value="{{$data->user->email}}" required />
                    <x-adminlte-input name="password" label="Password" placeholder="Password" type="text" igroup-size="sm" value="{{$data->user->password}}" required />

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