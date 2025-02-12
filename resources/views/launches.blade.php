@extends('layouts.app')

@section('title', 'Jadwal Peluncuran')

@section('content')
<div class="bg-gray-800 p-6 rounded-lg shadow-lg">
    <h2 class="text-xl font-semibold mb-4">🚀 Jadwal Peluncuran</h2>

    <ul class="space-y-4">
        @foreach($launches as $launch)
        <li class="bg-gray-700 p-4 rounded-lg shadow-md flex gap-4">
            <img src="{{ $launch['image']['thumbnail_url'] ?? 'https://via.placeholder.com/100' }}"
                alt="Rocket Image" class="w-24 h-24 object-cover rounded-lg">
            <div>
                <h3 class="text-lg font-semibold">{{ $launch['name'] }}</h3>
                <p class="text-sm text-gray-400">📅 {{ date('d M Y H:i', strtotime($launch['window_start'])) }}</p>
                <p class="text-green-400 font-semibold mt-1">📍 {{ $launch['pad']['location']['name'] }}</p>
                <p class="text-blue-400 font-semibold">🚀 {{ $launch['rocket']['configuration']['full_name'] ?? 'Unknown Rocket' }}</p>
                <p class="text-yellow-400 font-semibold">
                    🏢 {{ $launch['launch_service_provider']['name'] ?? 'Tidak Diketahui' }}
                </p>
            </div>
        </li>
        @endforeach
    </ul>

    <a href="{{ route('dashboard') }}" class="block mt-6 text-center bg-gray-700 text-white py-2 rounded-lg hover:bg-gray-600">
        🔙 Kembali ke Dashboard
    </a>
</div>
@endsection