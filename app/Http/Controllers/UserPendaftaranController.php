<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Pendaftaran;
use App\Models\Setting;
use Illuminate\Http\Request;

class UserPendaftaranController extends Controller
{
    public function showPendaftaranForm()
    {
        $divisis = Divisi::all();
        $registrationStatus = Setting::where('key', 'pendaftaran')->first();
        return view('user.pendaftaran', compact('divisis', 'registrationStatus'));
    }

    public function store(Request $request)
    {
        $registrationStatus = Setting::where('key', 'pendaftaran')->first();
        if (!$registrationStatus || $registrationStatus->value == 'closed') {
            return back()->with('error', 'Pendaftaran saat ini sedang ditutup.');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|numeric',
            'hp' => 'required|numeric',
            'divisi_id' => 'required|exists:divisis,id',
            'alasan' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'nim.numeric' => 'NIM harus berupa angka.',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('pendaftaran', 'public');
        }

        Pendaftaran::create([
            'name' => $request->nama,
            'nim' => $request->nim,
            'hp' => $request->hp,
            'divisi_id' => $request->divisi_id,
            'alasan_bergabung' => $request->alasan,
            'gambar' => $gambarPath,
        ]);

        return redirect()->route('user.pendaftaran')->with('success', 'Pendaftaran berhasil! Terima kasih telah mendaftar.')->withFragment('pendaftaran-form');
    }
}