<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaspasNilai extends Model
{
    use HasFactory;

    protected $table = 'waspas_nilais';

    protected $guarded = [];

    public function jabatanTarget()
    {
        return $this->belongsTo(JabatanTarget::class, 'jabatan_target_id');
    }

    public function kandidat()
    {
        return $this->belongsTo(Kandidat::class, 'nip', 'nip');
    }
}
