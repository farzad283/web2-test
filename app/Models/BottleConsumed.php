<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BottleConsumed extends Model
{
    use HasFactory;
    protected $table = 'bottles_consumed';
    protected $fillable = [     
        'bottle_id',
        'cellar_id',
        'consumption_date',
        'note'
    ];

    // NE PAS RETIRER, À VOIR ENSEMBLE, ÇA PEUT NOUS SIMPLIFIER LA VIE

   /*  public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cellar()
    {
        return $this->belongsTo(Cellar::class);
    } */
}

