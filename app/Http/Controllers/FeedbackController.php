<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'nomor' => 'required|numeric', // Ubah validasi untuk nomor HP
            'message' => 'required'
        ]);

        $name = $request->input('name');
        $nomor = $request->input('nomor'); // Mengambil input nomor HP
        $message = $request->input('message');

        // Nomor WhatsApp Admin
        $adminPhone = '6285369369517'; // Ganti dengan nomor WhatsApp admin Anda

        // Format pesan yang akan dikirim ke WhatsApp
        $whatsappMessage = "Nama: $name\nNomor HP: $nomor\nPesan: $message"; // Menampilkan nomor HP dalam pesan

        // Encode URL untuk WhatsApp
        $whatsappUrl = "https://wa.me/$adminPhone?text=" . urlencode($whatsappMessage);

        // Redirect ke URL WhatsApp
        return redirect()->away($whatsappUrl);
    }

}
