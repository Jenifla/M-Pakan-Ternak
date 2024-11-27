<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Order;
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
        ]);

        // Simpan data pembatalan di tabel pembatalan
        Cancellation::create([
            'user_id' => auth()->id(),
            'order_id' => $validated['order_id'],
            'tgl_diajukan' => now(),
            'status_pembatalan' => 'pending',
        ]);

        // Update kolom 'alasan' di tabel orders
        $order = Order::findOrFail($validated['order_id']);
        $order->alasan = $validated['alasan'];
        $order->save();

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

        return redirect()->route('frontend.pages.account.order')->with('success', 'Cancellation request has been submitted successfully.');
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
    $buyer = $order->user;

    // Jika statusnya ditolak, simpan alasan penolakan
    if ($validated['status_pembatalan'] === 'ditolak' && isset($validated['alasan'])) {
        $cancellation->alasan = $validated['alasan']; // Menyimpan alasan penolakan
        $cancellation->tgl_diproses = now();

        $waMessage = "Yth {$buyer->name},\n\n" .
                     "Permohonan pembatalan pesanan Anda dengan nomor pesanan {$order->order_number} telah DITOLAK.\n" .
                     "Alasan penolakan: {$validated['alasan']}.\n\n" .
                     "Terima kasih.";
        WhatsAppService::sendMessage($buyer->no_hp, $waMessage);
    }

    // Simpan perubahan status
    $cancellation->save();

    // Jika status disetujui, update status pesanan menjadi dibatalkan
    if ($validated['status_pembatalan'] === 'disetujui') {
        $order = Order::find($orderId);
        $order->status = 'cancel'; // Ubah status pesanan menjadi dibatalkan
        $order->date_cancel = now();
        $order->save();

        $waMessage = "Yth {$buyer->name},\n\n" .
                     "Permohonan pembatalan pesanan Anda dengan nomor pesanan {$order->order_number} telah DISETUJUI.\n" .
                     "Pesanan Anda telah dibatalkan.\n\n" .
                     "Terima kasih.";
        WhatsAppService::sendMessage($buyer->no_hp, $waMessage);
    }

    return back()->with('success', 'Cancellation status updated successfully.');
}


}
