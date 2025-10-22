<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->keyBy('key');
        return view('admin.setting.index', compact('settings'));
    }

    public function store(Request $request)
    {
        $status = $request->input('status_pendaftaran') ? 'open' : 'closed';

        Setting::updateOrCreate(
            ['key' => 'pendaftaran'],
            ['value' => $status]
        );

        return back()->with('success', 'Status pendaftaran berhasil diperbarui.');
    }

    public function updateProfile(Request $request)
    {
        $rules = [
            'site_name' => 'required|string|max:255',
            'visi' => 'required|string',
            'misi' => 'required|string',
            'deskripsi' => 'required|string',
            'nama_ketua' => 'nullable|string|max:255',
            'nama_wakil' => 'nullable|string|max:255',
            'nama_sekretaris' => 'nullable|string|max:255',
            'nama_bendahara' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        // Jika tidak ada logo yang sudah ada di database, maka logo wajib diisi
        $currentLogo = Setting::where('key', 'logo')->first();
        if (!$currentLogo || !$currentLogo->value) {
            $rules['logo'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }

        $request->validate($rules);

        $data = $request->only(['site_name', 'visi', 'misi', 'deskripsi', 'nama_ketua', 'nama_wakil', 'nama_sekretaris', 'nama_bendahara']);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            // Hapus logo lama jika ada
            if ($currentLogo && $currentLogo->value) {
                Storage::disk('public')->delete($currentLogo->value);
            }
            $file->move(public_path('uploads/logos'), $filename);
            Setting::updateOrCreate(
                ['key' => 'logo'],
                ['value' => 'uploads/logos/' . $filename]
            );
        }

        return back()->with('success', 'Profil website berhasil diperbarui.');
    }
}
