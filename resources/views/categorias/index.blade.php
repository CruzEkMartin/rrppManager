@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css" />
@endsection

@section('content')
    <br>
    <div class="row justify-content-center">
        <h2>CATEGORÍAS</h2>
    </div>

    <br>

    @if (session('scssmsg'))
        <script>
            Swal.fire(
                'Guardado!',
                '{{ session('scssmsg') }}',
                'success'
            )
        </script>
    @endif

    <form id="categorias" action="" method="">

        <div class="card">
            <div class="card-body">
                <table class="table table-light table-striped table-hover" id="tbCategorias">
                    <thead class="table-dark">
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Sector</th>
                            <th>Estatus</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4"> </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </form>
@endsection

@section('js')
    {{-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#tbCategorias').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-MX.json'
                },
                dom: "<'row'<'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                buttons: [
                    @if (Auth::user()->permiso == '0')
                        {
                            footer: true,
                            text: '<a><i class="fa fa-plus-circle fa-lg"></i> Nuevo</a>',
                            title: '',
                            action: function(e, dt, button, config) {
                                window.location.href = "{!! route('Categorias.Nuevo') !!}"
                            }

                        },
                    @endif {
                        extend: 'excel',
                        footer: true,
                        text: '<a><i class="fa fa-file-excel"></i> Exportar a Excel </a>',
                        title: '',
                        filename: 'Reporte de Categorias',
                    },

                ],
                processing: true,
                serverSide: true,
                aaSorting: [
                    [0, "desc"]
                ],
                ajax: "{{ route('Categorias.Index') }}",
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'sector'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    </script>
@endsection
