<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pair extends Model
{
    use HasFactory;

    protected $fillable = [
        'source_currency_id',
        'target_currency_id',
        'rate',
        'nb_conversions'
    ];

}
