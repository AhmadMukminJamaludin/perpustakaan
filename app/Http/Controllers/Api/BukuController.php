<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Mengambil semua data buku dan mengembalikannya dalam format JSON.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Misalnya, mengambil semua data buku. Anda dapat menggunakan pagination jika data banyak.
        $books = Buku::paginate(10);

        return response()->json($books);
    }
}
