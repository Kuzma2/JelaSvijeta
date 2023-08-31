<?php

namespace App\Repositories;

use App\Interfaces\MealRepositoryInterface;
use App\Models\Meal;

class MealRepository implements MealRepositoryInterface
{
    public function getAllMeals(){
        $meals = Meal::all();
        $meals->makeHidden('translations');
        return $meals;
    }

    public function getMealsByTagId($query, $tag_id){
        $tags = explode(",", $tag_id);
        $query = Meal::whereHas('tags', function ($query) use ($tags) {
            $query->whereIn('tag_id', $tags);
        }, '=', count($tags));
        return $query; 
    }
    public function filterByCategoryId($query, $category_id){

    }
    public function paginateMeals($query, $per_page){

    }
    public function filterByDiffTime($diffTime){

    }
    public function loadTags($meals, $with){

    }
    public function loadIngredients($meals, $with){

    }
    public function loadCategories($meals, $with){

    }
    
}