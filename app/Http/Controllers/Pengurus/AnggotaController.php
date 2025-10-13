<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use App\Models\Divisi;
use App\Models\Pendaftaran;
use App\Services\FonnteService; // Import FonnteService
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Import Log

class AnggotaController extends Controller
{

    public function calonAnggota()
    {
        $candidates = Pendaftaran::with('divisi')->whereNotIn('status', ['diterima', 'ditolak', 'Anggota Aktif', 'Rejected Stage 2'])->get();
        return view('pengurus.calon-anggota.index', compact('candidates'));
    }


    public function calonAnggotaTahap1()
    {
        $candidates = Pendaftaran::whereIn('status', ['diterima', 'ditolak'])->get();
        return view('pengurus.calon-anggota-tahap-1.index', compact('candidates'));
    }

    public function calonAnggotaTahap2()
    {
        $candidates = Pendaftaran::where('status', 'diterima')->get();
        return view('pengurus.calon-anggota-tahap-2.index', compact('candidates'));
    }

    public function approveCandidate(Pendaftaran $pendaftaran, FonnteService $fonnte)
    {
        $pendaftaran->status = 'diterima';
        $pendaftaran->save();

        // Kirim notifikasi WhatsApp
        $message = "Halo, {$pendaftaran->nama}
Terima kasih telah mendaftar sebagai calon Pengurus HIMA-TI Politeknik Negeri Tanah Laut periode 2025/2026.

Berdasarkan hasil seleksi administrasi, Anda dinyatakan lolos ke tahap wawancara.
Mohon tetap semangat dan persiapkan diri dengan baik.

Langkah selanjutnya:
1. Bergabung ke grup informasi seleksi melalui tautan berikut:
https://chat.whatsapp.com/HRWZs2tMXUP30Cc7x7aS1y?mode=ems_copy_c
2. Jadwal wawancara dan panduannya akan disampaikan melalui grup tersebut.
3. Pastikan selalu memantau informasi agar tidak ketinggalan jadwal.

Terima kasih atas antusiasme Anda untuk menjadi bagian dari HIMA-TI Politala.
– Departemen PSDM HIMA-TI Politala";
        $result = $fonnte->send($pendaftaran->hp, $message);

        if ($result['ok']) {
            return redirect()->back()->with('success', 'Calon diterima & notifikasi WhatsApp terkirim.');
        } else {
            Log::error('Fonnte Gagal Terkirim (Approve Pengurus)', ['response' => $result]);
            return redirect()->back()->with('warning', 'Calon diterima, tapi notifikasi WhatsApp gagal dikirim.');
        }
    }

    public function rejectCandidate(Pendaftaran $pendaftaran, FonnteService $fonnte)
    {
        $pendaftaran->status = 'ditolak';
        $pendaftaran->save();

        // Kirim notifikasi WhatsApp
        $message = "Halo, {$pendaftaran->nama}
Terima kasih telah mengikuti proses pendaftaran calon Pengurus HIMA-TI Politeknik Negeri Tanah Laut periode 2025/2026.

Berdasarkan hasil seleksi administrasi, saat ini Anda belum dapat melanjutkan ke tahap wawancara.
Kami sangat menghargai waktu dan antusiasme Anda dalam mengikuti proses ini.

Jangan berkecil hati, masih banyak kesempatan untuk berkontribusi dan terlibat dalam kegiatan HIMA-TI di masa mendatang.
Kami berharap Anda tetap semangat dan terus aktif mengembangkan diri.

Terima kasih telah menunjukkan minat untuk menjadi bagian dari HIMA-TI Politala.
– Departemen PSDM HIMA-TI Politala";
        $result = $fonnte->send($pendaftaran->hp, $message);

        if ($result['ok']) {
            return redirect()->back()->with('success', 'Calon ditolak & notifikasi WhatsApp terkirim.');
        } else {
            Log::error('Fonnte Gagal Terkirim (Reject Pengurus)', ['response' => $result]);
            return redirect()->back()->with('warning', 'Calon ditolak, tapi notifikasi WhatsApp gagal dikirim.');
        }
    }


    public function approveCandidateStage2(Pendaftaran $pendaftaran)
    {
        $pendaftaran->status = 'Anggota Aktif';
        $pendaftaran->save();

        return redirect()->route('pengurus.kelola-anggota-himati.index')->with('success', 'Calon anggota berhasil diterima menjadi anggota aktif.');
    }

    public function rejectCandidateStage2(Pendaftaran $pendaftaran)
    {
        $pendaftaran->status = 'Rejected Stage 2';
        $pendaftaran->save();

        return redirect()->route('pengurus.calon-anggota-tahap-2.index')->with('success', 'Calon anggota berhasil ditolak pada tahap 2.');
    }

    public function passInterview(Pendaftaran $pendaftaran)
    {
        $pendaftaran->status = 'Anggota Aktif';
        $pendaftaran->save();

        return redirect()->route('pengurus.kelola-anggota-himati.index')->with('success', 'Calon anggota berhasil lulus interview dan menjadi anggota aktif.');
    }

    public function kelolaAnggotaHimati()
    {
        $members = Pendaftaran::where('status', 'Anggota Aktif')->latest()->paginate(10);
        $semua_divisi = Divisi::all();
        return view('pengurus.kelola-anggota-himati.index', compact('members', 'semua_divisi'));
    }

    public function anggotaPerDivisi(Divisi $divisi)
    {
        $members = Pendaftaran::where('status', 'Anggota Aktif')
                                ->where('divisi_id', $divisi->id)
                                ->latest()
                                ->paginate(10);
        $semua_divisi = Divisi::all();
        return view('pengurus.kelola-anggota-himati.index', compact('members', 'divisi', 'semua_divisi'));
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

        return redirect()->route('pengurus.kelola-anggota-himati.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(Pendaftaran $anggotum)
    {
        $anggotum->delete();
        return redirect()->route('pengurus.calon-anggota.index')->with('success', 'Calon anggota berhasil dihapus.');
    }
}