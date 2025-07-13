@props(['title', 'value', 'icon' => 'fas fa-info-circle', 'color' => 'blue', 'desc' => ''])

@php
    $colors = [
        'blue' => 'bg-blue-100 text-blue-600',
        'green' => 'bg-green-100 text-green-600',
        'purple' => 'bg-purple-100 text-purple-600',
        'red' => 'bg-red-100 text-red-600',
        'gray' => 'bg-gray-100 text-gray-600',
    ];
    $iconColor = $colors[$color] ?? $colors['gray'];
@endphp

<div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
    <div class="flex items-center mb-4">
        <div class="w-10 h-10 flex items-center justify-center rounded-full {{ $iconColor }} mr-4">
            <i class="{{ $icon }}"></i>
        </div>
        <div>
            <h4 class="text-sm font-semibold text-gray-700">{{ $title }}</h4>
            <p class="text-lg font-bold text-gray-900">{{ $value }}</p>
        </div>
    </div>
    @if($desc)
        <p class="text-sm text-gray-500">{{ $desc }}</p>
    @endif
</div>
