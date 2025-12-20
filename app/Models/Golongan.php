<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Golongan extends Model
{
    use HasFactory;

    protected $table = 'golongans';

    public $timestamps = false;

    protected $guarded = [];
    
    public $incrementing = false; // ID manual
    protected $keyType = 'int';

    public function kandidats()
    {
        return $this->hasMany(Kandidat::class, 'golongan_id');
    }
}
