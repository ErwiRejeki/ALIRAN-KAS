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
        var saldo = @php echo(Session::get('saldo'));@endphp;
        function getharga(sel, param) {
            let harga = $("#id_barang option:selected").attr('harga');
            if (param == 'detail_beli') {
                $("#harga_beli").val(harga);
                let max = parseInt((saldo - total) / harga);
                // document.getElementById('jml_beli').max = max;
            }else if(param == 'detail_jual'){
                $("#harga_jual").val(harga);
                let max = $("#id_barang option:selected").attr('stok');
                let harga_beli = $("#id_barang option:selected").attr('harga_beli');
                document.getElementById('jml_jual').max = max;
                document.getElementById('harga_jual').min = harga_beli;
            }
        }
        function enableHarga(){
            let jml = document.getElementById('jml_jual').value;
            console.log('jml', jml)
            if(jml > 10) {
                $("#harga_jual").attr('readonly', false);
            }else{
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
    </script>
    @yield('js')
@stop
