<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JabatanTarget extends Model
{

    protected $table = 'jabatan_targets';

    protected $guarded = [];

    public function eselon()
    {
        return $this->belongsTo(Eselon::class);
    }

    public function bidang_ilmu()
    {
        return $this->belongsTo(BidangIlmu::class, 'bidang_ilmu_id');
    }
}
