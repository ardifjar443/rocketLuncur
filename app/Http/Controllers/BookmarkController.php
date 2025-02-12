<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class BookmarkController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'berita_id' => 'required|integer'
        ]);

        // Cek apakah user sudah menandai berita ini
        $existing = Bookmark::where('user_id', Auth::id())
            ->where('berita_id', $request->berita_id)
            ->first();

        if ($existing) {
            return response()->json(['message' => 'Bookmark sudah ada!']);
        }

        Bookmark::create([
            'user_id' => Auth::id(),
            'berita_id' => $request->berita_id
        ]);

        return response()->json(['message' => 'Bookmark berhasil disimpan!']);
    }

    public function destroy($berita_id)
    {
        $bookmark = Bookmark::where('berita_id', $berita_id)
            ->where('user_id', Auth::id())
            ->first();

        if ($bookmark) {
            $bookmark->delete();
            return response()->json(['message' => 'Bookmark berhasil dihapus!']);
        }

        return response()->json(['message' => 'Bookmark tidak ditemukan!'], 404);
    }

    public function checkBookmark($berita_id)
    {
        $isBookmarked = Bookmark::where('user_id', Auth::id())
            ->where('berita_id', $berita_id)
            ->exists();

        return response()->json(['bookmarked' => $isBookmarked]);
    }
    public function index()
    {
        // Ambil semua id_berita dari database berdasarkan user yang sedang login
        $bookmarkedIds = Bookmark::where('user_id', Auth::id())->pluck('berita_id');

        $bookmarkedNews = [];


        foreach ($bookmarkedIds as $id) {
            $response = Http::get("https://api.spaceflightnewsapi.net/v4/articles/{$id}");

            if ($response->successful()) {
                $news = $response->json();

                // Terjemahkan judul dan ringkasan
                $translatedTitleResponse = Http::get('https://ftapi.pythonanywhere.com/translate', [
                    'sl' => 'en',
                    'dl' => 'id',
                    'text' => $news['title'] ?? ''
                ]);

                $translatedSummaryResponse = Http::get('https://ftapi.pythonanywhere.com/translate', [
                    'sl' => 'en',
                    'dl' => 'id',
                    'text' => $news['summary'] ?? ''
                ]);

                $news['title'] = $translatedTitleResponse->json()['destination-text'] ?? $news['title'];
                $news['summary'] = $translatedSummaryResponse->json()['destination-text'] ?? $news['summary'];

                $bookmarkedNews[] = $news;
            }
        }
        foreach ($bookmarkedIds as $id) {
            $response = Http::get("https://api.spaceflightnewsapi.net/v4/articles/{$id}");

            if ($response->successful()) {
                $bookmarkedNews[] = $response->json();
            }
        }

        return view('bookmarks', compact('bookmarkedNews'));
    }
}
