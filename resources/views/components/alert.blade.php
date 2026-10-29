@props(['type', 'message', 'timeout' => '3000'])


@if (session()->has($type))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, {{ $timeout }})" x-show="show"
        class="p-4 mb-4 text-sm text-white rounded {{ $type == 'success' ? 'bg-green-500' : 'bg-red-500' }}">
        {{ $message }}</div>
@endif
