@extends('layouts.app')
@section('content')
@section('titulo', 'Registro de Usuarios')
@push('estilos')
<link rel="stylesheet" href="{{asset('css/FormularioUsuarios.css')}}">
@endpush

@if (session('mensaje'))
    @include('layouts.alert', [
        'title' => session('type') == 'Danger' ? 'Error' : 'Info',
        'message' => session('mensaje'),
        'type' => session('type'),
    ])
@endif


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Registro de Usuarios</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('Usuarios.ingresar') }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Mostrar errores globales --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Campo DNI --}}
                        <div class="mb-3">
                            <label for="dni" class="form-label">DNI</label>
                            <input type="text" class="form-control @error('dni') is-invalid @enderror" id="dni" name="dni" value="{{ old('dni') }}" required>
                            @error('dni')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Campo Rol --}}
                        <div class="mb-3">
                            <label for="rol" class="form-label">Rol</label>
                            <select class="form-select @error('rol') is-invalid @enderror" id="rol" name="rol" required>
                                @if (session('nombre') && session('descripcion') === "administrador")
                                    <option value="1" {{ old('rol') == 1 ? 'selected' : '' }}>Administrador</option>
                                @endif
                                <option value="2" {{ old('rol') == 2 ? 'selected' : '' }}>Usuario</option>
                            </select>
                            @error('rol')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Otros campos (Nombre, Apellidos, etc.) --}}
                        @foreach ([
                            ['nombre', 'Nombre', 'text'],
                            ['apellido', 'Apellidos', 'text'],
                            ['telefono', 'Número Telefónico', 'tel'],
                            ['direccion', 'Dirección', 'text'],
                            ['correo', 'Correo Electrónico', 'email'],
                            ['contraseña', 'Contraseña', 'password'],
                            ['contraseña_confirmation', 'Confirmar Contraseña', 'password'],
                        ] as $campo)
                            <div class="mb-3">
                                <label for="{{ $campo[0] }}" class="form-label">{{ $campo[1] }}</label>
                                <input type="{{ $campo[2] }}" 
                                       class="form-control @error($campo[0]) is-invalid @enderror" 
                                       id="{{ $campo[0] }}" 
                                       name="{{ $campo[0] }}" 
                                       value="{{ old($campo[0]) }}" 
                                       required>
                                @error($campo[0])
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endforeach

                        {{-- Botón de envío --}}
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary w-100">Registrar</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('Mostrar') }}" class="btn btn-link">Ver Usuarios</a>
                    <a href="{{ route('principal') }}" class="btn btn-link">Volver al Inicio</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
