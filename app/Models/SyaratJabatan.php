<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyaratJabatan extends Model
{
    use HasFactory;

    protected $table = 'syarat_jabatans';

    protected $guarded = [];

    public function eselon()
    {
        return $this->belongsTo(Eselon::class);
    }
}
