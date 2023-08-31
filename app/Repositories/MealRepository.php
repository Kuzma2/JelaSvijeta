<?php

namespace App\Repositories;

use App\Interfaces\MealRepositoryInterface;
use App\Models\Meal;
use App\Models\Status;
use App\Models\Category;

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
        if ($category_id === '!NULL'){
            $query->whereNotNull('category_id');
        }
        else if ($category_id === 'NULL'){
            $query->whereNull('category_id');
        }
        else {
            $query->where('category_id', $category_id);
        }
        return $query;

    }
    public function paginateMeals($query, $per_page){
        if (!empty($per_page))
        {
            $meals = $query->paginate($per_page);
        } 
        else {
            $meals = $query->paginate();
        }
        return $meals;
    }
    public function filterByDiffTime($query, $diffTime){
        return $query->where('created_at', '>=', now()->subSeconds($diffTime));
    }
    public function loadTags($meals, $with){
        if(in_array('tags', $with)){
            $meals->load('tags');
        }
    }
    public function loadIngredients($meals, $with){
        if(in_array('ingredients', $with)){
            $meals->load('ingredients');
        } 
    }
    public function loadCategories($meals, $with){
        foreach ($meals as $meal) {
            $meal->status = Status::where('id', $meal->status_id)->get()->first()->title;
          
            if(in_array('category', $with)){
                $meal->category = Category::where('id', $meal->category_id)->get();
                $meal->category->makeHidden('translations');
            }

            if(in_array('ingredients', $with)){
                $meal->ingredients->makeHidden(['translations', 'pivot']);
            }  

            unset($meal->status_id);
            unset($meal->category_id);

            if(in_array('tags', $with)){
                $meal->tags->makeHidden(['translations', 'pivot']);
            }
        }
        $meals->makeHidden('translations');
    }
    
}