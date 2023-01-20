@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <br>
    <div class="row justify-content-center">
        <h2>USUARIOS</h2>
    </div>
    
    <br>
    <form id="usuarios" action="" method="">

        <div class="card">

            <div class="card-body">

                <table class="table table-light table-striped table-hover" id="tbUsuarios">
                    <thead class="table-dark">
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Permiso</th>
                            <th>Estatus</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuarios as $usuario)
                            <tr>
                                <td>{{ $usuario->id }}</td>
                                <td>{{ $usuario->name }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td>{{ $usuario->permiso == 0?'Administrador':'Consulta'}}</td>
                                <td>{{ $usuario->status == 1?'Activo':'Inactivo'}}</td>
                                <td class="text-center">
                                    <a href="{{ route('Usuarios.Editar', $usuario->id) }}" data-toggle="tooltip" title="Editar"> <i
                                            class="fas fa-edit fa-lg"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="6"> </th>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>




    </form>
@endsection


@section('js')
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
@endsection

@section('script')
    <script>
        //solicituds de entrega

        $(document).ready(function() {
            $('#tbUsuarios2').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-MX.json'
                },
                aaSorting: [],
                dom: "<'row'<'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                buttons: [
                    @if (Auth::user()->permiso == '0')
                {
                        footer: true,
                        text: '<a class="btn btn-success" ><i class="fa fa-plus-circle fa-lg"></i> Nuevo</a>',
                        title: '',
                        action: function(e, dt, button, config) {
                            window.location.href = "{!! route('Usuarios.Nuevo') !!}"
                        },
                        className: 'btn_personalizado'

                    },
                    @endif
                    {
                        extend: 'excel',
                        footer: true,
                        text: '<button class="btn btn-success">Exportar a Excel <i class="fa fa-file-excel"></i></button>',
                        title: '',
                        filename: 'Reporte de Usuarios',
                    }

                ],
            });
        });

        function confirmSubmit() {
            var agree = confirm("¿ Desea borrar esta solicitud ?");
            if (agree)
                document.forms["formBorrar"].submit();
            else
                return false;
        }
    </script>

<script>


$(document).ready(function() {
    $('#tbUsuarios').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-MX.json'
        },
        dom: "<'row'<'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        responsive: true,
        ajax: {"{{ route('Usuarios.Index')}}",
        type: 'POST'
    }
        columns: [
            {
                data: 'id'
            },
            {
                data: 'name'
            },
            {
                data: 'email'
            },
            {
                data: 'permiso'
            },
            {
                data: 'status'
            }
        ],
        buttons: [
        {
            extend: 'excel',
                    footer: true,
                    text: 'Exportar a Excel',
                    title: '',
                    filename: 'Reporte de Usuarios ',
        }
    ]
    });
});
</script>

@endsection