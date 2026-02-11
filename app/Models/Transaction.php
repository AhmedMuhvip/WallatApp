<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'client_id',
        'amount',
        'bank_id',
        'status',
        'type',
        'date',
        'description',
        'reference',
        'meta_data'
    ];

    protected function casts(): array
    {
        return [
            'meta_data' => 'array',
            'amount' => 'double',
        ];
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
