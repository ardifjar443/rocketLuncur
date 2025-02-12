<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Roket</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white p-6">
    <h1 class="text-3xl font-bold text-center mb-6">📰 Berita Roket</h1>

    <div class="grid md:grid-cols-2 gap-6">
        @foreach($news as $article)
        <div class="bg-gray-800 p-4 rounded-lg shadow-lg cursor-pointer"
            onclick="openModal('{{ json_encode($article) }}')">
            <img src="{{ $article['image_url'] }}" alt="News Image" class="w-full h-48 object-cover rounded-lg">
            <h3 class="text-lg font-semibold mt-2">{{ $article['title'] }}</h3>
            <p class="text-sm text-gray-400 mt-1">{{ date('d M Y', strtotime($article['published_at'])) }}</p>
        </div>
        @endforeach
    </div>

    <!-- Pagination Controls -->
    <div class="flex justify-between items-center mt-6">
        <a href="{{ route('dashboard') }}" class="bg-gray-600 px-4 py-2 rounded-lg text-white hover:bg-gray-800">
            ⬅ Back to Dashboard
        </a>

        @if ($page > 1)
        <a href="{{ url('berita?page=' . ($page - 1)) }}"
            class="bg-blue-600 px-4 py-2 rounded-lg text-white hover:bg-blue-800">
            ⬅ Previous
        </a>
        @endif

        @if (($page * $perPage) < $totalNews) <a href="{{ url('berita?page=' . ($page + 1)) }}"
            class="bg-blue-600 px-4 py-2 rounded-lg text-white hover:bg-blue-800">
            Next ➡
            </a>
            @endif
    </div>

    <!-- Popup Modal -->
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-gray-800 p-6 rounded-lg max-w-lg w-full relative">
            <button onclick="closeModal()" class="absolute top-2 right-2 text-white text-xl">&times;</button>
            <img id="modal-image" src="" alt="News Image" class="w-full h-48 object-cover rounded-lg">
            <h2 id="modal-title" class="text-lg font-semibold mt-2"></h2>
            <p id="modal-date" class="text-sm text-gray-400 mt-1"></p>
            <p id="modal-summary" class="text-gray-300 mt-2"></p>
            <a id="modal-link" href="#" target="_blank"
                class="mt-4 block text-center bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-700">
                Baca Selengkapnya
            </a>
        </div>
    </div>

    <script>
        function openModal(articleJson) {
            let article = JSON.parse(articleJson);
            document.getElementById("modal-image").src = article.image_url;
            document.getElementById("modal-title").textContent = article.title;
            document.getElementById("modal-date").textContent = new Date(article.published_at).toLocaleDateString();
            document.getElementById("modal-summary").textContent = article.summary;
            document.getElementById("modal-link").href = article.url;
            document.getElementById("modal").classList.remove("hidden");
        }

        function closeModal() {
            document.getElementById("modal").classList.add("hidden");
        }
    </script>
</body>

</html>