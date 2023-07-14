<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bottle extends Model
{
    use HasFactory;
    protected $table = 'wine_bottles';
    protected $fillable = [
        'name',
        'type_id',
        'image',
        'code_saq',
        'country_id',
        'price',
        'url_saq',
        'url_image',
        'description',
        'format',
        'vintage'
    ];

    public function type(){
        return $this->belongsTo(Type::class,'type_id');
    }

    public function country(){
        return $this->belongsTo(Country::class,'country_id');
    }

    public function cellars()
    {
    return $this->belongsToMany(Cellar::class, 'bottle_in_cellars')
                ->withPivot('quantity');
    }


}
