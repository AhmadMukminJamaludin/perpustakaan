<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $query = Keranjang::with(['buku', 'user']);

        if (Auth::user()->hasRole('pengunjung')) {
            $query->where('user_id', Auth::id());
        }

        $booking = $query->get();
        return view('transaksi.booking.index', compact('booking'));
    }
}
