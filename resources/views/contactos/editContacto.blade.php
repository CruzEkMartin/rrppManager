@extends('layouts.app')

@section('content')
    <br><br>

    @if (Auth::check() && Auth::user()->permiso == 0)
        <form action="{{ route('Contactos.Update', $contacto->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')

            @if (session('errormsg'))
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: '{{ session('errormsg') }}'
                    })
                </script>
                </div>
            @endif

            <div class="card">
                <h4 class="card-header">Editar Contacto</h4>
                <div class="card-body">
                    <br>
                    <div class="row">
                        {{-- foto --}}
                        <div class="col-md-3">
                            <div class="row">
                                <picture class="align-self-center">
                                    <img src="{{ asset('/storage/' . $contacto->foto) }}" id="foto" name="foto"
                                        alt="Fotografia" class="img-fluid img-thumbnail mx-auto d-block mb-3 w-75">
                                </picture>
                            </div>
                            <div class="row justify-content-around align-items-center">
                                @if ($contacto->foto)
                                    <div class=" mb-3">
                                        <a href="{{ asset('/storage/' . $contacto->foto) }}" class="link-info"
                                            target="_blank">Ver fotografía del contacto</a>
                                    </div>
                                    <div class="mb-3">
                                        <button data-name="fotoFile" data-id="{{ $contacto->id }}" data-toggle="tooltip"
                                            data-placement="top" title="Eliminar fotografía"
                                            class="btn btn-danger btndelFoto" type="button" aria-pressed="true"><span
                                                style="font-size: 1.2em; color: white;"
                                                class="fa fa-trash-alt"></span></button>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- datos --}}
                        <div class="col-md-9">
                            {{-- sector, categoria --}}
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="lblSector">{{ __('Sector') }}</span>
                                        <select id="ddlSector" name="ddlSector" aria-describedby="lblsector"
                                            class="form-control" required autofocus>
                                            <option value="" selected>Seleccione una opción</option>
                                            @if ($sectores)
                                                @foreach ($sectores as $sector)
                                                    @if ($sector->id == $contacto->idSector)
                                                        <option selected value="{{ $sector->id }}">{{ $sector->name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $sector->id }}">{{ $sector->name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>

                                        @error('ddlSector')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="lblCategoria">{{ __('Categoría') }}</span>
                                        <select id="ddlCategoria" name="ddlCategoria" aria-describedby="lblCategoria"
                                            class="form-control" required autofocus>
                                            <option value="" selected>Seleccione una opción</option>
                                            @if ($categorias)
                                                @foreach ($categorias as $categoria)
                                                    @if ($categoria->id == $contacto->idCategoria)
                                                        <option selected value="{{ $categoria->id }}">{{ $categoria->name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $categoria->id }}">{{ $categoria->name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>

                                        @error('ddlCategoria')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- nombre --}}
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="lblNombre">{{ __('Name') }}</span>
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ $contacto->nombre }}" required autocomplete="name" autofocus
                                            onkeyup="mayusculas(this);" aria-label="Nombre del usuario"
                                            aria-describedby="lblNombre">

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"
                                            id="lblApellidoPaterno">{{ __('Apellido Paterno') }}</span>
                                        <input id="ApellidoPaterno" type="text"
                                            class="form-control @error('ApellidoPaterno') is-invalid @enderror"
                                            name="ApellidoPaterno" value="{{ $contacto->apellido_paterno }}" required
                                            autocomplete="ApellidoPaterno" autofocus onkeyup="mayusculas(this);"
                                            aria-label="Apellido Paterno" aria-describedby="lblApellidoPaterno">

                                        @error('ApellidoPaterno')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"
                                            id="lblApellidoMaterno">{{ __('Apellido Materno') }}</span>
                                        <input id="ApellidoMaterno" type="text"
                                            class="form-control @error('ApellidoMaterno') is-invalid @enderror"
                                            name="ApellidoMaterno" value="{{ $contacto->apellido_materno }}" required
                                            autocomplete="ApellidoMaterno" autofocus onkeyup="mayusculas(this);"
                                            aria-label="Apellido Materno" aria-describedby="lblApellidoMaterno">

                                        @error('ApellidoMaterno')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                </div>
                            </div>

                            {{-- sexo, titulo, nacimiento --}}
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="lblSexo">{{ __('Sexo') }}</span>
                                        <select id="ddlSexo" class="form-control" name="ddlSexo" required>
                                            <option value="" selected>
                                                <-- Seleccione -->
                                            </option>
                                            <option value="1" {{ $contacto->genero == 1 ? 'selected' : '' }}>
                                                MASCULINO
                                            </option>
                                            <option value="2" {{ $contacto->genero == 2 ? 'selected' : '' }}>FEMENINO
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="lblTitulo">{{ __('Titulo') }}</span>
                                        <input id="Titulo" type="text"
                                            class="form-control @error('Titulo') is-invalid @enderror" name="Titulo"
                                            value="{{ $contacto->titulo }}" required autocomplete="Titulo" autofocus
                                            onkeyup="mayusculas(this);" aria-label="Titulo" aria-describedby="lblTitulo">

                                        @error('Titulo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="fecha_nac">Fecha de Nacimiento</label>
                                        </div>
                                        <input type="date" id="fecha_nac" name="fecha_nac" placeholder="dd/mm/aaaa"
                                            value="{{ $contacto->fecha_nacimiento }}"
                                            class="form-control @error('fecha_nac') is-invalid @enderror" required />

                                        @error('fecha_nac')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            {{-- dependencia, cargo, area --}}
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"
                                            id="lblDependencia">{{ __('Dependencia / Empresa') }}</span>
                                        <input id="Dependencia" type="text"
                                            class="form-control @error('Dependencia') is-invalid @enderror"
                                            name="Dependencia" value="{{ $contacto->dependencia }}" required
                                            autocomplete="Dependencia" autofocus onkeyup="mayusculas(this);"
                                            aria-label="Dependencia" aria-describedby="lblDependencia">

                                        @error('Dependencia')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="lblCargo">{{ __('Cargo') }}</span>
                                        <input id="Cargo" type="text"
                                            class="form-control @error('Cargo') is-invalid @enderror" name="Cargo"
                                            value="{{ $contacto->cargo }}" required autocomplete="Cargo" autofocus
                                            onkeyup="mayusculas(this);" aria-label="Cargo" aria-describedby="lblCargo">

                                        @error('Cargo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="lblArea">{{ __('Área') }}</span>
                                        <input id="Area" type="text"
                                            class="form-control @error('Area') is-invalid @enderror" name="Area"
                                            value="{{ $contacto->area }}" required autocomplete="Area" autofocus
                                            onkeyup="mayusculas(this);" aria-label="Area" aria-describedby="lblArea">

                                        @error('Area')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                </div>

                            </div>

                            {{-- domicilio, cp --}}
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"
                                            id="lblDomicilio">{{ __('Domicilio Laboral') }}</span>
                                        <input id="Domicilio" type="text"
                                            class="form-control @error('Domicilio') is-invalid @enderror" name="Domicilio"
                                            value="{{ $contacto->domicilio_laboral }}" required autocomplete="Domicilio"
                                            autofocus onkeyup="mayusculas(this);" aria-label="Domicilio"
                                            aria-describedby="lblDomicilio">

                                        @error('Domicilio')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="lblCP">{{ __('Código Postal') }}</span>
                                        <input type="number" id="CodPostal" name="CodPostal" maxlength="5"
                                            value="{{ $contacto->codigo_postal }}"
                                            class="form-control @error('CodPostal') is-invalid @enderror"
                                            aria-label="Código Postal" aria-describedby="lblCP" required
                                            autocomplete="CodPostal" autofocus>

                                        @error('CodPostal')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            {{--  estado, municipio, localidad --}}
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="lblEstado">{{ __('Estado') }}</span>
                                        <select id="ddlEstado" name="ddlEstado" aria-describedby="lblEstado"
                                            class="form-control" required>
                                            <option value="" selected>Seleccione una opción</option>
                                            @if ($estados)
                                                @foreach ($estados as $estado)
                                                    @if ($estado->cve_ent == $contacto->cve_ent)
                                                        <option selected value="{{ $estado->cve_ent }}">
                                                            {{ $estado->nom_ent }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $estado->cve_ent }}">{{ $estado->nom_ent }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="input-group mb-3 ">
                                        <span class="input-group-text" id="lblMunicipio">{{ __('Municipio') }}</span>
                                        <select id="ddlMunicipio" class="form-control" name="ddlMunicipio" 
                                            required autofocus>
                                            <option value="" selected>Seleccione una opción</option>
                                            @if ($municipios)
                                                @foreach ($municipios as $municipio)
                                                    @if ($municipio->cve_mun == $contacto->cve_mun)
                                                        <option selected value="{{ $municipio->cve_mun }}">{{ $municipio->nom_mun }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $municipio->cve_mun }}">{{ $municipio->nom_mun }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>

                                        @error('ddlMunicipio')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                </div>

                                <div class="col-md-4">
                                    <div class="input-group mb-3 ">
                                        <span class="input-group-text" id="lblLocalidad">{{ __('Localidad') }}</span>
                                        <select id="ddlLocalidad" class="form-control" name="ddlLocalidad" 
                                            required>
                                            <option value="" selected>Seleccione una opción</option>
                                            @if ($localidades)
                                                @foreach ($localidades as $localidad)
                                                    @if ($localidad->cve_loc == $contacto->cve_loc)
                                                        <option selected value="{{ $localidad->cve_loc }}">{{ $localidad->nom_loc }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $localidad->cve_loc }}">{{ $localidad->nom_loc }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>

                                        @error('ddlCategoria')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{--  telefonos, correos --}}
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="lblCelPhone">Teléfono Celular</span>
                                        <input id="telefono_celular" type="number" maxlength="10"
                                            class="form-control @error('telefono_celular') is-invalid @enderror"
                                            name="telefono_celular" value="{{ $contacto->telefono_celular }}" required
                                            autocomplete="telefono_celular" aria-label="Teléfono Celular"
                                            aria-describedby="lblCelPhone">

                                        @error('telefono_celular')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="lblCelOffice">Teléfono Oficina</span>
                                        <input id="telefono_oficina" type="number" maxlength="10"
                                            class="form-control @error('telefono_oficina') is-invalid @enderror"
                                            name="telefono_oficina" value="{{ $contacto->telefono_oficina }}"required
                                            autocomplete="telefono_oficina" aria-label="Teléfono Oficina"
                                            aria-describedby="lblCelOffice">

                                        @error('telefono_oficina')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"
                                            id="lblEmailPersonal">{{ __('Email Personal') }}</span>
                                        <input id="email_personal" type="email"
                                            class="form-control @error('email_personal') is-invalid @enderror"
                                            name="email_personal" value="{{ $contacto->email_personal }}" required
                                            autocomplete="email_personal" aria-label="Email Personal"
                                            aria-describedby="lblEmailPersonal">

                                        @error('email_personal')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"
                                            id="lblEmailLaboral">{{ __('Email Laboral') }}</span>
                                        <input id="email_laboral" type="email"
                                            class="form-control @error('email_laboral') is-invalid @enderror"
                                            name="email_laboral" value="{{ $contacto->email_laboral }}" required
                                            autocomplete="email_laboral" aria-label="Email Laboral"
                                            aria-describedby="lblEmailLaboral">

                                        @error('email_laboral')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{--  partido, observaciones --}}
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"
                                            id="lblPartido">{{ __('Filiación Política') }}</span>
                                        <select id="ddlPartido" name="ddlPartido" aria-describedby="lblPartido"
                                            class="form-control" required>
                                            <option value="" selected>Seleccione una opción</option>
                                            @if ($partidos)
                                                @foreach ($partidos as $partido)
                                                    @if ($partido->id == $contacto->idPartido)
                                                        <option selected value="{{ $partido->id }}">{{ $partido->name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $partido->id }}">{{ $partido->name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-9">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"
                                            id="lblObservaciones">{{ __('Observaciones') }}</span>
                                        <input id="Observaciones" type="text"
                                            class="form-control @error('Observaciones') is-invalid @enderror"
                                            name="Observaciones" value="{{ $contacto->observaciones }}"
                                            autocomplete="Observaciones" autofocus onkeyup="mayusculas(this);"
                                            aria-label="Observaciones" aria-describedby="lblObservaciones">

                                        @error('Observaciones')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                </div>
                            </div>

                            {{--  fotografia --}}
                            <div class="form-row mb-3">

                                @if ($contacto->foto)
                                @else
                                    <div class="col-md-10 mb-3">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="ContactoFile"
                                                name="ContactoFile" name="ContactoFile"
                                                accept="image/png, image/jpg, image/jpeg, application/pdf" required>
                                            <label class="custom-file-label" for="ContactoFile"
                                                data-browse="Buscar Foto">Subir archivo con la fotografía del
                                                contacto</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <button data-name="ContactoFile" class="btn btn-success btncamera" type="button"
                                            aria-pressed="true"><span style="font-size: 1.2em; color: white;"
                                                class="fa fa-camera mr-2"></span>Tomar Fotografía</button>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <div class="col-md-6 col-lg-4 col-xl-3 btn-toolbar justify-content-around " role="toolbar">
                        <div class="btn-group mr-2" role="group">
                            <a href="{{ route('Contactos.Index') }}" class="btn btn-secondary"><i
                                    class="fa fa-times-circle fa-lg mr-1"></i> Cancelar</a>
                        </div>
                        <div class="btn-group mr-2" role="group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save fa-lg mr-1"></i> <strong>
                                    Guardar</strong></button>
                        </div>
                    </div>
                </div>
            </div>

        </form>

        <div class="modal fade" id="ModalFoto" tabindex="-1" role="dialog" aria-labelledby="ModalFotoLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalFotoLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            data-btn="btnCancelarFoto">Cancelar</button>
                        <button type="button" class="btn btn-success" data-btn="btnGuardarFoto">Guardar
                            fotografía</button>

                    </div>
                </div>

            </div>
        </div>

    @endif


