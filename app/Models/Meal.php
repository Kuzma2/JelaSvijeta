<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;


class Meal extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    protected $table = 'meals';

    public $translatedAttributes = ['title', 'description'];
    protected $fillable = ['status_id', 'category_id'];

    public $timestamps = true;

    public function status(): BelongsTo
{
    return $this->belongsTo(Status::class, 'status_id');
}

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'ingredient_meal');
    }

    public function tags()
{
    return $this->belongsToMany(Tag::class, 'meal_tag');
}

}
