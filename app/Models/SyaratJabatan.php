<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyaratJabatan extends Model
{
    use HasFactory;

    protected $table = 'syarat_jabatans';

    protected $guarded = [];

    public function eselon()
    {
        return $this->belongsTo(Eselon::class);
    }

    public function minimalGolongan()
    {
        return $this->belongsTo(Golongan::class, 'minimal_golongan_id');
    }

    public function minimalTingkatPendidikan()
    {
        return $this->belongsTo(TingkatPendidikan::class, 'minimal_tingkat_pendidikan_id');
    }

    public function minimalEselon()
    {
        return $this->belongsTo(Eselon::class, 'minimal_eselon_id');
    }

    public function syaratGolongan()
    {
        return $this->belongsTo(Golongan::class, 'syarat_golongan_id');
    }
}
