<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    // Menampilkan halaman dashboard utama
    public function index()
    {
        return view('dashboard');
    }

    // Menampilkan halaman berita dengan pagination
    public function news(Request $request)
    {
        $page = $request->query('page', 1);
        $perPage = 6; // Jumlah berita per halaman
        $offset = ($page - 1) * $perPage;

        // Panggil API berita roket
        $newsResponse = Http::get('https://api.spaceflightnewsapi.net/v4/articles/', [
            'limit' => $perPage,
            'offset' => $offset
        ]);

        $newsData = $newsResponse->json();
        $news = $newsData['results'] ?? [];
        $totalNews = $newsData['count'] ?? 0; // Total berita untuk pagination

        return view('news', compact('news', 'page', 'perPage', 'totalNews'));
    }

    // Menampilkan halaman jadwal peluncuran roket
    public function launches(Request $request)
    {
        $page = $request->query('page', 1);
        $perPage = 6; // Jumlah peluncuran per halaman

        // Panggil API jadwal peluncuran roket
        $launchResponse = Http::get('https://ll.thespacedevs.com/2.3.0/launches/upcoming/', [
            'limit' => $perPage,
            'offset' => ($page - 1) * $perPage
        ]);

        $launchData = $launchResponse->json();
        $launches = $launchData['results'] ?? [];
        $totalLaunches = $launchData['count'] ?? 0; // Total peluncuran untuk pagination

        return view('launches', compact('launches', 'page', 'perPage', 'totalLaunches'));
    }
}
