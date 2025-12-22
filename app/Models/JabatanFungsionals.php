<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JabatanFungsionals extends Model
{
    protected $table = 'jabatan_fungsionals';

    public $timestamps = false;

    protected $guarded = [];
    
   
    public function kandidats()
    {
        return $this->hasMany(Kandidat::class, 'jabatan_fungsional_id');
    }
}
