<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidangIlmu extends Model
{
    use HasFactory;

    protected $table = 'bidang_ilmus';

    public $timestamps = false;

    protected $guarded = [];

    public function kandidats()
    {
        return $this->hasMany(Kandidat::class, 'bidang_ilmu_id');
    }

    public function jabatanTargets()
    {
        return $this->hasMany(JabatanTarget::class, 'id_bidang');
    }
}
