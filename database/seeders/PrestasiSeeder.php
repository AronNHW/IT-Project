<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Prestasi;
use Carbon\Carbon;

class PrestasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Prestasi::create([
            'nim' => '11111111',
            'nama_mahasiswa' => 'Alpha',
            'program_studi' => 'Teknik Informatika',
            'ipk' => 3.90,
            'nama_kegiatan' => 'Lomba Coding Internasional',
            'waktu_penyelenggaraan' => Carbon::now(),
            'tingkat_kegiatan' => 'Internasional',
            'prestasi_yang_dicapai' => 'Juara 1',
            'keterangan' => 'Akademik',
            'bukti_prestasi' => 'path/to/bukti1.pdf', // Ada bukti
            'pembimbing' => 'Dr. Budi',
        ]);

        Prestasi::create([
            'nim' => '22222222',
            'nama_mahasiswa' => 'Bravo',
            'program_studi' => 'Teknik Informatika',
            'ipk' => 3.70,
            'nama_kegiatan' => 'Kejuaraan Catur Nasional',
            'waktu_penyelenggaraan' => Carbon::now(),
            'tingkat_kegiatan' => 'Nasional',
            'prestasi_yang_dicapai' => 'Juara 2',
            'keterangan' => 'Non-Akademik',
            'bukti_prestasi' => 'path/to/bukti2.pdf', // Ada bukti
            'pembimbing' => 'Prof. Susi',
        ]);

        Prestasi::create([
            'nim' => '33333333',
            'nama_mahasiswa' => 'Charlie',
            'program_studi' => 'Teknik Informatika',
            'ipk' => 3.50,
            'nama_kegiatan' => 'Pekan Olahraga Provinsi',
            'waktu_penyelenggaraan' => Carbon::now(),
            'tingkat_kegiatan' => 'Provinsi/Wilayah',
            'prestasi_yang_dicapai' => 'Juara 3',
            'keterangan' => 'Non-Akademik',
            'bukti_prestasi' => 'path/to/bukti3.jpg', // Ada bukti
            'pembimbing' => 'Mr. John',
        ]);

        Prestasi::create([
            'nim' => '44444444',
            'nama_mahasiswa' => 'Delta',
            'program_studi' => 'Teknik Informatika',
            'ipk' => 3.20,
            'nama_kegiatan' => 'Festival Seni Kabupaten',
            'waktu_penyelenggaraan' => Carbon::now(),
            'tingkat_kegiatan' => 'Kabupaten/Kota',
            'prestasi_yang_dicapai' => 'Partisipan',
            'keterangan' => 'Non-Akademik',
            'bukti_prestasi' => null, // Tidak ada bukti
            'pembimbing' => 'Ibu Ani',
        ]);

        Prestasi::create([
            'nim' => '55555555',
            'nama_mahasiswa' => 'Echo',
            'program_studi' => 'Teknik Informatika',
            'ipk' => 3.80,
            'nama_kegiatan' => 'Lomba Debat Internal Kampus',
            'waktu_penyelenggaraan' => Carbon::now(),
            'tingkat_kegiatan' => 'Internal (Kampus)',
            'prestasi_yang_dicapai' => 'Juara 1',
            'keterangan' => 'Akademik',
            'bukti_prestasi' => null, // Tidak ada bukti
            'pembimbing' => 'Dr. Rina',
        ]);
    }
}
