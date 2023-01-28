@extends('layouts.app')

@section('content')
    <br><br>

    @if (Auth::check() && Auth::user()->permiso == 0)
        <form action="{{ route('Contactos.Update', $contacto->id) }}" method="post">
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
                                            class="form-control" required>
                                        </select>
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
                                        <select id="ddlMunicipio" class="form-control" name="ddlMunicipio" disabled
                                            required>
                                        </select>
                                    </div>

                                </div>

                                <div class="col-md-4">
                                    <div class="input-group mb-3 ">
                                        <span class="input-group-text" id="lblLocalidad">{{ __('Localidad') }}</span>
                                        <select id="ddlLocalidad" class="form-control" name="ddlLocalidad" disabled
                                            required>
                                        </select>
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
    @endif


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
    </script>
@endsection
