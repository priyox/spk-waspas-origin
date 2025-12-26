<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kandidat extends Model
{
    use HasFactory;

    protected $table = 'kandidats';

    protected $fillable = [
        'nip', 'nama', 'tempat_lahir', 'tanggal_lahir', 
        'golongan_id', 'jenis_jabatan_id', 'eselon_id', 
        'jabatan', 'unit_kerja_id', 'tingkat_pendidikan_id', 
        'jurusan_pendidikan_id', 'bidang_ilmu_id', 'tmt_golongan', 'tmt_jabatan',
        'kn_id_diklat', 'kn_id_skp', 'kn_id_penghargaan', 'kn_id_integritas',
        'kn_id_potensi', 'kn_id_kompetensi'
    ];

    public function golongan()
    {
        return $this->belongsTo(Golongan::class);
    }

    public function jenis_jabatan()
    {
        return $this->belongsTo(JenisJabatan::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships for Static Criteria
    |--------------------------------------------------------------------------
    */
    public function knDiklat()
    {
        return $this->belongsTo(KriteriaNilai::class, 'kn_id_diklat');
    }

    public function knSkp()
    {
        return $this->belongsTo(KriteriaNilai::class, 'kn_id_skp');
    }

    public function knPenghargaan()
    {
        return $this->belongsTo(KriteriaNilai::class, 'kn_id_penghargaan');
    }

    public function knIntegritas()
    {
        return $this->belongsTo(KriteriaNilai::class, 'kn_id_integritas');
    }

    public function knPotensi()
    {
        return $this->belongsTo(KriteriaNilai::class, 'kn_id_potensi');
    }

    public function knKompetensi()
    {
        return $this->belongsTo(KriteriaNilai::class, 'kn_id_kompetensi');
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

    public function unitKerja()
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
    public function isDinilai()
    {
        // Columns for dynamic criteria that must be filled
        $columns = [
            'kn_id_skp', 
            'kn_id_penghargaan', 
            'kn_id_integritas', 
            'kn_id_diklat', 
            'kn_id_potensi', 
            'kn_id_kompetensi'
        ];

        foreach ($columns as $col) {
            if (is_null($this->$col)) {
                return false;
            }
        }

        return true;
    }
}
