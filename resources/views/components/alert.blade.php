<div class="p-4 mb-4 text-sm rounded-lg {{$class}}" role="alert">
    <span class="font-medium">{{ $title ?? 'Info alert!' }}</span> {{ $slot ?? 'Por favor proporciona un mensaje' }}
</div>