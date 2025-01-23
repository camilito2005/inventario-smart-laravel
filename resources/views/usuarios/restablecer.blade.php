@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Restablecer Contraseña</h2>
    @if(session('mensaje'))
        <div class="alert alert-danger">{{ session('mensaje') }}</div>
    @endif
    <form action="{{ route('update') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="mb-3">
            <label for="password">Nueva Contraseña:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password_confirmation">Confirmar Nueva Contraseña:</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Contraseña</button>
    </form>
</div>
@endsection
