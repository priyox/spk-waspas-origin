<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kandidat extends Model
{
    use HasFactory;

    protected $table = 'kandidats';

    protected $guarded = [];

    public function golongan()
    {
        return $this->belongsTo(Golongan::class);
    }

    public function jenis_jabatan()
    {
        return $this->belongsTo(JenisJabatan::class);
    }

    public function jabatan_fungsional()
    {
        return $this->belongsTo(JabatanFungsional::class);
    }

    public function jabatan_pelaksana()
    {
        return $this->belongsTo(JabatanPelaksana::class);
    }

    public function eselon()
    {
        return $this->belongsTo(Eselon::class);
    }

    public function tingkat_pendidikan()
    {
        return $this->belongsTo(TingkatPendidikan::class, 'tingkat_pendidikan_id');
    }

    public function jabatan_target()
    {
        return $this->belongsTo(JabatanTarget::class);
    }

    public function bidang_ilmu()
    {
        return $this->belongsTo(BidangIlmu::class, 'bidang_ilmu_id');
    }

    public function jurusan_pendidikan()
    {
        return $this->belongsTo(JurusanPendidikan::class, 'jurusan_pendidikan_id');
    }

    public function unit_kerja()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id');
    }

    public function nilais()
    {
        return $this->hasMany(Nilai::class, 'id');
    }

    public function waspasNilais()
    {
        return $this->hasMany(WaspasNilai::class, 'id');
    }
}
