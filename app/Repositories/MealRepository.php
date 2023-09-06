<?php

namespace App\Repositories;

use App\Interfaces\MealRepositoryInterface;
use App\Models\Meal;
use App\Models\Status;
use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\MealResource;

class MealRepository implements MealRepositoryInterface
{
    public function getAllMeals(){
        $meals = Meal::all();
        $meals->makeHidden('translations');
        return MealResource::collection($meals);
    }

    public function getMealsByTagId(Builder $query, string $tag_id){
        $tags = explode(",", $tag_id);
        $query = $query->whereHas('tags', function ($query) use ($tags) {
            $query->whereIn('tag_id', $tags);
        }, '=', count($tags));
        return $query; 
    }
    public function filterByCategoryId(Builder $query, int $category_id){
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
    public function paginateMeals(Builder $query, ?int $per_page){
        if (!empty($per_page))
        {
            $meals = $query->paginate($per_page);
        } 
        else {
            $meals = $query->paginate();
        }
        return $meals;
    }
    public function filterByDiffTime(Builder $query, int $diffTime){
        return $query->where('created_at', '>=', now()->subSeconds($diffTime));
    }
    public function loadTags(Builder $query, array $with){
        if(in_array('tags', $with)){
            $query = $query->with('tags');
            return $query;
        }
    }
    public function loadIngredients(Builder $query, array $with){
        if(in_array('ingredients', $with)){
            $query = $query->with('ingredients');
            return $query;
        } 
    }
    public function loadCategories(Builder $query, array $with){
            if(in_array('category', $with)){
                $query = $query->with('category');
                return $query;
            }
    }
    
}