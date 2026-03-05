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
        'type',
        'parent_event_name',
        'price',
        'date',
        'regist_start_date',
        'regist_end_date',
        'location',
        'description',
        'poster',
        'certificate',
        'maps',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'regist_start_date' => 'date',
            'regist_end_date' => 'date',
            'price' => 'decimal:2',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function getPosterUrlAttribute()
    {
        return $this->poster ? asset('image/events/posters/' . $this->poster) : null;
    }

    public function getCertificateUrlAttribute()
    {
        if ($this->certificate) {
            return asset('image/events/certificates/' . $this->certificate);
        }
        return asset('image/events/certificates/default.png');
    }
}
