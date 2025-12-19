<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Golongan extends Model
{
    use HasFactory;

    protected $table = 'golongans';

    protected $guarded = [];

    public function kandidats()
    {
        return $this->hasMany(Kandidat::class, 'golongan_id');
    }
}
