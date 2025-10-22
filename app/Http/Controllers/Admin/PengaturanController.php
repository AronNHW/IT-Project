<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaturanController extends Controller
{
    public function waSetting()
    {
        $pesan_diterima = Storage::disk('local')->get('wa_template_diterima.txt');
        $pesan_ditolak = Storage::disk('local')->get('wa_template_ditolak.txt');
        return view('admin.pengaturan.wa-setting', compact('pesan_diterima', 'pesan_ditolak'));
    }

    public function waUpdate(Request $request)
    {
        $request->validate([
            'pesan_diterima' => 'required|string',
            'pesan_ditolak' => 'required|string',
        ]);

        Storage::disk('local')->put('wa_template_diterima.txt', $request->pesan_diterima);
        Storage::disk('local')->put('wa_template_ditolak.txt', $request->pesan_ditolak);

        return redirect()->route('admin.pengaturan.wa.setting')->with('success', 'Pengaturan WhatsApp berhasil diperbarui.');
    }
}
