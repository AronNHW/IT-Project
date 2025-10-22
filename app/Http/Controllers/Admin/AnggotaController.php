<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Divisi;
use App\Models\Pendaftaran;
use App\Services\FonnteService; // Import FonnteService
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Import Log
use Illuminate\Support\Facades\Storage;

class AnggotaController extends Controller
{

    public function calonAnggota()
    {
        $candidates = Pendaftaran::whereNotIn('status', ['diterima', 'ditolak', 'Anggota Aktif', 'Gagal Wawancara', 'Lulus Wawancara'])->get();
        return view('admin.calon-anggota.index', compact('candidates'));
    }

    public function calonAnggotaTahap1(Request $request)
    {
        $query = Pendaftaran::query()->with('divisi');

        $query->whereIn('status', ['diterima', 'ditolak', 'Gagal Wawancara', 'Lulus Wawancara']);

        // Search by name or NIM
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        // Filter by division
        if ($request->filled('divisi_id')) {
            $query->where('divisi_id', $request->divisi_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $candidates = $query->paginate(10)->withQueryString();

        $divisis = Divisi::all();
        $statuses = [
            'diterima' => 'Lolos ke Tahap 2',
            'ditolak' => 'Ditolak (Administrasi)',
            'Gagal Wawancara' => 'Gagal Wawancara',
            'Lulus Wawancara' => 'Lulus Wawancara (Anggota)'
        ];

        return view('admin.calon-anggota-tahap-1.index', compact('candidates', 'divisis', 'statuses'));
    }

    public function calonAnggotaTahap2()
    {
        $candidates = Pendaftaran::where('status', 'diterima')->get();
        return view('admin.calon-anggota-tahap-2.index', compact('candidates'));
    }

    public function approveCandidate(Pendaftaran $pendaftaran, FonnteService $fonnte)
    {
        $pendaftaran->status = 'diterima';
        $pendaftaran->save();

        // Kirim notifikasi WhatsApp
        $template = Storage::disk('local')->get('wa_template_diterima.txt');
        $message = str_replace(
            ['{nama}', '{nim}', '{divisi}'],
            [$pendaftaran->nama, $pendaftaran->nim, $pendaftaran->divisi->nama_divisi],
            $template
        );
        $result = $fonnte->send($pendaftaran->hp, $message);

        if ($result['ok']) {
            return redirect()->back()->with('success', 'Calon diterima & notifikasi WhatsApp terkirim.');
        } else {
            Log::error('Fonnte Gagal Terkirim (Approve)', ['response' => $result]);
            return redirect()->back()->with('warning', 'Calon diterima, tapi notifikasi WhatsApp gagal dikirim.');
        }
    }

    public function rejectCandidate(Pendaftaran $pendaftaran, FonnteService $fonnte)
    {
        $pendaftaran->status = 'ditolak';
        $pendaftaran->save();

        // Kirim notifikasi WhatsApp
        $template = Storage::disk('local')->get('wa_template_ditolak.txt');
        $message = str_replace(
            ['{nama}', '{nim}', '{divisi}'],
            [$pendaftaran->nama, $pendaftaran->nim, $pendaftaran->divisi->nama_divisi],
            $template
        );
        $result = $fonnte->send($pendaftaran->hp, $message);

        if ($result['ok']) {
            return redirect()->back()->with('success', 'Calon ditolak & notifikasi WhatsApp terkirim.');
        } else {
            Log::error('Fonnte Gagal Terkirim (Reject)', ['response' => $result]);
            return redirect()->back()->with('warning', 'Calon ditolak, tapi notifikasi WhatsApp gagal dikirim.');
        }
    }


    public function passInterview(Pendaftaran $pendaftaran)
    {
        $pendaftaran->status = 'Lulus Wawancara';
        $pendaftaran->save();

        return redirect()->route('admin.calon-anggota-tahap-2.index')->with('success', 'Kandidat telah dikonfirmasi lulus wawancara dan menjadi anggota aktif.');
    }

    public function failInterview(Pendaftaran $pendaftaran)
    {
        $pendaftaran->status = 'Gagal Wawancara';
        $pendaftaran->save();

        return redirect()->route('admin.calon-anggota-tahap-2.index')->with('success', 'Kandidat telah dikonfirmasi tidak lulus wawancara.');
    }

    public function kelolaAnggotaHimati()
    {
        $members = Pendaftaran::where('status', 'Lulus Wawancara')->latest()->paginate(10);
        $semua_divisi = Divisi::all();
        return view('admin.kelola-anggota-himati.index', compact('members', 'semua_divisi'));
    }

    public function anggotaPerDivisi(Divisi $divisi)
    {
        $members = Pendaftaran::where('status', 'Lulus Wawancara')
                                ->where('divisi_id', $divisi->id)
                                ->latest()
                                ->paginate(10);
        $semua_divisi = Divisi::all();
        return view('admin.kelola-anggota-himati.index', compact('members', 'divisi', 'semua_divisi'));
    }



    public function update(Request $request, Pendaftaran $anggotum)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|string|max:255',
            'hp' => 'required|string|max:255',
            'divisi_id' => 'required|exists:divisis,id',
        ]);

        $anggotum->update($request->only(['name', 'nim', 'hp', 'divisi_id']));

        return redirect()->route('admin.kelola-anggota-himati.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(Pendaftaran $anggotum)
    {
        $anggotum->delete();
        return redirect()->back()->with('success', 'Calon anggota berhasil dihapus.');
    }
}