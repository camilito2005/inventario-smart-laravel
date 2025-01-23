@extends('layouts.app')
@section('content')
    @if (session('mensaje'))
    @include('layouts.alert', [
        'title' => session('type') == 'Danger' ? 'Error' : 'Info',
        'message' => session('mensaje'),
        'type' => session('type'),
    ])
@endif
    <!--<div id="loading">Cargando...</div>-->
    
    <div class="container d-flex flex-column align-items-center justify-content-center vh-100">
        <div class="contenedor">
            <h2 class="text-center text-primary">Restablecer Contraseña</h2>
            <p class="text-center text-muted">
                Introduce tu correo electrónico para recibir un enlace de restablecimiento.
            </p>
            <form id="myForm" action="{{route('restablecer')}}" onsubmit="showLoading()" method="post">
                @csrf
                <div class="mb-3">
                    <input class="form-control" id="correo" placeholder="Correo electrónico" required type="email" name="correo">
                </div>
                <div class="d-grid">
                    <button class="btn btn-primary" type="submit">
                        Enviar
                    </button>
                </div>
            </form>
        </div>
        
        <div class="mt-3 d-flex flex-column">
            <form id="myForm" action="{{route('Login_html')}}" onsubmit="showLoading()" method="get">
                @csrf 
                <button class="btn btn-outline-secondary" type="submit">
                    <i class="">Regresar</i> 
                </button>
            </form>
            
            <form id="myForm" action="{{route('principal')}}" onsubmit="showLoading()" method="get">
                @csrf
                <button class="btn btn-outline-secondary" type="submit">
                    <i class="fa-solid fa-house"></i> Inicio
                </button>
            </form>
        </div>
    </div>
    
    <!-- Custom JS -->
    <script>
        function showLoading() {
            document.getElementById('loading').style.display = 'flex';
        }
    </script>
</body>

</html>
@endsection