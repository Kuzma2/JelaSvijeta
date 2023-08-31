<?php

namespace App\Interfaces;

interface MealRepositoryInterface
{
    public function getAllMeals();
    public function getMealsByTagId($query, $tag_id);
    public function filterByCategoryId($query, $category_id);
    public function paginateMeals($query, $per_page);
    public function filterByDiffTime($query, $diffTime);
    public function loadTags($meals, $with);
    public function loadIngredients($meals, $with);
    public function loadCategories($meals, $with);

}