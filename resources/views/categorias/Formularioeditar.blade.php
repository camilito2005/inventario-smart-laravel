@extends('layouts.app')
@section('content')
@if (session('mensaje'))

@push('estilos')
<link rel="stylesheet" href="{{asset('css/editcategorias.css')}}">
@endpush

@include('layouts.alert', [
    'title' => session('type') == 'Danger' ? 'Error' : 'Info',
    'message' => session('mensaje'),
    'type' => session('type'),
])
@endif
    <div class="container col-md-6 col-lg-5 contenedor">
        <div class="cont" style="margin: 100px;">
        <h3 class="form-title" style="align-items: center">Modificar Categoría</h3>
            <form action="{{ route('Actualizarcategorias', $id) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $id }}">
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" value="{{ old('nombre', $category->nombre) }}" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">
                <i class="fa-solid fa-pen"></i> Modificar
            </button>
        </form>
        </div>
    </div>
    <div class="btn-back">
        <button class="btn btn-outline-secondary w-100">
            <a href="{{ route('Categorias') }}">
                <i class="fa-solid fa-backward"></i> Regresar
            </a>
        </button>
    </div>
    <div class="btn-home">
        <button class="btn btn-outline-secondary w-100">
            <a href="{{ url('principal') }}">
                <i class="fa-solid fa-house"></i> Inicio
            </a>
        </button>
    </div>
@endsection