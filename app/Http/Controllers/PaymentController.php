<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function generateToken(Request $request)
    {
        // Pastikan order_id dikirim dari frontend
        $orderId = $request->input('order_id');
        
        // Cari order berdasarkan ID
        $order = Order::find($orderId);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }
        
        // Cari user berdasarkan user_id dari order
        $user = User::find($order->user_id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // Data transaksi untuk Midtrans
        $transactionDetails = [
            'order_id' => $order->order_number, // ambil order_number dari order
            'gross_amount' => $order->total_amount, // total_amount dari order
        ];

        $customerDetails = [
            'first_name' => $user->name, // nama user dari tabel user
            'email' => $user->email, // email user dari tabel user
        ];

        $transaction = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails,
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($transaction);

            // // Simpan status pembayaran di tabel payment jika diperlukan
            // $payment = new Payment();
            // $payment->order_id = $order->id;
            // $payment->status = 'pending'; // Status awal
            // $payment->snap_token = $snapToken;
            // $payment->save();

            return response()->json(['token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function handleCallback(Request $request)
    {
        // Ambil data callback dari Midtrans
        $callbackData = $request->all();

        // Log callback data (untuk debugging)
        Log::info('Midtrans Callback: ', $callbackData);

        // Pastikan signature key dari Midtrans valid
        if (!$this->isSignatureKeyValid($callbackData)) {
            return response()->json(['message' => 'Invalid signature key'], 403);
        }

        // Ambil data penting dari callback
        $orderNumber = $callbackData['order_id'];
        $transactionStatus = $callbackData['transaction_status'];
        $grossAmount = $callbackData['gross_amount'];
        $paymentDate = $callbackData['transaction_time'];

        // Cari data payment berdasarkan order_number
        $payment = Payment::whereHas('order', function($query) use ($orderNumber) {
            $query->where('order_number', $orderNumber);
        })->first();

        if (!$payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }

        // Update status_pembayaran dan order status berdasarkan transaction_status
        switch ($transactionStatus) {
            case 'settlement':  // Payment berhasil
                $payment->status = 'paid';
                $payment->date_payment = $paymentDate;
                $payment->total_bayar = $grossAmount;

                // Update status pesanan menjadi 'to ship'
                $order = $payment->order;
                $order->status = 'to ship';
                $order->save();
                break;

            case 'pending':  // Payment menunggu
                $payment->status = 'unpaid';
                break;

            case 'deny':  // Payment ditolak
            case 'expire':  // Payment kedaluwarsa
            case 'cancel':  // Payment dibatalkan
                $payment->status = 'failed';
                break;
        }

        // Simpan perubahan pada tabel payment
        $payment->save();

        return response()->json(['message' => 'Callback handled']);
    }

    private function isSignatureKeyValid($callbackData)
    {
        $serverKey = config('midtrans.server_key');
        $inputSignatureKey = $callbackData['signature_key'];

        $orderId = $callbackData['order_id'];
        $statusCode = $callbackData['status_code'];
        $grossAmount = $callbackData['gross_amount'];

        $computedSignatureKey = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        return $inputSignatureKey === $computedSignatureKey;
    }

}