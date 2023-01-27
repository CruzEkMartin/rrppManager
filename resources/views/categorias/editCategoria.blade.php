@extends('layouts.app')

@section('content')
    <br><br>

    @if (Auth::check() && Auth::user()->permiso == 0)
    <form action="{{ route('Categorias.Update', $categoria->id) }}" method="post">
        @csrf
        @method('put')
        <div class="card">
            <h4 class="card-header">Editar Categoria</h4>
            <div class="card-body">
                <br>

                <div class="input-group mb-3">
                    <span class="input-group-text" id="lblNombre">{{ __('Name') }}</span>
                    <input type="text" id="name" name="name" value="{{ $categoria->name }}"
                        class="form-control @error('name') is-invalid @enderror"" aria-label="Nombre de la categoría" aria-describedby="lblNombre" required>

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
                        value="{{ $categoria->status }}" @if ($categoria->status == 1) checked @endif>
                </div>

                <br>
            </div>
            <div class="card-footer">
                <div class="col-md-6 col-lg-4 col-xl-3 btn-toolbar justify-content-around " role="toolbar">
                    <div class="btn-group mr-2" role="group">
                        <a href="{{ route('Categorias.Index') }}" class="btn btn-secondary"> Cancelar</a>

                    </div>
                    <div class="btn-group mr-2" role="group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save fa-lg mr-1"></i> <strong>Actualizar</strong></button>
                    </div>
                </div>
            </div>
        </div>


    </form>
@endif   


@endsection