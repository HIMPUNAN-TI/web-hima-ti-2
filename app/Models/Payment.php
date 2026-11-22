<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_code',
        'event_id',
        'member_id',
        'name',
        'email',
        'nim',
        'telephone_number',
        'institution',
        'status',
        'decline_reason',
        'proof_of_payment'
    ];

    const STATUS_UNPAID = 'menunggu pembayaran';
    const STATUS_PENDING = 'menunggu verifikasi';
    const STATUS_CHECKING = 'proses cek';
    const STATUS_VALID = 'valid';
    const STATUS_REGISTERED = 'terdaftar';
    const STATUS_REJECTED = 'ditolak';
    const STATUS_EXPIRED = 'kedaluwarsa';

    /**
     * Generate nomor unik pendaftaran kegiatan
     */
    public static function generateRegistrationCode($eventId): string
    {
        do {
            $code = 'REG-' . str_pad((string)$eventId, 3, '0', STR_PAD_LEFT) . '-' . strtoupper(\Illuminate\Support\Str::random(6));
        } while (self::where('registration_code', $code)->exists());

        return $code;
    }

    public static function getDeclineReasons()
    {
        return [
            'Dana Belum diterima oleh pihak kami',
            'Data yang anda inputkan salah',
            'Bukti Terima tidak ada / belum diupload',
            'Dana yang diterima kurang atau tidak sesuai',
            'Lainnya'
        ];
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get public URL for proof of payment file.
     */
    public function getProofOfPaymentUrlAttribute(): ?string
    {
        if (empty($this->proof_of_payment)) {
            return null;
        }

        return asset('images/proof_of_payments/' . $this->proof_of_payment);
    }
}
