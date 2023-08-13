<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Ingredient extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    protected $table = 'ingredients';

    protected $fillable = ['slug'];

    public $translatedAttributes = ['title'];

    
    public function meals()
    {
        return $this->belongsToMany('meals');
    }
}
