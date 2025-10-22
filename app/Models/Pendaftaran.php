<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $fillable = [
        'name',
        'nim',
        'hp',
        'prodi',
        'divisi_id',
        'alasan_bergabung',
        'status',
        'gambar',
    ];

    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }
}
