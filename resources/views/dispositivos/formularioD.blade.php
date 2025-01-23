@extends('layouts.app')

@section('content')
@section('titulo', 'Registro de Equipos')

@push('estilos')
<link rel="stylesheet" href="{{asset('css/FormularioDispositivos.css')}}">
@endpush

@if (session('mensaje'))
    <div class="alert alert-{{ session('type') == 'Danger' ? 'danger' : 'info' }} alert-dismissible fade show mx-auto" role="alert" style="max-width: 600px;">
        <strong>{{ session('type') == 'Danger' ? 'Error' : 'Info' }}</strong>: {{ session('mensaje') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="container my-5 form-container">
    <div class="card">
        <div class="card-header text-center bg-primary text-white">
            <h4>Registro de Equipos</h4>
        </div>
        <div class="card-body">
            <form id="myForm" action="{{ route('Ingresar.dispositivos') }}" method="POST">
                @csrf

                <!-- Información del Responsable -->
                <div class="form-section">
                    <h5>Información del Responsable</h5>
                    <div class="mb-3">
                        <label for="dispositivo_nombre" class="form-label">Nombre del Responsable</label>
                        <input type="text" 
                               class="form-control @error('dispositivo_nombre') is-invalid @enderror" 
                               id="dispositivo_nombre" 
                               name="dispositivo_nombre" 
                               value="{{ old('dispositivo_nombre') }}" 
                               required>
                        @error('dispositivo_nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Detalles del Equipo -->
                <div class="form-section">
                    <h5>Detalles del Equipo</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="dispositivo_marca" class="form-label">Marca</label>
                            <input type="text" 
                                   class="form-control @error('dispositivo_marca') is-invalid @enderror" 
                                   id="dispositivo_marca" 
                                   name="dispositivo_marca" 
                                   value="{{ old('dispositivo_marca') }}" 
                                   required>
                            @error('dispositivo_marca')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="dispositivo_modelo" class="form-label">Modelo</label>
                            <input type="text" 
                                   class="form-control @error('dispositivo_modelo') is-invalid @enderror" 
                                   id="dispositivo_modelo" 
                                   name="dispositivo_modelo" 
                                   value="{{ old('dispositivo_modelo') }}" 
                                   required>
                            @error('dispositivo_modelo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="dispositivo_ram" class="form-label">RAM</label>
                            <input type="text" 
                                   class="form-control @error('dispositivo_ram') is-invalid @enderror" 
                                   id="dispositivo_ram" 
                                   name="dispositivo_ram" 
                                   value="{{ old('dispositivo_ram') }}" 
                                   required>
                            @error('dispositivo_ram')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="dispositivo_procesador" class="form-label">Procesador</label>
                            <input type="text" 
                                   class="form-control @error('dispositivo_procesador') is-invalid @enderror" 
                                   id="dispositivo_procesador" 
                                   name="dispositivo_procesador" 
                                   value="{{ old('dispositivo_procesador') }}" 
                                   required>
                            @error('dispositivo_procesador')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Otros Detalles -->
                <div class="form-section">
                    <h5>Otros Detalles</h5>
                    <div class="mb-3">
                        <label for="observacion" class="form-label">Observaciones</label>
                        <textarea class="form-control @error('observacion') is-invalid @enderror" 
                                  id="observacion" 
                                  name="observacion" 
                                  rows="2">{{ old('observacion') }}</textarea>
                        @error('observacion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
