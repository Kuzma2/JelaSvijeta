<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Status extends Model
{
    use HasFactory;

    protected $table = 'statuses';
    protected $fillable = ['title'];

    public function meal(): BelongsTo
    {
        return $this->belongsTo(Meal::class);
    }
}