@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
    <script src="{{ asset('js/webcam.js') }}"></script>
@endsection


@section('script')
    <script type="text/javascript">
        $(document).on('click', '.btndelFoto', function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            Swal.fire({
                title: '¿Estás seguro de querer eliminar la fotografía?',
                text: "¡No se podrá revertir!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Si, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var id = $(this).data('id');
                    $.ajax({
                        type: "POST",
                        url: "{{ url('borrarFotoContacto') }}",
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function(res) {
                            //regresa del borrado
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'La fotografía ha sido eliminada',
                                showConfirmButton: false,
                                timer: 5000
                            })
                            window.location.reload();
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: '¡Ha ocurrido un error al intentar eliminar la fotografía!',
                                footer: '<p> Status:' + textStatus +
                                    '</p><br><p> Error: ' + errorThrown + '</p>'
                            })
                        }
                    });
                }
            })
        });


        $(document).ready(function() {

            $("[name='telefono_celular'],[name='telefono_celular']").attr({
                pattern: '[1-9]{1}[0-9]{9}',
                type: 'text',
                title: '10 NUMEROS'
            }); //validacion para numero de telefono
            $("[name='telefono_oficina'],[name='telefono_oficina']").attr({
                pattern: '[1-9]{1}[0-9]{9}',
                type: 'text',
                title: '10 NUMEROS'
            }); //validacion para numero de telefono
            $("[name='CodPostal']").attr({
                pattern: '[0-9]{5}',
                type: 'text',
                title: '5 NUMEROS'
            }); //codigo postal validacion
            $("[name='curp']").attr({
                pattern: '[A-Z]{4}[0-9]{6}[HM]{1}[A-Z]{5}[A-Z0-9]{1}[0-9]{1}',
                type: 'text',
                title: 'FORMATO DE CURP VALIDA'
            }); //codigo postal validacion


            // Add the following code if you want the name of the file appear on select
            $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });

            bsCustomFileInput.init();

            $(document).on('click', '.btncamera', function() { //boton de camara
                var namedoc = $(this).data('name');
                Webcam.set({
                    width: 640,
                    height: 480,
                    image_format: 'jpeg',
                    jpeg_quality: 98
                });
                Webcam.reset('#camera');
                Webcam.set("constraints", {
                    facingMode: "environment"
                });

                $("#ModalFoto .modal-title").html('Tomar fotografía');
                $("#ModalFoto .modal-dialog").addClass('modal-lg');
                var htmlfoto = '<div id="camera" style="display:block;margin:auto;"></div>';
                htmlfoto +=
                    '<button id="take_photo" class="btn btn-primary btn-block mt-2 mb-2" type=button>Tomar fotografía</button>';
                htmlfoto += '<div id="resultPhoto"></div>';


                $("#ModalFoto .modal-body").html(htmlfoto);

                $('#ModalFoto [data-btn="btnGuardarFoto"]').attr("disabled", true);

                Webcam.attach('#camera');

                $("#take_photo").off().click(function() { //solo captura la imagen
                    Webcam.snap(function(data_uri) {
                        $('#resultPhoto').html(
                            '<img style="display:block;margin:auto;" src="' +
                            data_uri + '"/>');
                    });
                    $('#ModalFoto [data-btn="btnGuardarFoto"]').removeAttr("disabled");
                });

                $('#ModalFoto [data-btn="btnGuardarFoto"]').off().click(
                    function() { //guarda el base64 de la imagen en un hidden
                        var imgbase64 = $('#resultPhoto img').attr('src');
                        $('#' + namedoc).attr('type', 'hidden').removeClass('custom-file-input');
                        $('#' + namedoc).val(imgbase64);
                        $('#' + namedoc).next().removeClass('custom-file-label');
                        $("#ModalFoto").modal('hide'); //se cierra el modal
                        $("#ModalFoto .modal-dialog").removeClass('modal-lg');
                    });

                $("#ModalFoto").modal('show');
            });


        });



        $('#ddlSector').off().change(function() {
            var ddlSector = $(this);
            if (ddlSector.val() == '') {
                $('#ddlCategoria').prop('disabled', true);
            } else {
                $('#ddlCategoria').val('');
                $('#ddlCategoria').prop('disabled', false);
            }
        });


        $('#ddlEstado').off().change(function() {
            var ddlEstado = $(this);
            if (ddlEstado.val() == '') {
                $('#ddlMunicipio').prop('disabled', true);
                $('#ddlLocalidad').val('');
                $('#ddlLocalidad').prop('disabled', true);
            } else {
                $('#ddlMunicipio').val('');
                $('#ddlMunicipio').prop('disabled', false);
                $('#ddlLocalidad').val('');
                $('#ddlLocalidad').prop('disabled', true);
            }
        });


        $('#ddlMunicipio').off().change(function() {
            var ddlEstado = $('#ddlEstado');
            var ddlMunicipio = $(this);
            if (ddlEstado.val() == '' || ddlMunicipio.val() == '') {
                $('#ddlLocalidad').prop('disabled', true);
                $('#ddlLocalidad').prop('required', false);
            } else {
                $('#ddlLocalidad').val('');
                $('#ddlLocalidad').prop('disabled', false);
                $('#ddlLocalidad').prop('required', true);
            }
        });


        const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;

        //** OBTENER CATEGORIAS
        document.getElementById('ddlSector').addEventListener('change', (e) => {
            fetch('/obtenerCategorias', {
                method: 'POST',
                body: JSON.stringify({
                    texto: e.target.value
                }),
                headers: {
                    'Content-Type': 'application/json',
                    "X-CSRF-Token": csrfToken
                }
            }).then(response => {
                return response.json()
            }).then(data => {
                var opciones = "<option value=''>Seleccione una opción</option>";
                for (let i in data.lista) {
                    opciones += '<option value="' + data.lista[i].id + '">' + data.lista[i].name +
                        '</option>';
                }
                document.getElementById("ddlCategoria").innerHTML = opciones;
            }).catch(error => console.error(error));
        })

        //** OBTENER MUNICIPIOS
        document.getElementById('ddlEstado').addEventListener('change', (e) => {
            fetch('/obtenerMunicipios', {
                method: 'POST',
                body: JSON.stringify({
                    texto: e.target.value
                }),
                headers: {
                    'Content-Type': 'application/json',
                    "X-CSRF-Token": csrfToken
                }
            }).then(response => {
                return response.json()
            }).then(data => {
                var opciones = "<option value=''>Seleccione una opción</option>";
                for (let i in data.lista) {
                    opciones += '<option value="' + data.lista[i].cve_mun + '">' + data.lista[i].nom_mun +
                        '</option>';
                }
                document.getElementById("ddlMunicipio").innerHTML = opciones;
            }).catch(error => console.error(error));
        })


        //** OBTENER LOCALIDADES
        document.getElementById('ddlMunicipio').addEventListener('change', (e) => {
            var obj = {};
            obj.cve_mun = e.target.value;
            obj.cve_ent = document.getElementById("ddlEstado").value;
            fetch('/obtenerLocalidades', {
                method: 'POST',
                body: JSON.stringify(obj),
                headers: {
                    'Content-Type': 'application/json',
                    "X-CSRF-Token": csrfToken
                }
            }).then(response => {
                return response.json()
            }).then(data => {
                var opciones = "<option value=''>Seleccione una opción</option>";
                for (let i in data.lista) {
                    opciones += '<option value="' + data.lista[i].cve_loc + '">' + data.lista[i].nom_loc +
                        '</option>';
                }
                document.getElementById("ddlLocalidad").innerHTML = opciones;
            }).catch(error => console.error(error));
        })
    </script>
@endsection
