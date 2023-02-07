@extends('layouts.app')

@section('content')
    <br><br>

    @if (Auth::check() && Auth::user()->permiso == 0)
        <form action="{{ route('Usuarios.Update', $usuario->id) }}" method="post">
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
                <h4 class="card-header">Editar Usuario</h4>
                <div class="card-body">
                    <br>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="lblNombre">{{ __('Name') }}</span>
                        <input type="text" id="name" name="name" value="{{ $usuario->name }}"
                            class="form-control @error('name') is-invalid @enderror"" aria-label="Nombre del usuario"
                            aria-describedby="lblNombre" required>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>

                    <br>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="lblEmail">{{ __('Email Address') }}</span>
                        <input type="email" id="email" name="email" value="{{ $usuario->email }}"
                            class="form-control  @error('email') is-invalid @enderror" aria-label="Email" readonly
                            aria-describedby="lblEmail" required>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <br>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="lblPhone">{{ __('Phone') }}</span>
                        <input id="phone" type="number" maxlength="10"
                            class="form-control @error('phone') is-invalid @enderror" name="phone"
                            value="{{ $usuario->phone }}" required aria-label="Teléfono" aria-describedby="lblPhone">

                        @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>

                    <br>

                    <div class="row ">
                        <div class="col-md-12">
                            <div class="input-group mb-3 align-items-center">
                                <span class="input-group-text" id="lblPermiso">Permiso: </span>
                                <div class="form-inline">
                                    <input type="radio" name="radio" id="radio1" value="0"
                                        @if ($usuario->permiso == 0) checked @endif />
                                    <label class="radio ml-3" for="radio1">ADMINISTRADOR</label>
                                    <input type="radio" name="radio" id="radio2" value="1"
                                        @if ($usuario->permiso == 1) checked @endif /> <label class="radio ml-3"
                                        for="radio2">CONSULTA</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="estatus">Status: </span>
                        <input type="checkbox" aria-describedby="estatus" id="status" name="status" data-toggle="toggle"
                            data-onstyle="success" data-offstyle="secondary" data-on="Activo" data-off="Inactivo"
                            value="{{ $usuario->status }}" @if ($usuario->status == 1) checked @endif>
                    </div>

                    <br>
                </div>
                <div class="card-footer">
                    <div class="col-md-6 col-lg-4 col-xl-3 btn-toolbar justify-content-around " role="toolbar">
                        <div class="btn-group mr-2" role="group">
                            <a href="{{ route('Usuarios.Index') }}" class="btn btn-secondary"> Cancelar</a>



                        </div>
                        <div class="btn-group mr-2" role="group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save fa-lg mr-1"></i>
                                <strong>Actualizar</strong></button>
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

