<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\PenagihanDenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentDendaController extends Controller
{
    public function index()
    {
        $tagihan = PenagihanDenda::with(['peminjaman', 'user'])->get();
        return view('transaksi.pembayaran-denda.index', compact('tagihan'));
    }

    /**
     * Proses pembayaran denda dengan Midtrans.
     */
    public function createTransaction(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1',
        ]);

        try {
            PenagihanDenda::create([
                'peminjaman_id'  => $request->peminjaman_id,
                'user_id'        => $request->user_id,
                'gross_amount'   => $request->amount,
                'snap_token'     => null,
                'payment_status' => 'pending',
                'payment_method' => null,
                'payment_date'   => null,
            ]);

            return response()->json([
                'message'   => 'Data penagihan denda berhasil disimpan.',
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}
