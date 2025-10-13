<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nim',
        'nama',
        'semester',
        'jenis_masalah',
        'keterangan',
        'kontak_pengadu',
        'lampiran',
        'anonim',
        'kode_tiket',
        'status',
    ];
}
