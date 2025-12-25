<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JabatanFungsional extends Model
{
    protected $table = 'jabatan_fungsionals';

    public $timestamps = false;

    protected $guarded = [];
    
   
    public function kandidats()
    {
        return $this->hasMany(Kandidat::class, 'jabatan_fungsional_id');
    }

    public function jenjang()
    {
        return $this->belongsTo(JenjangFungsional::class, 'jenjang_id');
    }
}
