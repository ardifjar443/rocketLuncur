<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: black;
            color: black;
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

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans antialiased ">

    <div class="min-h-screen bg-black stars">
        <div class="  p-2  w-full rounded-b-xl top-0 fixed flex flex-row z-50 text-white bg-black">
            <div class="flex gap-2 items-center"><img src="/img/startup.png" class="w-10  " alt="">
                <p class="text-2xl font-bold">RocketLuncur</p>
            </div>
            <div class="flex item-center px-10 justify-between  w-full">
                <div class="flex items-center gap-3 "><a href="/berita">Berita</a><a href="/jadwal">Jadwal</a>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7">
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
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-500">
                        Login
                    </a>
                    @endguest
                </div>

            </div>
        </div>
        {{-- @include('layouts.navigation') --}}

        <!-- Page Heading -->
        {{-- @isset($header)
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endisset --}}

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    <script>
        function toggleDropdown() {
                    let dropdown = document.getElementById("dropdown-menu");
                    dropdown.classList.toggle("hidden");
                }
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>