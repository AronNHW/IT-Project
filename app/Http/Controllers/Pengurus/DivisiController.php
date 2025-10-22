<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DivisiController extends Controller
{
    public function index()
    {
        $divisis = Divisi::latest()->paginate(10);
        return view('pengurus.divisi.index', compact('divisis'));
    }

    public function create()
    {
        return view('pengurus.divisi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_divisi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'photo_divisi' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only(['nama_divisi', 'deskripsi']);

        if ($request->hasFile('photo_divisi')) {
            $data['photo_divisi'] = $request->file('photo_divisi')->store('divisi', 'public');
        }

        Divisi::create($data);

        return redirect()->route('pengurus.divisi.index')->with('success', 'Divisi berhasil ditambahkan.');
    }

    public function show(Divisi $divisi)
    {
        return view('pengurus.divisi.show', compact('divisi'));
    }

    public function edit(Divisi $divisi)
    {
        return view('pengurus.divisi.edit', compact('divisi'));
    }

    public function update(Request $request, Divisi $divisi)
    {
        $request->validate([
            'nama_divisi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'photo_divisi' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only(['nama_divisi', 'deskripsi']);

        if ($request->hasFile('photo_divisi')) {
            if ($divisi->photo_divisi) {
                Storage::disk('public')->delete($divisi->photo_divisi);
            }
            $data['photo_divisi'] = $request->file('photo_divisi')->store('divisi', 'public');
        }

        $divisi->update($data);

        return redirect()->route('pengurus.divisi.index')->with('success', 'Divisi berhasil diperbarui.');
    }

    public function destroy(Divisi $divisi)
    {
        if ($divisi->photo_divisi) {
            Storage::disk('public')->delete($divisi->photo_divisi);
        }
        $divisi->delete();

        return redirect()->route('pengurus.divisi.index')->with('success', 'Divisi berhasil dihapus.');
    }
}
