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

    public function remove(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required',
                'buku_id' => 'required'
            ]);
            
            $userId = $validated['user_id'];
            $bukuId = $validated['buku_id'];

            Keranjang::where('user_id', $userId)
                ->where('buku_id', $bukuId)
                ->delete();
            return redirect()->route('booking.index')
                             ->with('success', 'Booking berhasil dihapus.');
        } catch (\Exception $e) {
            \Log::error('Gagal menghapus booking: ' . $e->getMessage());
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Terjadi kesalahan saat menghapus booking.');
        }
    }
}
