@props(['variant' => 'default', 'showText' => true, 'href' => null])

@php
    $logoClasses = match($variant) {
        'default' => 'w-10 h-10',
        'small' => 'w-8 h-8',
        'large' => 'w-12 h-12',
        default => 'w-10 h-10'
    };
    
    $textColor = match($variant) {
        'light' => 'text-white',
        'dark' => 'text-gray-900',
        default => 'text-blue-700'
    };
    
    $logoUrl = $href ?? url('/');
@endphp

<div class="flex items-center gap-3">
    @if($variant === 'image')
        <a href="{{ $logoUrl }}" class="flex items-center">
            <img src="{{ asset('images/logo-login-nobg.png') }}" alt="Lihok Padulong Logo" class="{{ $logoClasses }} object-contain" />
        </a>
    @else
        <a href="{{ $logoUrl }}" class="flex items-center">
            <div class="{{ $logoClasses }} bg-blue-700 rounded flex items-center justify-center text-white font-bold">
                LP
            </div>
        </a>
    @endif
    
    @if($showText)
        <div class="flex flex-col">
            <div class="font-bold {{ $textColor }} leading-tight">LIHOK PADULONG</div>
            <div class="text-xs {{ $variant === 'light' ? 'text-red-300' : 'text-red-600' }} font-semibold leading-tight">
                MINGLANILLA TRAFFIC COMMAND
            </div>
        </div>
    @endif
</div>
