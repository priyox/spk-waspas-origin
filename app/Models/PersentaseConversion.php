<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersentaseConversion extends Model
{
    use HasFactory;

    protected $table = 'persentase_conversions';

    protected $fillable = [
        'kriteria_id',
        'min_persentase',
        'max_persentase',
        'nilai',
        'keterangan',
        'is_active',
        'order',
    ];

    protected $casts = [
        'kriteria_id' => 'integer',
        'min_persentase' => 'decimal:2',
        'max_persentase' => 'decimal:2',
        'nilai' => 'integer',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Relasi ke Kriteria
     */
    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }

    /**
     * Scope untuk hanya mengambil conversion yang aktif
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
     * Scope untuk filter berdasarkan kriteria
     */
    public function scopeByKriteria($query, $kriteriaId)
    {
        return $query->where('kriteria_id', $kriteriaId);
    }

    /**
     * Konversi persentase ke nilai berdasarkan kriteria
     */
    public static function konversi($persentase, $kriteriaId)
    {
        return self::active()
            ->byKriteria($kriteriaId)
            ->where('min_persentase', '<=', $persentase)
            ->where('max_persentase', '>=', $persentase)
            ->orderBy('order')
            ->first()?->nilai ?? 1; // Default 1 jika tidak ketemu
    }
}
