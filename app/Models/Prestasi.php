<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nim',
        'nama_mahasiswa',
        'ipk',
        'nama_kegiatan',
        'waktu_penyelenggaraan',
        'tingkat_kegiatan',
        'prestasi_yang_dicapai',
        'keterangan',
        'bukti_prestasi',
        'pembimbing',
    ];

    public function getTotalSkorAttribute()
    {
        // C1 - Tingkatan (bobot 0.25)
        $skorTingkatan = 0;
        switch ($this->tingkat_kegiatan) {
            case 'Internasional':
                $skorTingkatan = 30;
                break;
            case 'Nasional':
                $skorTingkatan = 24;
                break;
            case 'Provinsi/Wilayah':
                $skorTingkatan = 18;
                break;
            case 'Kabupaten/Kota':
                $skorTingkatan = 12;
                break;
            case 'Internal (Kampus)':
                $skorTingkatan = 6;
                break;
        }

        // C2 - Juara (bobot 0.44)
        $skorJuara = 0;
        switch ($this->prestasi_yang_dicapai) {
            case 'Juara 1':
                $skorJuara = 20;
                break;
            case 'Juara 2':
                $skorJuara = 15;
                break;
            case 'Juara 3':
                $skorJuara = 10;
                break;
            default: // Lainnya/Partisipan
                $skorJuara = 5;
                break;
        }

        // C3 - IPK (bobot 0.17)
        $skorIpk = ($this->ipk / 4.00) * 40;

        // C4 - Keterangan/Bukti (bobot 0.12)
        $skorBukti = 0;
        if ($this->keterangan == 'Akademik') {
            if ($this->bukti_prestasi) {
                $skorBukti = 10; // Akademik dengan bukti
            } else {
                $skorBukti = 5; // Akademik tanpa bukti
            }
        } elseif ($this->keterangan == 'Non-Akademik') {
            if ($this->bukti_prestasi) {
                $skorBukti = 8; // Non-akademik dengan bukti
            } else {
                $skorBukti = 3; // Non-akademik tanpa bukti
            }
        }

        // Hitung total skor
        $totalSkor = ($skorTingkatan * 0.25) + ($skorJuara * 0.44) + ($skorIpk * 0.17) + ($skorBukti * 0.12);

        return $totalSkor;
    }
}
