<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
        'name',
        'price',
        'quota',
        'date',
        'regist_start_date',
        'regist_end_date',
        'location',
        'maps',
        'description',
        'poster',
        'certificate',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'regist_start_date' => 'date',
            'regist_end_date' => 'date',
            'price' => 'decimal:2',
            'quota' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'event_id');
    }

    /**
     * Menghitung total pendaftar aktif (bukan ditolak)
     */
    public function getRegisteredCountAttribute(): int
    {
        return $this->payments()
            ->where('status', '!=', Payment::STATUS_REJECTED)
            ->count();
    }

    /**
     * Sisa kuota peserta
     */
    public function getRemainingQuotaAttribute(): ?int
    {
        if (is_null($this->quota)) {
            return null;
        }

        return max(0, $this->quota - $this->registered_count);
    }

    /**
     * Memeriksa apakah kuota kegiatan sudah penuh
     */
    public function isFull(): bool
    {
        return !is_null($this->quota) && $this->registered_count >= $this->quota;
    }

    /**
     * Memeriksa apakah batas pendaftaran telah berakhir
     */
    public function isDeadlinePassed(): bool
    {
        if (!$this->regist_end_date) {
            return false;
        }

        return \Carbon\Carbon::parse($this->regist_end_date)->endOfDay()->isPast();
    }

    /**
     * Memeriksa apakah kegiatan gratis
     */
    public function isFree(): bool
    {
        return floatval($this->price) <= 0;
    }

    public function getPosterUrlAttribute()
    {
        return $this->poster ? asset('image/events/posters/' . $this->poster) : null;
    }

    public function getCertificateUrlAttribute()
    {
        return $this->certificate ? asset('image/events/certificates/' . $this->certificate) : null;
    }
}
