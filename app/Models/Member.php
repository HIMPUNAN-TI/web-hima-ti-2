<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'members';

    protected $fillable = [
        'user_id',
        'nim',
        'email',
        'telephone_number',
        'prodi',
        'generation',
        'is_stikom',
        'ktm_ktp_path',
    ];

    protected function casts(): array
    {
        return [
            'is_stikom' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'member_id');
    }

    public function getFullInfoAttribute()
    {
        return [
            'name' => $this->user->name ?? null,
            'nim' => $this->nim,
            'email' => $this->email,
            'prodi' => $this->prodi,
            'generation' => $this->generation,
        ];
    }
}