<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'member_id',
        'name',
        'email',
        'nim',
        'telephone_number',
        'status',
        'decline_reason',
        'proof_of_payment'
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_CHECKING = 'proses cek';
    const STATUS_VALID = 'valid';
    const STATUS_REJECTED = 'ditolak';

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
