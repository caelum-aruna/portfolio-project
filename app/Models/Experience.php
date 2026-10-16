<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'position',
        'company',
        'period',
        'description',
        'type',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];
}
