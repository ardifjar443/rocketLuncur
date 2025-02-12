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

<body class="stars bg-black bg-fixed">



    <div class="  p-2  w-full rounded-b-xl top-0 fixed flex flex-row z-50">
        <div class="flex gap-2 items-center"><img src="/img/startup.png" class="w-10  " alt="">
            <p class="text-2xl font-bold">RocketLuncur</p>
        </div>
        <div class="flex item-center px-10 justify-between  w-full">
            <div class="flex items-center gap-3 "><a href="/berita">Berita</a><a class="underline underline-offset-4"
                    href="/jadwal">Jadwal</a>
            </div>

            <div class="flex gap-2">
                @auth
                <a href="/bookmarks" class=" flex justify-center items-center">
                    <ion-icon name="bookmark-outline" size="large" className="bg-black"></ion-icon>
                </a>
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

    @if(!empty($launches))

    <div class="grid grid-cols-3  gap-4 mt-20">
        @foreach($launches as $launch)
        <div class="p-4 rounded-lg shadow-md flex flex-col ">
            <img src="{{ $launch['image']['thumbnail_url'] ?? 'https://via.placeholder.com/100' }}" alt="Rocket Image"
                class=" w-full object-cover rounded-t-lg">
            <div class="bg-white rounded-b-lg text-black p-3">
                <div class="flex gap-1 justify-between">
                    <h3 class="text-lg font-semibold">{{ $launch['name'] }}</h3>
                    <div class="bg-black p-2 rounded-xl text-white">
                        <p class=" font-semibold">
                            {{ $launch['launch_service_provider']['name'] ?? 'Tidak Diketahui' }}
                        </p>
                    </div>
                </div>
                <p class=" font-semibold mt-1">📍 {{ $launch['pad']['location']['name'] }}</p>
                <div class="p-2 w-full bg-gray-300 rounded-lg ">
                    <p id="countdown-{{ $loop->index }}" class=" text-xl mt-1 font-bold text-center "> Menghitung
                        mundur...</p>
                </div>
                {{-- <div class="p-2 w-full bg-red-600 rounded-lg flex justify-center items-center mt-2">
                    <ion-icon name="logo-youtube" style="font-size: 35px; color:white "></ion-icon>
                </div> --}}


            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="min-h-screen flex justify-center items-center">
        <div class="bg-white p-3 rounded-xl font-bold text-2xl text-black">tidak ada jadwal</div>
    </div>
    @endif

    <script>
        function toggleDropdown() {
                    let dropdown = document.getElementById("dropdown-menu");
                    dropdown.classList.toggle("hidden");
                }
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let countdowns = [];
    
            @foreach($launches as $index => $launch)
                countdowns.push({
                    id: "countdown-{{ $index }}",
                    launchTime: new Date("{{ $launch['window_start'] }}").getTime()
                });
            @endforeach
    
            function startCountdown() {
                countdowns.forEach(item => {
                    let countdownElement = document.getElementById(item.id);
                    function updateCountdown() {
                        let now = new Date().getTime();
                        let timeLeft = item.launchTime - now;
    
                        if (timeLeft <= 0) {
                            countdownElement.textContent = "Sudah Diluncurkan!";
                            return;
                        }
    
                        let days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                        let hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        let minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                        let seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
    
                        countdownElement.textContent = `${days}d ${hours}h ${minutes}m ${seconds}s`;
                    }
    
                    updateCountdown();
                    setInterval(updateCountdown, 1000);
                });
            }
    
            startCountdown();
        });
    </script>


</body>

</html>