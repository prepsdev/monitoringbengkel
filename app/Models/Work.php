<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    protected $fillable = [
        'no_spp',
        'plat_nomor',
        'jenis_kendaraan',
        'jenis_pekerjaan',
        'waktu',
        'tanggal',
        'status',
        'note',
        'job_desc',
    ];

    public function technicians()
    {
        return $this->belongsToMany(Technician::class);
    }
}
