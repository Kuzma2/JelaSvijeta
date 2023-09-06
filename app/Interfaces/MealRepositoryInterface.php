<?php

namespace App\Interfaces;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

interface MealRepositoryInterface
{
    public function getAllMeals();
    public function getMealsByTagId(Builder $query, string $tag_id);
    public function filterByCategoryId(Builder $query, int $category_id);
    public function paginateMeals(Builder $query, ?int $per_page);
    public function filterByDiffTime(Builder $query, int $diffTime);
    public function loadTags(Builder $query, array $with);
    public function loadIngredients(Builder $query, array $with);
    public function loadCategories(Builder $query, array $with);

}