@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css" />
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
                <table class="table table-light table-striped table-hover" id="tbContactos">
                    <thead class="table-dark">
                        <tr>
                            <th>Id</th>
                            <th>Titulo</th>
                            <th>Nombre Completo</th>
                            <th>Cargo</th>
                            <th>Área</th>
                            <th>Dependencia</th>
                            <th>Fecha Nacimiento</th>
                            <th>Teléfono Celular</th>
                            <th>Teléfono Oficina</th>
                            <th>Email Laboral</th>
                            <th>Email Personal</th>
                            <th>Acciones</th>
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
                    <h5 class="modal-title" id="VerContactoLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 foto">
                            {{-- foto --}}
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-4">

                                    
                                </div>
                                <div class="col-md-8">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="lblNombre">{{ __('Name') }}</span>
                                        <input id="name" type="text" class="form-control name="name"
                                            onkeyup="mayusculas(this);" readonly aria-label="Nombre del usuario"
                                            aria-describedby="lblNombre">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" data-btn="cnl">Cerrar</button>
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).on('click', '.btn-edit-plan', function() {
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
                    {{ url('images/profile/') }}
                    var htmlfoto = '<img src="'{{ asset('res.foto') }}'" id="foto" name="foto" alt="Fotografia" class="img-thumbnail">';
                    $("#VerContacto .foto").html(htmlfoto);
                    //$('#foto').html('<img src="' + res.foto + '" alt="" class="responsive-img" style="height: 132px; width: 132px;">');
                   // $('#foto').url(res.foto);
                    $('#name').val(res.nombre_completo);
                }
            });
        });



        $(document).ready(function() {

            //*** MODAL ***//
            // $(document).on('click', '.btnshow', function() {

            //                 $("#ModalVer .modal-title").html('Ver Contacto');
            //                 $("#ModalVer .modal-dialog").addClass('modal-lg');


            //                 $("#ModalVer").modal('show');
            //             });



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
