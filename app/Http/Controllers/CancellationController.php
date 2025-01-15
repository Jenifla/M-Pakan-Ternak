<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Order;
use App\Models\Refund;
use App\Models\Cancellation;
use Illuminate\Http\Request;
use App\Services\WhatsAppService;

class CancellationController extends Controller
{

    public function store(Request $request)
{
    $validated = $request->validate([
        'order_id' => 'required|exists:orders,id',
        'alasan' => 'required|string|min:5',
        'bank_name' => 'nullable|string',
        'bank_account' => 'nullable|string',
        'bank_holder' => 'nullable|string',
    ]);

    // Cari order yang akan dibatalkan
    $order = Order::findOrFail($validated['order_id']);

    // Cek status pesanan
    if (!in_array($order->status, ['to ship'])) {
        return redirect()->route('frontend.pages.account.order')->with('error', 'Pembatalan tidak diizinkan untuk status pesanan ini.');
    }

    // Simpan data pembatalan di tabel pembatalan
    $cancellation = Cancellation::create([
        'user_id' => auth()->id(),
        'order_id' => $validated['order_id'],
        'tgl_diajukan' => now(),
        'status_pembatalan' => 'pending',
    ]);

    // Update kolom 'alasan' di tabel orders
    $order->alasan = $validated['alasan'];
    $order->save();

    // Jika metode pembayaran adalah online payment, simpan data refund
    if ($order->payment->method_payment === 'online payment') {
        Refund::create([
            'cancellation_id' => $cancellation->id,
            'order_id' => $validated['order_id'],
            'bank_name' => $validated['bank_name'],
            'bank_account' => $validated['bank_account'],
            'bank_holder' => $validated['bank_holder'],
            'status' => 'pending',
        ]);
    }

    // Kirim notifikasi ke admin
    $admin = User::where('role', 'admin')->where('status', 'active')->first();
    if ($admin) {
        $waMessage = "Pengajuan pembatalan pesanan:\n" .
                    "Nomor Pesanan: {$order->order_number}\n" .
                    "Alasan: {$validated['alasan']}\n" .
                    "Tanggal Diajukan: " . now()->format('Y-m-d H:i:s') . "\n" .
                    "Status: Pending\n\n" .
                    "Silakan cek dan tindak lanjuti permintaan pembatalan.";
        WhatsAppService::sendMessage($admin->no_hp, $waMessage);
    }

    return redirect()->route('frontend.pages.account.order')->with('success', 'Permintaan pembatalan telah berhasil diajukan.');
}


public function updateStatus(Request $request, $orderId)
{
    // Validasi input
    $validated = $request->validate([
        'status_pembatalan' => 'required|in:disetujui,ditolak', // Validasi hanya menerima 'disetujui' atau 'ditolak'
        'alasan' => 'nullable|string', // Alasan untuk penolakan (opsional)
    ]);

    // Cari data pembatalan berdasarkan ID
    $cancellation = Cancellation::where('order_id', $orderId)->first();

    // Jika data pembatalan tidak ditemukan, kembalikan error
    if (!$cancellation) {
        return back()->with('error', 'Cancellation request not found.');
    }

    // Cek jika status pembatalan sudah diproses sebelumnya
    if ($cancellation->status_pembatalan !== 'pending') {
        return back()->with('error', 'Cancellation request has already been processed.');
    }

    // Update status pembatalan
    $cancellation->status_pembatalan = $validated['status_pembatalan'];
    $order = Order::find($orderId);
    $buyer = $order->user; // Informasi pengguna diambil dari relasi order->user

    // Cari entri refund terkait (jika ada)
    $refund = Refund::where('order_id', $orderId)->first();

    // Jika statusnya ditolak, simpan alasan penolakan
    if ($validated['status_pembatalan'] === 'ditolak' && isset($validated['alasan'])) {
        $cancellation->alasan = $validated['alasan'];
        $cancellation->tgl_diproses = now();
        // Jika ada entri refund, ubah statusnya menjadi rejected
        if ($refund) {
            $refund->status = 'rejected';
            $refund->save();
        }

        // Kirim notifikasi via WhatsApp
        $waMessage = "Yth {$buyer->name},\n\n" .
                     "Permohonan pembatalan pesanan Anda dengan nomor pesanan {$order->order_number} telah DITOLAK.\n" .
                     "Alasan penolakan: {$validated['alasan']}.\n\n" .
                     "Terima kasih.";
        WhatsAppService::sendMessage($buyer->no_hp, $waMessage);
    }

    

    // Jika status disetujui
    if ($validated['status_pembatalan'] === 'disetujui') {
        $cancellation->tgl_diproses = now();
        $order = Order::find($orderId);
        $order->status = 'cancel';
        $order->date_cancel = now();
        $order->save();

        // Jika ada entri refund, ubah statusnya menjadi accepted
        if ($refund) {
            $refund->status = 'approved';
            $refund->save();
        }

        // Kirim notifikasi via WhatsApp
        $waMessage = "Yth {$buyer->name},\n\n" .
                     "Permohonan pembatalan pesanan Anda dengan nomor pesanan {$order->order_number} telah DISETUJUI.\n" .
                     "Pesanan Anda telah dibatalkan.\n";

        if ($order->payment->method_payment !== 'cod') {
            $waMessage .= "Proses pengembalian dana Anda sedang berlangsung.\n";
        }

        $waMessage .= "Terima kasih.";
        WhatsAppService::sendMessage($buyer->no_hp, $waMessage);
    }

    // Simpan perubahan status pembatalan
    $cancellation->save();

    return back()->with('success', 'Cancellation status updated successfully.');
}



}
