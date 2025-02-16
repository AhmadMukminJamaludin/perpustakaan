<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\PenagihanDenda;
use Illuminate\Http\Request;
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

    public function createPayment(Request $request)
    {
        $request->validate([
            'tagihan_id' => 'required|exists:penagihan_denda,id',
            'amount'     => 'required|numeric|min:1',
        ]);

        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = true;
        Config::$is3ds        = true;

        $penagihan = PenagihanDenda::with('user')->find($request->tagihan_id);

        if (!$penagihan) {
            return response()->json(['message' => 'Data penagihan tidak ditemukan.'], 404);
        }

        $order_id = $penagihan->order_id;

        $params = [
            'transaction_details' => [
                'order_id'     => $order_id,
                'gross_amount' => $request->amount,
            ],
            'customer_details' => [
                'first_name' => $penagihan->user->name,
                'email'      => $penagihan->user->email,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            $penagihan = PenagihanDenda::find($request->tagihan_id);
            $penagihan->update([
                'snap_token' => $snapToken,
            ]);

            return response()->json(['snapToken' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function notificationHandler(Request $request)
    {
        // Tangkap seluruh data notifikasi dari Midtrans
        $notif = $request->all();
        info('Midtrans Notification: ', $notif);

        // Misalnya, data notifikasi mengandung key: transaction_status dan order_id
        $transactionStatus = $notif['transaction_status'] ?? null;
        $orderId = $notif['order_id'] ?? null;

        if (!$orderId || !$transactionStatus) {
            return response()->json(['message' => 'Invalid notification'], 400);
        }

        // Cari data penagihan berdasarkan order_id
        $penagihan = PenagihanDenda::where('order_id', $orderId)->first();
        if (!$penagihan) {
            return response()->json(['message' => 'Data penagihan tidak ditemukan'], 404);
        }

        // Update payment_status berdasarkan status transaksi dari Midtrans
        // Contoh status: settlement, pending, deny, cancel, dll.
        if ($transactionStatus == 'settlement') {
            $penagihan->update([
                'payment_status' => 'settlement',
                'payment_date' => Carbon::now(),
            ]);
        } elseif (in_array($transactionStatus, ['deny', 'cancel'])) {
            $penagihan->update([
                'payment_status' => $transactionStatus,
                'payment_date' => Carbon::now(),
            ]);
        } else {
            // Status lain seperti pending, belum diupdate atau status khusus lainnya
            $penagihan->update([
                'payment_status' => $transactionStatus,
            ]);
        }

        return response()->json(['message' => 'Notification processed successfully'], 200);
    }
}
