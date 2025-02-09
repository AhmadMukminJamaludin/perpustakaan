<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $booking = Keranjang::with(['buku', 'user'])->get();
        return view('transaksi.booking.index', compact('booking'));
    }
}
