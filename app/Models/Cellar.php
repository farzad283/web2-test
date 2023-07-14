<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cellar extends Model
{
    use HasFactory;
    protected $table = 'cellars';
    protected $fillable = [
        'name',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function bottles()
    {
    return $this->belongsToMany(Bottle::class, 'bottle_in_cellars')
                ->withPivot('quantity'); // pour récuperer la donnée quantité 
    }

}
