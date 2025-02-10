<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Roket</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white">

    <div class="container mx-auto p-6" x-data="countdownTimers()">
        <h1 class="text-3xl font-bold text-center mb-6">🚀 Dashboard Berita & Jadwal Roket</h1>

        <div class="grid md:grid-cols-2 gap-6">
            <!-- Berita Roket -->
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold mb-4">📰 Berita Roket</h2>
                <ul class="space-y-4">
                    @foreach($news as $article)
                    <li class="bg-gray-700 p-4 rounded-lg shadow-md cursor-pointer"
                        @click="selectedNews = {{ json_encode($article) }}; showModal = true">
                        <img src="{{ $article['image_url'] }}" alt="News Image" class="w-full h-48 object-cover rounded-lg">
                        <h3 class="text-lg font-semibold mt-2">{{ $article['title'] }}</h3>
                        <p class="text-sm text-gray-400 mt-1">{{ date('d M Y', strtotime($article['published_at'])) }}</p>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Jadwal Peluncuran -->
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold mb-4">🚀 Jadwal Peluncuran</h2>
                <ul class="space-y-4">

                    @foreach($launches as $launch)
                    <li class="bg-gray-700 p-4 rounded-lg shadow-md flex gap-4" x-init="startCountdown('{{$launch['id']}}', '{{ $launch['window_start'] }}')">
                        <!-- Gambar Roket -->
                        <img src="{{ $launch['image']['thumbnail_url'] ?? 'https://via.placeholder.com/100' }}"
                            alt="Rocket Image"
                            class="w-24 h-24 object-cover rounded-lg">

                        <div>
                            <h3 class="text-lg font-semibold">{{ $launch['name'] }}</h3>
                            <p class="text-sm text-gray-400">📅 {{ date('d M Y H:i', strtotime($launch['window_start'])) }}</p>
                            <p class="text-green-400 font-semibold mt-1">📍 {{ $launch['pad']['location']['name'] }}</p>
                            <p class="text-blue-400 font-semibold">🚀 {{ $launch['rocket']['configuration']['full_name'] ?? 'Unknown Rocket' }}</p>

                            <!-- Menampilkan Nama Perusahaan -->
                            <p class="text-yellow-400 font-semibold">
                                🏢 {{ $launch['launch_service_provider']['name'] ?? 'Tidak Diketahui' }}
                            </p>

                            <p class="text-red-400 font-bold mt-2" x-text="countdowns['{{$launch['id']}}']"></p>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Popup Modal -->
        <div x-show="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
            <div class="bg-gray-800 p-6 rounded-lg max-w-lg w-full relative">
                <button @click="showModal = false" class="absolute top-2 right-2 text-white text-xl">&times;</button>
                <img :src="selectedNews.image_url" alt="News Image" class="w-full h-48 object-cover rounded-lg">
                <h2 class="text-lg font-semibold mt-2" x-text="selectedNews.title"></h2>
                <p class="text-sm text-gray-400 mt-1" x-text="new Date(selectedNews.published_at).toLocaleDateString()"></p>
                <p class="text-gray-300 mt-2" x-text="selectedNews.summary"></p>
                <a :href="selectedNews.url" target="_blank" class="mt-4 block text-center bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-700">Baca Selengkapnya</a>
            </div>
        </div>
    </div>

    <script>
        function countdownTimers() {
            return {
                countdowns: {},
                showModal: false,
                selectedNews: {},
                startCountdown(id, time) {
                    let launchTime = new Date(time).getTime();
                    setInterval(() => {
                        let now = new Date().getTime();
                        let distance = launchTime - now;

                        if (distance > 0) {
                            let days = Math.floor(distance / (1000 * 60 * 60 * 24));
                            let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                            let seconds = Math.floor((distance % (1000 * 60)) / 1000);
                            this.countdowns[id] = `${days}d ${hours}h ${minutes}m ${seconds}s`;
                        } else {
                            this.countdowns[id] = "🚀 Sudah Diluncurkan!";
                        }
                    }, 1000);
                }
            };
        }
    </script>

</body>

</html>