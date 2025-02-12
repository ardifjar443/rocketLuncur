<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Roket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: black;
            color: white;
            font-family: Arial, sans-serif;
        }

        .stars {
            position: absolute;
            width: 100%;
            height: 100%;
            background: url('https://www.transparenttextures.com/patterns/stardust.png');
        }

        @keyframes twinkle {
            0% {
                opacity: 0.7;
            }

            100% {
                opacity: 1;
            }
        }

        .content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }
    </style>
</head>

<body>


    <div class="  p-2  w-full rounded-b-xl top-0 fixed flex flex-row z-50">
        <div class="flex gap-2 items-center"><img src="/img/startup.png" class="w-10  " alt="">
            <p class="text-2xl font-bold">RocketLuncur</p>
        </div>
        <div class="flex item-center px-10 justify-between  w-full">
            <div class="flex items-center gap-3 "><a href="/berita">Berita</a><a href="/jadwal">Jadwal</a>
            </div>

            <div class="flex gap-2">
                <div class=" flex justify-center items-center">
                    <ion-icon name="bookmark" size="large" className="bg-black"></ion-icon>
                </div>
                @auth
                <div class="relative inline-block text-left">
                    <button onclick="toggleDropdown()"
                        class="flex items-center gap-2 px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 focus:outline-none">
                        <span>{{ Auth::user()->name }}</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>

                    <div id="dropdown-menu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg hidden">
                        <a class="block px-4 py-2 text-gray-800 hover:bg-gray-200" href="/profile">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-200">Logout</button>
                        </form>
                    </div>
                </div>

                @endauth

                @guest
                <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-500">
                    Login
                </a>
                @endguest
            </div>

        </div>
    </div>


    @if(!empty($bookmarkedNews))
    <div class="flex min-h-screen stars justify-center items-center">


        @endif
        <div>

            <div class=" gap-6 p-6 grid grid-cols-3   ">
                @foreach($bookmarkedNews as $index => $article)
                @if($index > 0)
                <div class="p-4 rounded-lg shadow-lg cursor-pointer flex gap-4">
                    <img src="{{ $article['image_url'] }}" alt="News Image" class=" w-40 object-cover rounded-lg">
                    <div class="">

                        <h3 class="text-lg font-semibold mt-2">{{ $article['title'] }}</h3>

                        <p class="text-sm text-gray-400 mt-1 text-start w-full ">{{ date('d M Y',
                            strtotime($article['published_at'])) }}
                        </p>
                        <div class="flex w-full gap-1"><button
                                class=" block text-center bg-blue-600 text-white  p-2 rounded-lg hover:bg-blue-800 w-full h-full"
                                onclick="openModal(
                    '{{ $article['image_url'] }}',
                    '{{ addslashes($article['title']) }}',
                    '{{ $article['published_at'] }}',
                    {{ json_encode($article['summary']) }},
                    '{{ $article['url'] }}'
                    )">
                                Baca
                            </button>
                            <button data-berita-id="{{ $article['id'] }}"
                                class="bookmark-btn w-full bg-white rounded-lg hover:bg-gray-400">
                                <ion-icon name="bookmark-outline" style="font-size: 35px; color:black">
                                </ion-icon>
                            </button>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach

            </div>


        </div>
    </div>

    <!-- Popup Modal -->
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-gray-800 p-6 rounded-lg max-w-lg w-full relative">
            <button onclick="closeModal()" class="absolute top-2 right-2 text-white text-xl">&times;</button>
            <img id="modal-image" src="" alt="News Image" class="w-full h-48 object-cover rounded-lg">
            <div class="flex gap-2">
                <h2 id="modal-title" class="text-lg font-semibold mt-2"></h2>

            </div>
            <p id="modal-date" class="text-sm text-gray-400 mt-1"></p>
            <p id="modal-summary" class="text-gray-300 mt-2"></p>
            <a id="modal-link" href="#" target="_blank"
                class="mt-4 block text-center bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-700">
                Baca Selengkapnya
            </a>
        </div>
    </div>


    <script>
        function openModal(image_url, title, published_at, summary, url) {
         
            document.getElementById("modal-image").src = image_url;
            document.getElementById("modal-title").textContent = title;
            document.getElementById("modal-date").textContent = new Date(published_at).toLocaleDateString();
            document.getElementById("modal-summary").textContent = summary;
            document.getElementById("modal-link").href = url;
            document.getElementById("modal").classList.remove("hidden");
        }

        function closeModal() {
            document.getElementById("modal").classList.add("hidden");
        }
    </script>
    <script>
        function toggleDropdown() {
            let dropdown = document.getElementById("dropdown-menu");
            dropdown.classList.toggle("hidden");
        }
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script>
        function toggleBookmark(beritaId) {
            fetch('/bookmark', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ berita_id: beritaId })
            })
            .then(response => response.json())
            .then(data => alert(data.message))
             .then(() => {
        location.reload(); // 🔥 REFRESH HALAMAN SETELAH BERHASIL
    })
            .catch(error => console.error('Error:', error));
        }
    
        function removeBookmark(beritaId) {
            fetch(`/bookmark/${beritaId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => alert(data.message))
            .then(() => {
        location.reload(); // 🔥 REFRESH HALAMAN SETELAH BERHASIL
    })
            .catch(error => console.error('Error:', error));
        }
        
        document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".bookmark-btn").forEach(button => {
            let beritaId = button.getAttribute("data-berita-id");

            fetch(`/bookmark/${beritaId}/check`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                let icon = button.querySelector("ion-icon");
                if (data.bookmarked) {



                    button.setAttribute("onclick", `removeBookmark(${beritaId})`);
                    icon.setAttribute("name", "bookmark");
                } else {

                    button.setAttribute("onclick", `toggleBookmark(${beritaId})`);
                    icon.setAttribute("name", "bookmark-outline");
                }
            });
        });
    });

    </script>
</body>

</html>