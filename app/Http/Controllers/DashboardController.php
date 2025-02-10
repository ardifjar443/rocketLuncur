<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        // API berita roket
        $newsResponse = Http::get('https://api.spaceflightnewsapi.net/v4/articles/');
        $news = $newsResponse->json()['results'] ?? [];

        // API jadwal penerbangan roket
        $launchResponse = Http::get('https://ll.thespacedevs.com/2.3.0/launches/upcoming/');
        $launches = $launchResponse->json()['results'] ?? [];

        return view('dashboard', compact('news', 'launches'));
    }
}
