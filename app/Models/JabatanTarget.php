<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JabatanTarget extends Model
{

    protected $table = 'jabatan_targets';

    protected $guarded = [];

    public function eselon()
    {
        return $this->belongsTo(Eselon::class, 'id_eselon');
    }

    public function bidangIlmu()
    {
        return $this->belongsTo(BidangIlmu::class, 'id_bidang');
    }
}
