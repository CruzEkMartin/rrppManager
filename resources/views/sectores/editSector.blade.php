@extends('layouts.app')

@section('content')
    <br><br>

    @if (Auth::check() && Auth::user()->permiso == 0)
        <form action="{{ route('Sectores.Update', $sector->id) }}" method="post">
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
                <h4 class="card-header">Editar Sector</h4>
                <div class="card-body">
                    <br>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="lblNombre">{{ __('Name') }}</span>
                        <input type="text" id="name" name="name" value="{{ $sector->name }}"
                            class="form-control @error('name') is-invalid @enderror"" aria-label="Nombre del sector"
                            aria-describedby="lblNombre" required>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>

                    <br>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="estatus">Status: </span>
                        <input type="checkbox" aria-describedby="estatus" id="status" name="status" data-toggle="toggle"
                            data-onstyle="success" data-offstyle="secondary" data-on="Activo" data-off="Inactivo"
                            value="{{ $sector->status }}" @if ($sector->status == 1) checked @endif>
                    </div>

                    <br>
                </div>
                <div class="card-footer">
                    <div class="col-md-6 col-lg-4 col-xl-3 btn-toolbar justify-content-around " role="toolbar">
                        <div class="btn-group mr-2" role="group">
                            <a href="{{ route('Sectores.Index') }}" class="btn btn-secondary"> Cancelar</a>

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
