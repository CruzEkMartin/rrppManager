@extends('layouts.app')

@section('content')
    <br><br>

    @if (Auth::check() && Auth::user()->permiso == 0)
        <form action="{{ route('Usuarios.Guardar') }}" method="POST">
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
                <h4 class="card-header">Nuevo Usuario</h4>
                <div class="card-body">
                    <br>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="lblNombre">{{ __('Name') }}</span>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                            onkeyup="mayusculas(this);" aria-label="Nombre del usuario" aria-describedby="lblNombre">

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>

                    <br>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="lblEmail">{{ __('Email Address') }}</span>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" aria-label="Email"
                            aria-describedby="lblEmail">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>

                    <br>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="lblPhone">Teléfono Celular</span>
                        <input id="phone" type="number" maxlength="10"
                            class="form-control @error('phone') is-invalid @enderror" name="phone"
                            value="{{ old('phone') }}" required autocomplete="phone" aria-label="Teléfono"
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
                            name="password" required autocomplete="new-password" aria-label="Password"
                            aria-describedby="lblPassword">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <br>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="lblPassword-confirm">{{ __('Confirm Password') }} </span>

                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                            required autocomplete="new-password" aria-label="Password Confirm"
                            aria-describedby="lblPassword-confirm">
                    </div>

                    <br>

                    <div class="row ">
                        <div class="col-md-12">
                            <div class="input-group mb-3 align-items-center">
                                <span class="input-group-text" id="lblPermiso">Permiso: </span>
                                <div class="form-inline">
                                    <input type="radio" name="radio" id="radio1" checked="true" value="0" />
                                    <label class="radio ml-3" for="radio1">ADMINISTRADOR</label>
                                    <input type="radio" name="radio" id="radio2" value="1" /> <label
                                        class="radio ml-3" for="radio2">CONSULTA</label>
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
        $(document).ready(function() {

            $("[name='phone'],[name='phone']").attr({
                pattern: '[1-9]{1}[0-9]{9}',
                type: 'text',
                title: '10 NUMEROS'
            }); //validacion para numero de telefono
        });
    </script>
@endsection
