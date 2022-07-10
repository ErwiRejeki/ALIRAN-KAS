@extends('adminlte::page')
@section('title', 'Aliran-Kas Sumber Rejeki')
@section('content_header')
@stop
@section('content')
    <main class="content">
				<div class="container-fluid p-0">
					<h1 class="h3 mb-3"><strong>Dashboard</strong></h1>
					<hr>
					<div class="row">
						<div class="col-xl-6 col-xxl-5 d-flex">
							<div class="w-100">
								<div class="row">
									<div class="col-sm-6">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">Penjualan</h5>
													</div>

													<div class="col-auto primary">
														<div class="stat text-primary">
															<i class="fas fa-shopping-cart" data-feather="truck"></i>
														</div>
													</div>
												</div>
												<h1 class="mt-1 mb-3"><div class="count">{{$countPenjualan}}</div></h1>
												<div class="mb-0">
													<span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> -3.65% </span>
													<span class="text-muted">Since last week</span>
												</div>
											</div>
										</div>
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">Kas Masuk</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="fas fa-money-bill-alt" data-feather="users"></i>
														</div>
													</div>
												</div>
												<h1 class="mt-1 mb-3">14.212</h1>
												<div class="mb-0">
													<span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i> 5.25% </span>
													<span class="text-muted">Since last week</span>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">Pembelian</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="fas fa-truck" data-feather="truck"></i>
														</div>
													</div>
												</div>
												<h1 class="mt-1 mb-3"><div class="count">{{$countPembelian}}</div></h1>
												<div class="mb-0">
													<span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i> 6.65% </span>
													<span class="text-muted">Since last week</span>
												</div>
											</div>
										</div>
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">Kas Keluar</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="fas fa-money-bill-alt" data-feather="shopping-cart"></i>
														</div>
													</div>
												</div>
												<h1 class="mt-1 mb-3">64</h1>
												<div class="mb-0">
													<span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> -2.25% </span>
													<span class="text-muted">Since last week</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-xl-6 col-xxl-7">
							<div class="card flex-fill w-100">
								<div class="card-header">
									<h5 class="card-title mb-0">Grafik Penjualan</h5>
								</div>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<div style="padding: 15px;">
										<canvas id="myChart" width="100%"></canvas>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</main>
@stop

@section('css')
    
@stop

@section('js')
<script>
	const ctx = document.getElementById('myChart').getContext('2d');
	const labels = [];
	const data = [];
	const penjualangraph = {!! json_encode($penjualangraph) !!};

	penjualangraph.forEach(r => {
		const { name, penjualan } = r;
		labels.push(name);
		data.push(penjualan);
	});
	const myChart = new Chart(ctx, {
		type: 'bar',
		data: {
			labels,
			datasets: [{
				label: 'Total Penjualan',
				backgroundColor: 'rgb(255, 99, 132)',
				data,
			}]
		},
		options: {
			scales: {
				y: {
					beginAtZero: true
				}
			}
		}
	});
	</script>
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