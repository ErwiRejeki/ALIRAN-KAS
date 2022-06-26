@extends('adminlte::master')

@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

@section('adminlte_css')
@stack('css')
@yield('css')
@stop

@section('classes_body', $layoutHelper->makeBodyClasses())

@section('body_data', $layoutHelper->makeBodyData())

@section('body')
<div class="wrapper">

    {{-- Top Navbar --}}
    @if($layoutHelper->isLayoutTopnavEnabled())
    @include('adminlte::partials.navbar.navbar-layout-topnav')
    @else
    @include('adminlte::partials.navbar.navbar')
    @endif

    {{-- Left Main Sidebar --}}
    @if(!$layoutHelper->isLayoutTopnavEnabled())
    @include('adminlte::partials.sidebar.left-sidebar')
    @endif

    {{-- Content Wrapper --}}
    @empty($iFrameEnabled)
    @include('adminlte::partials.cwrapper.cwrapper-default')
    @else
    @include('adminlte::partials.cwrapper.cwrapper-iframe')
    @endempty

    {{-- Footer --}}
    @hasSection('footer')
    @include('adminlte::partials.footer.footer')
    @endif

    {{-- Right Control Sidebar --}}
    @if(config('adminlte.right_sidebar'))
    @include('adminlte::partials.sidebar.right-sidebar')
    @endif
    <div class="modal fade" id="modal-alert-saldo" tabindex="-1" role="dialog" aria-labelledby="modal-alert-saldo" aria-hidden="true">
        <div class="modal-dialog modal-dialog-alert-saldo" role="document">
            <div class="modal-content">
                <div class="card card-primary block-transparent mb-0">
                    <div class="card-header bg-warning">
                        <h3 class="block-title">Saldo Tidak Cukup</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-12">
                                <h4 class="text-warning"><span class="glyphicon glyphicon-lock"></span> Saldo Anda Tidak Cukup</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="closemodal()" data-dismiss="modal">Close</button>
                    <button data-dismiss="modal" data-toggle="modal" data-target="#modal-saldo" class="btn btn-info">
                        <i class="fa fa-plus"></i> Tambah Saldo
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-saldo" tabindex="-1" role="dialog" aria-labelledby="modal-saldo" aria-hidden="true">
            <div class="modal-dialog modal-dialog-saldo" role="document">
                <div class="modal-content">
                    <form action="{{ route('saldo.store') }}" method="post"> @csrf
                        <div class="card card-primary block-transparent mb-0">
                            <div class="card-header bg-primary">
                                <h3 class="block-title">Tambah Saldo</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-12">
                                        <div class="form-material">
                                            <label for="saldo">Saldo</label>
                                            <input type="number" min="0" class="form-control" id="saldo" name="saldo">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" onclick="closemodal()" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-check"></i> Simpan Saldo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>
@stop

@section('adminlte_js')
@stack('js')
<script>
    $('#table_custome').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json"
        }
    });
    var saldo = @php echo(Session::get('saldo'));
    @endphp;

    function getharga(sel, param) {
        let harga = $("#id_barang option:selected").attr('harga');
        if (param == 'detail_beli') {
            $("#harga_beli").val(harga);
            let max = parseInt((saldo - total) / harga);
            // document.getElementById('jml_beli').max = max;
        } else if (param == 'detail_jual') {
            $("#harga_jual").val(harga);
            let max = $("#id_barang option:selected").attr('stok');
            let harga_beli = $("#id_barang option:selected").attr('harga_beli');
            document.getElementById('jml_jual').max = max;
            document.getElementById('harga_jual').min = harga_beli;
        }
    }

    function enableHarga() {
        let jml = document.getElementById('jml_jual').value;
        console.log('jml', jml)
        if (jml > 10) {
            $("#harga_jual").attr('readonly', false);
        } else {
            $("#harga_jual").attr('readonly', true);
        }

    }

    function deleteData(id, url) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url,
                    type: 'DELETE',
                    data: {
                        "id": id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(result) {
                        Swal.fire(
                            'Deleted!',
                            'Your data has been deleted.',
                            'success'
                        ).then((result) => {
                            location.reload();
                        })
                    },
                    error: function(err) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!'
                        }).then((result) => {
                            location.reload();
                        })
                    }
                });
            }
        })
    }

    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
@yield('js')
@stop