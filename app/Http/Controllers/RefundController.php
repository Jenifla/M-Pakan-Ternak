<?php

namespace App\Http\Controllers;

use App\Models\Refund;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    public function edit($refundId)
    {
        $refund = Refund::find($refundId);
        return view('backend.order.edit', compact('refund'));
    }

    // Mengupdate data refund
    public function update(Request $request, $refundId)
    {
        $validated = $request->validate([
            'total_refund' => 'required|numeric|min:1',
            'status' => 'required|in:completed',
            'bukti_transfer' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'date_transfer' => 'required|date',
        ]);

        $refund = Refund::find($refundId);
        
        if (!$refund) {
            return back()->with('error', 'Refund not found.');
        }
        
        $refund->total_refund = $validated['total_refund'];
        $refund->status = $validated['status'];
        $refund->date_transfer = $validated['date_transfer'];

        // Menangani upload bukti transfer (jika ada)
        // Menangani upload bukti transfer
        if ($request->hasFile('bukti_transfer')) {
            // Ambil file dari request
            $file = $request->file('bukti_transfer');

            // Tentukan nama file unik
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Tentukan path tujuan di folder public
            $destinationPath = public_path('images/');

            // Pindahkan file ke folder public
            $file->move($destinationPath, $fileName);

            // Simpan path file ke database
            $refund->bukti_transfer = 'images/' . $fileName;
        }

        $refund->save();

        return redirect()->route('order.index')->with('success', 'Refund status updated successfully.');
    }

}
