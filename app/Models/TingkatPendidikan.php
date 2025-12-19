<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TingkatPendidikan extends Model
{
    use HasFactory;

    protected $table = 'tingkat_pendidikans';

    protected $guarded = [];

    public function kandidats()
    {
        return $this->hasMany(Kandidat::class, 'tingkat_pendidikan_id');
    }
}
