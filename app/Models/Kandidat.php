<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kandidat extends Model
{
    use HasFactory;

    protected $table = 'kandidats';

    protected $guarded = [];

    public $incrementing = false;
    protected $keyType = 'string';

    public function golongan()
    {
        return $this->belongsTo(Golongan::class);
    }

    public function jenisJabatan()
    {
        return $this->belongsTo(JenisJabatan::class);
    }

    public function eselon()
    {
        return $this->belongsTo(Eselon::class);
    }

    public function tingkatPendidikan()
    {
        return $this->belongsTo(TingkatPendidikan::class, 'tingkat_pendidikan_id');
    }

    public function bidangIlmu()
    {
        return $this->belongsTo(BidangIlmu::class, 'bidang_ilmu_id');
    }

    public function nilais()
    {
        return $this->hasMany(Nilai::class, 'nip', 'nip');
    }

    public function waspasNilais()
    {
        return $this->hasMany(WaspasNilai::class, 'nip', 'nip');
    }
}
