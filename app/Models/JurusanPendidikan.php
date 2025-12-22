<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurusanPendidikan extends Model
{
    use HasFactory;
    public function tingkat_pendidikan()
    {
        return $this->belongsTo(TingkatPendidikan::class, 'tingkat_pendidikan_id');
    }
    
    public function bidang_ilmu()
    {
        return $this->belongsTo(BidangIlmu::class, 'bidang_ilmu_id');
    }
}
