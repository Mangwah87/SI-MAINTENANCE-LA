@props(['type' => 'info', 'message' => null, 'errors' => null])

@php
    // Tentukan warna berdasarkan tipe
    $class = match ($type) {
        'success' => 'bg-green-100 border-green-500 text-green-700',
        'error' => 'bg-red-100 border-red-500 text-red-700',
        'warning' => 'bg-yellow-100 border-yellow-500 text-yellow-700',
        default => 'bg-blue-100 border-blue-500 text-blue-700',
    };
@endphp

<div {{ $attributes->merge(['class' => "mb-4 border-l-4 p-4 $class"]) }} role="alert">
    @if ($errors && $errors->any())
        {{-- Menampilkan daftar error validasi Laravel --}}
        <p class="font-bold">Ada {{ $errors->count() }} kesalahan:</p>
        <ul class="mt-1 list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @elseif ($message)
        {{-- Menampilkan pesan tunggal (misalnya dari session('success')) --}}
        <p class="font-bold">{{ ucfirst($type) }}</p>
        <p>{{ $message }}</p>
    @else
        {{ $slot }}
    @endif
</div>