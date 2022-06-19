@extends('adminlte::page')

@section('content')
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header bg-gd-primary">
                <h3 class="block-title" style="font-size: 2rem;">
                    Daftar Penjualan 
                    <a  href="" class="btn btn-success">
                        <i class="fa fa-plus "></i> Tambah Penjualan
                    </a>
                    
                </h3>
            </div>
            <div class="block-content">
                <!-- Orders Table -->
                <div class="table-responsive">
                    <table class="table table-borderless table-striped js-dataTable-full-pagination">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 10%;">#</th>
                            <th>No Faktur</th>
                            <th>Tanggal</th>
                            <th class="text-right">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center font-w600 text-secondary text-uppercase">
                                   1
                                </td>
                                <td class="text-center font-w600 text-secondary text-uppercase">
                                   1
                                </td>
                                <td class="font-w600 text-primary text-uppercase">
                                   30 Juni 2022
                                </td>
                                <td class="text-right font-w600 text-secondary ">
                                    Rp. 100000000
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- END Orders Table -->

            </div>
        </div>
    </div>
@endsection
