<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasaJabatanRange extends Model
{
    use HasFactory;

    protected $table = 'masa_jabatan_ranges';

    protected $fillable = [
        'min_tahun',
        'max_tahun',
        'nilai',
        'keterangan',
        'is_active',
        'order',
    ];

    protected $casts = [
        'min_tahun' => 'decimal:2',
        'max_tahun' => 'decimal:2',
        'nilai' => 'integer',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Scope untuk hanya mengambil range yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk mengurutkan berdasarkan order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Cari nilai berdasarkan masa jabatan (dalam tahun)
     */
    public static function getNilaiByMasaJabatan($tahun)
    {
        return self::active()
            ->where(function ($query) use ($tahun) {
                $query->where(function ($q) use ($tahun) {
                    // min_tahun IS NULL OR tahun >= min_tahun
                    $q->whereNull('min_tahun')
                      ->orWhere('min_tahun', '<=', $tahun);
                })
                ->where(function ($q) use ($tahun) {
                    // max_tahun IS NULL OR tahun < max_tahun
                    $q->whereNull('max_tahun')
                      ->orWhere('max_tahun', '>', $tahun);
                });
            })
            ->orderBy('order')
            ->first()?->nilai ?? 1; // Default 1 jika tidak ketemu
    }
}
