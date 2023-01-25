@extends('layouts.app')

@section('content')
    <br><br>

    @if (Auth::check() && Auth::user()->permiso == 0)
        <form action="{{ route('Partidos.Guardar') }}" method="POST">
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
                <h4 class="card-header">Nuevo Partido</h4>
                <div class="card-body">
                    <br>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="lblNombre">{{ __('Name') }}</span>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                            onkeyup="mayusculas(this);" aria-label="Nombre del Partido" aria-describedby="lblNombre">

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>

                    <br>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="lblSiglas">Siglas</span>
                        <input id="siglas" type="text" class="form-control @error('siglas') is-invalid @enderror"
                            name="siglas" value="{{ old('siglas') }}" required autocomplete="siglas" aria-label="Siglas"
                            aria-describedby="lblSiglas">

                        @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

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
                            <a href="{{ route('Partidos.Index') }}" class="btn btn-secondary"><i
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
