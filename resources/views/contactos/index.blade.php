@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css" />
@endsection

@section('content')
    <br>
    <div class="row justify-content-center">
        <h2>CONTACTOS</h2>
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

    <form id="contactos" action="" method="">

        <div class="card">
            <div class="card-body">
                <table class="table table-light table-striped table-hover responsive display nowrap" id="tbContactos" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center" data-priority="12">Id</th>
                            <th class="text-center" data-priority="2">Titulo</th>
                            <th class="text-center" data-priority="1">Nombre Completo</th>
                            <th class="text-center" data-priority="4">Cargo</th>
                            <th class="text-center" data-priority="5">Área</th>
                            <th class="text-center" data-priority="6">Dependencia</th>
                            <th class="text-center" data-priority="7">Fecha Nacimiento</th>
                            <th class="text-center" data-priority="8">Teléfono Celular</th>
                            <th class="text-center" data-priority="9">Teléfono Oficina</th>
                            <th class="text-center" data-priority="10">Email Laboral</th>
                            <th class="text-center" data-priority="11">Email Personal</th>
                            <th class="text-center" data-priority="3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="12"> </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </form>

    <div class="modal fade" id="VerContacto" tabindex="-1" role="dialog" aria-labelledby="VerContactoLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="VerContactoLabel">Ver datos del Contacto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3">
                            {{-- foto --}}
                            <img src="" id="foto" name="foto" alt="Fotografia" class="img-fluid mb-3">
                        </div>
                        <div class="col-md-9">
                            {{-- titulo, nombre --}}
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="lblTitulo">{{ __('Titulo') }}</span>
                                        <input id="Titulo" name="Titulo" type="text" class="form-control" readonly
                                            onkeyup="mayusculas(this);" aria-label="Titulo" aria-describedby="lblTitulo">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="lblNombre">{{ __('Name') }}</span>
                                        <input id="name" name="name" type="text" class="form-control"
                                            onkeyup="mayusculas(this);" readonly aria-label="Nombre del usuario"
                                            aria-describedby="lblNombre">
                                    </div>
                                </div>
                            </div>

                            {{-- cumpleaños, telefono celular, correo personal --}}
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"
                                            id="lblFechaNacimiento">{{ __('Fecha Nacimiento') }}</span>
                                        <input id="FechaNacimiento" name="FechaNacimiento" type="text"
                                            class="form-control" onkeyup="mayusculas(this);" readonly
                                            aria-label="Fecha Nacimiento" aria-describedby="lblFechaNacimiento">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"
                                            id="lblTelefonoCelular">{{ __('Telefono Celular') }}</span>
                                        <input id="TelefonoCelular" name="TelefonoCelular" type="text"
                                            class="form-control" onkeyup="mayusculas(this);" readonly
                                            aria-label="Telefono Celular" aria-describedby="lblTelefonoCelular">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"
                                            id="lblEmailPersonal">{{ __('Email Personal') }}</span>
                                        <input id="EmailPersonal" name="EmailPersonal" type="text" class="form-control"
                                            onkeyup="mayusculas(this);" readonly aria-label="Email Personal"
                                            aria-describedby="lblEmailPersonal">
                                    </div>
                                </div>
                            </div>

                            {{-- sector, categoria --}}
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="lblSector">{{ __('Sector') }}</span>
                                        <input id="Sector" name="Sector" type="text" class="form-control"
                                            onkeyup="mayusculas(this);" readonly aria-label="Sector"
                                            aria-describedby="lblSector">
                                    </div>
                                </div>

                                <div class="col-md-7">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="lblCategoria">{{ __('Categoría') }}</span>
                                        <input id="Categoria" name="Categoria" type="text" class="form-control"
                                            onkeyup="mayusculas(this);" readonly aria-label="Categoría"
                                            aria-describedby="lblCategoria">
                                    </div>
                                </div>
                            </div>

                            {{-- area, dependencia --}}
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="lblArea">{{ __('Área') }}</span>
                                        <input id="Area" name="Area" type="text" class="form-control"
                                            onkeyup="mayusculas(this);" readonly aria-label="Área"
                                            aria-describedby="lblArea">
                                    </div>
                                </div>

                                <div class="col-md-7">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="lblDependencia">{{ __('Dependencia') }}</span>
                                        <input id="Dependencia" name="Dependencia" type="text" class="form-control"
                                            onkeyup="mayusculas(this);" readonly aria-label="Dependencia"
                                            aria-describedby="lblDependencia">
                                    </div>
                                </div>
                            </div>

                            {{-- domicilio --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="lblDomicilio">{{ __('Domicilio') }}</span>
                                        <input id="Domicilio" name="Domicilio" type="text" class="form-control"
                                            onkeyup="mayusculas(this);" readonly aria-label="Domicilio"
                                            aria-describedby="lblDomicilio">
                                    </div>
                                </div>
                            </div>

                            {{-- estado, municipio, localidad --}}
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="lblEstado">{{ __('Estado') }}</span>
                                        <input id="Estado" name="Estado" type="text" class="form-control"
                                            onkeyup="mayusculas(this);" readonly aria-label="Estado"
                                            aria-describedby="lblEstado">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="lblMunicipio">{{ __('Municipio') }}</span>
                                        <input id="Municipio" name="Municipio" type="text" class="form-control"
                                            onkeyup="mayusculas(this);" readonly aria-label="Municipio"
                                            aria-describedby="lblMunicipio">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="lblLocalidad">{{ __('Localidad') }}</span>
                                        <input id="Localidad" name="Localidad" type="text" class="form-control"
                                            onkeyup="mayusculas(this);" readonly aria-label="Localidad"
                                            aria-describedby="lblLocalidad">
                                    </div>
                                </div>
                            </div>

                            {{-- status --}}
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="lblEstatus">{{ __('Estatus') }}</span>
                                        <input id="status" name="status" type="text" class="form-control"
                                            onkeyup="mayusculas(this);" readonly aria-label="Estatus"
                                            aria-describedby="lblEstatus">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" data-btn="cnl"><i
                            class="fa fa-times-circle fa-lg mr-1"></i> Cerrar</button>
                    @if (Auth::user()->permiso == '0')
                        <div class="btn-group mr-2" role="group">
                            <a href="" id="editar" name="editar" class="btn btn-primary"><i
                                    class="fa fa-edit fa-lg mr-1"></i> Editar</a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    {{-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {

            //borrar contacto
            @if (Auth::user()->permiso == '0')
                $(document).on('click', '.btndelete', function(e) {
                    e.preventDefault();
                    var id = $(this).data('id');
                    var csrf = '{{ csrf_token() }}';

                    Swal.fire({
                        title: '¿Estás seguro de querer eliminar el contacto?',
                        text: "¡No se podrá revertir!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '¡Si, eliminar!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ route('Queries.EliminaContacto') }}",
                                method: 'delete',
                                data: {
                                    id: id,
                                    _token: csrf
                                },
                                success: function(response) {
                                    console.log(response);
                                    //regresa del borrado
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'El contacto ha sido eliminada',
                                        showConfirmButton: false,
                                        timer: 5000
                                    })

                                    window.location.reload();
                                },
                                error: function(XMLHttpRequest, textStatus, errorThrown) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: '¡Ha ocurrido un error al intentar eliminar el contacto!',
                                        footer: '<p> Status:' + textStatus +
                                            '</p><br><p> Error: ' +
                                            errorThrown +
                                            '</p>'
                                    })
                                }
                            });
                        }
                    })
                });
            @endif


            //Cambiar status
            @if (Auth::user()->permiso == '0')
                $(document).on('click', '.btnstatus', function(e) {
                    e.preventDefault();
                    var id = $(this).data('id');
                    var csrf = '{{ csrf_token() }}';

                    Swal.fire({
                        title: '¿Estás seguro de querer cambiar el estatus de este contacto?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '¡Confirmar!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ route('Queries.StatusContacto') }}",
                                method: 'POST',
                                data: {
                                    id: id,
                                    _token: csrf
                                },
                                success: function(response) {
                                    console.log(response);
                                    //regresa del borrado
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'El estatus del contacto ha sido actualizado',
                                        showConfirmButton: false,
                                        timer: 5000
                                    })

                                    window.location.reload();
                                },
                                error: function(XMLHttpRequest, textStatus, errorThrown) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: '¡Ha ocurrido un error al intentar actualizar el estatus del contacto!',
                                        footer: '<p> Status:' + textStatus +
                                            '</p><br><p> Error: ' +
                                            errorThrown +
                                            '</p>'
                                    })
                                }
                            });
                        }
                    })
                });
            @endif

            //*** MODAL ***//

            $(document).on('click', '.btnVer', function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var id = $(this).data('id');
                console.log(id);
                // ajax
                $.ajax({
                    type: "POST",
                    url: "{{ url('verContacto') }}",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(res) {
                        $("#VerContacto").modal('show');
                        $('#foto').attr('src', 'storage/' + res.foto);
                        $('#Titulo').val(res.titulo);
                        $('#name').val(res.nombre_completo);
                        $('#FechaNacimiento').val(res.fecha_nacimiento);
                        $('#TelefonoCelular').val(res.telefono_celular);
                        $('#EmailPersonal').val(res.email_personal);
                        $('#Sector').val(res.Sector);
                        $('#Categoria').val(res.Categoria);
                        $('#Area').val(res.area);
                        $('#Dependencia').val(res.dependencia);
                        $('#Domicilio').val(res.domicilio_laboral);
                        $('#Estado').val(res.Estado);
                        $('#Municipio').val(res.Municipio);
                        $('#Localidad').val(res.Localidad);
                        $('#status').val(res.status);
                        $('#editar').attr('href', '/contactos/editar/' + res.id);
                    }
                });
            });


            //*** DATATABLE***///

            $('#tbContactos').DataTable({
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
                                window.location.href = "{!! route('Contactos.Nuevo') !!}"
                            }

                        },
                    @endif {
                        extend: 'excel',
                        footer: true,
                        text: '<a><i class="fa fa-file-excel"></i> Exportar a Excel </a>',
                        title: '',
                        filename: 'Reporte de Contactos',
                    },

                ],
                processing: true,
                serverSide: true,
                responsive: true,
                aaSorting: [
                    [0, "desc"]
                ],
                ajax: "{{ route('Contactos.Index') }}",
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'titulo'
                    },
                    {
                        data: 'nombre_completo'
                    },
                    {
                        data: 'cargo'
                    },
                    {
                        data: 'area'
                    },
                    {
                        data: 'dependencia'
                    },
                    {
                        data: 'fecha_nacimiento'
                    },
                    {
                        data: 'telefono_celular'
                    },
                    {
                        data: 'telefono_oficina'
                    },
                    {
                        data: 'email_laboral'
                    },
                    {
                        data: 'email_personal'
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
