@extends('adminlte::page')
@section('title', 'Aliran-Kas Sumber Rejeki')
@section('content_header')
@stop
@section('content')
	<h1 class="h3 mb-3"><strong>Dashboard</strong></h1>
  <div class="block-content">
    <h2 class="block-title" style="font-size: 2rem; font">Aplikasi Aliran Kas pada Toko Sumber Rejeki</h2>
  </div>
  <main class="main-content position-relative border-radius-lg ">
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body bg-primary p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Penjualan</p>
                    <h5 class="font-weight-bolder">@rp($data->penjualan)
                    </h5>
                    <p class="mb-0">
                      <span class="text-success text-sm font-weight-bolder"></span>
                      Barang terjual
                    </p>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape shadow-primary text-center rounded-circle">
                    <i class="fas fa-shopping-cart text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body bg-warning p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold text-white">Pembelian</p>
                    <h5 class="font-weight-bolder text-white">
                    @rp($data->pembelian)
                    </h5>
                    <p class="mb-0 text-white">
                      <span class="text-success text-sm font-weight-bolder text-white"></span>
                      Barang Terbeli
                    </p>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape shadow-danger text-center rounded-circle">
                    <i class="fas fa-truck text-lg opacity-10 text-white" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body bg-success p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Kas Masuk</p>
                    <h5 class="font-weight-bolder">
                    @rp($data->total)
                    </h5>
                    <p class="mb-0">
                      <span class="text-danger text-sm font-weight-bolder"></span>
                      Jumlah Kas Masuk
                    </p>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape shadow-success text-center rounded-circle">
                    <i class="fas fa-money-bill-alt text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body bg-danger p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Kas Keluar</p>
                    <h5 class="font-weight-bolder">
                    @rp($data->total1)
                    </h5>
                    <p class="mb-0">
                      <span class="text-success text-sm font-weight-bolder"></span> Jumlah Kas Keluar
                    </p>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape shadow-warning text-center rounded-circle">
                    <i class="fas fa-money-bill-alt text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@stop

@section('css')
    
@stop

@section('js')
@stop

@section('footer')
    <footer id="page-footer" class="opacity-0">
    <div class="content py-20 font-size-sm clearfix">
        <div class="float-right">
            Created <i class="fa fa-heart text-pulse"></i> by <a class="font-w600" href="javascript:void(0)" target="_blank"> Erwi Rejeki</a>
        </div>
        <div class="float-left">
            <a class="font-w600" href="javascript:void(0)" >SIA - FTI - UTDI</a> &copy; 2022<span class="js-year-copy"></span>
        </div>
    </div>
</footer>
@stop