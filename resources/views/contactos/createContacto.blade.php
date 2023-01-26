@extends('layouts.app')

@section('content')
    <br><br>

    @if (Auth::check() && Auth::user()->permiso == 0)
        <form action="{{ route('Contactos.Guardar') }}" method="POST">
            @csrf

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
                <h4 class="card-header">Nuevo Contacto</h4>
                <div class="card-body">
                    <br>
                    {{-- sector, categoria --}}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="lblSector">{{ __('Sector') }}</span>
                                <select id="ddlSector" name="ddlSector" aria-describedby="lblsector" class="form-control"
                                    required>
                                    <option value="" selected>Seleccione una opcion</option>
                                    @foreach ($sectores as $sector)
                                        <option value="{{ $sector->id }}">{{ $sector->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="lblCategoria">{{ __('Categoría') }}</span>
                                <select id="ddlCategoria" name="ddlCategoria" aria-describedby="lblCategoria"
                                    class="form-control" required>
                                    <option value="" selected>Seleccione una opcion</option>
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id }}">{{ $categoria->name }}
                                        </option>
                                    @endforeach
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
                                    value="{{ old('name') }}" required autocomplete="name" autofocus
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
                                <span class="input-group-text" id="lblApellidoPaterno">{{ __('Apellido Paterno') }}</span>
                                <input id="ApellidoPaterno" type="text"
                                    class="form-control @error('ApellidoPaterno') is-invalid @enderror"
                                    name="ApellidoPaterno" value="{{ old('ApellidoPaterno') }}" required
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
                                <span class="input-group-text" id="lblApellidoMaterno">{{ __('Apellido Materno') }}</span>
                                <input id="ApellidoMaterno" type="text"
                                    class="form-control @error('ApellidoMaterno') is-invalid @enderror"
                                    name="ApellidoMaterno" value="{{ old('ApellidoMaterno') }}" required
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
                                    <option value="1" {{ old('ddlSexo') == 1 ? 'selected' : '' }}>MASCULINO</option>
                                    <option value="2" {{ old('ddlSexo') == 2 ? 'selected' : '' }}>FEMENINO</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="lblTitulo">{{ __('Titulo') }}</span>
                                <input id="Titulo" type="text"
                                    class="form-control @error('Titulo') is-invalid @enderror" name="Titulo"
                                    value="{{ old('Titulo') }}" required autocomplete="Titulo" autofocus
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
                                    value="{{ old('fecha_nac') }}"
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
                                    class="form-control @error('Dependencia') is-invalid @enderror" name="Dependencia"
                                    value="{{ old('Dependencia') }}" required autocomplete="Dependencia" autofocus
                                    onkeyup="mayusculas(this);" aria-label="Dependencia"
                                    aria-describedby="lblDependencia">

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
                                    value="{{ old('Cargo') }}" required autocomplete="Cargo" autofocus
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
                                    value="{{ old('Area') }}" required autocomplete="Area" autofocus
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
                                <span class="input-group-text" id="lblDomicilio">{{ __('Domicilio Laboral') }}</span>
                                <input id="Domicilio" type="text"
                                    class="form-control @error('Domicilio') is-invalid @enderror" name="Domicilio"
                                    value="{{ old('Domicilio') }}" required autocomplete="Domicilio" autofocus
                                    onkeyup="mayusculas(this);" aria-label="Domicilio" aria-describedby="lblDomicilio">

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
                                    value="{{ old('CodPostal') }}"
                                    class="form-control @error('CodPostal') is-invalid @enderror" " aria-label="Código Postal"
                                        aria-describedby="lblCP" required autocomplete="CodPostal" autofocus>

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
                                        <option value="" selected>Seleccione una opcion</option>
                                         @foreach ($estados as $estado)
                                <option value="{{ $estado->cve_ent }}">{{ $estado->nom_ent }}
                                </option>
    @endforeach
    </select>
    </div>
    </div>

    <div class="col-md-4">
        <div class="input-group mb-3 ">
            <span class="input-group-text" id="lblMunicipio">{{ __('Municipio') }}</span>
            <select id="ddlMunicipio" class="form-control" name="ddlMunicipio" disabled required>
            </select>
        </div>


    </div>

    <div class="col-md-4">
        <div class="input-group mb-3 ">
            <span class="input-group-text" id="lblLocalidad">{{ __('Localidad') }}</span>
            <select id="ddlLocalidad" class="form-control" name="ddlLocalidad" disabled required>
            </select>
        </div>
    </div>
    </div>














    <br>

    <div class="input-group mb-3">
        <span class="input-group-text" id="lblEmail">{{ __('Email Address') }}</span>
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
            value="{{ old('email') }}" required autocomplete="email" aria-label="Email" aria-describedby="lblEmail">

        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

    </div>

    <br>

    <div class="input-group mb-3">
        <span class="input-group-text" id="lblPhone">Teléfono Celular</span>
        <input id="phone" type="number" maxlength="10" class="form-control @error('phone') is-invalid @enderror"
            name="phone" value="{{ old('phone') }}" required autocomplete="phone" aria-label="Teléfono"
            aria-describedby="lblPhone">

        @error('phone')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

    </div>

    <br>

    <div class="input-group mb-3">
        <span class="input-group-text" id="lblPassword">{{ __('Password') }} </span>

        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
            name="password" required autocomplete="new-password" aria-label="Password" aria-describedby="lblPassword">

        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <br>

    <div class="input-group mb-3">
        <span class="input-group-text" id="lblPassword-confirm">{{ __('Confirm Password') }} </span>

        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
            autocomplete="new-password" aria-label="Password Confirm" aria-describedby="lblPassword-confirm">
    </div>

    <br>

    <div class="row ">
        <div class="col-md-12">
            <div class="input-group mb-3 align-items-center">
                <span class="input-group-text" id="lblPermiso">Permiso: </span>
                <div class="form-inline">
                    <input type="radio" name="radio" id="radio1" checked="true" value="0" />
                    <label class="radio ml-3" for="radio1">ADMINISTRADOR</label>
                    <input type="radio" name="radio" id="radio2" value="1" /> <label class="radio ml-3"
                        for="radio2">CONSULTA</label>
                </div>
            </div>
        </div>
    </div>


    <br>

    <div class="input-group mb-3">
        <span class="input-group-text" id="estatus">Status: </span>
        <input type="checkbox" aria-describedby="estatus" id="status" name="status" data-toggle="toggle"
            data-onstyle="success" data-offstyle="secondary" data-on="Activo" data-off="Inactivo" checked>
    </div>

    <br>
    </div>
    <div class="card-footer">
        <div class="col-md-6 col-lg-4 col-xl-3 btn-toolbar justify-content-around " role="toolbar">
            <div class="btn-group mr-2" role="group">
                <a href="{{ route('Usuarios.Index') }}" class="btn btn-secondary"><i
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
    <script>
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
                var opciones = "<option value=''><-- Seleccione --></option>";
                for (let i in data.lista) {
                    opciones += '<option value="' + data.lista[i].cve_mun + '">' + data.lista[i].nom_mun +
                        '</option>';
                }
                document.getElementById("ddlMunicipio").innerHTML = opciones;
            }).catch(error => console.error(error));
        })



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
                var opciones = "<option value=''><-- Seleccione --></option>";
                for (let i in data.lista) {
                    opciones += '<option value="' + data.lista[i].cve_loc + '">' + data.lista[i].nom_loc +
                        '</option>';
                }
                document.getElementById("ddlLocalidad").innerHTML = opciones;
            }).catch(error => console.error(error));
        })
    </script>
@endsection
