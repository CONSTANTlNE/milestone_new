<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quotationb2b extends Model
{
    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime',
        'specs_links' => 'array',
        'surcharges' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'sent_by_id');
    }

}
