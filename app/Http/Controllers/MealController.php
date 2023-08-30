<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meal;
use App\Models\Tag;
use App\Models\Status;
use App\Models\Category;
use App\Models\Ingredient;
use Illuminate\Support\Facades\DB;
use Astrotomic\Translatable\Translatable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Validator;

class MealController extends Controller
{
    use Translatable;


/**
     * Display the specified resource.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request){

        $rules = array(
            'per_page' => 'numeric|not_negative_integer',
            'tags' => 'non_negative_integer_array',
            'lang' => 'two_character_lang_tag',
            'with' => 'with_tag_false',
            'category' => 'numeric|not_negative_integer',
            'diff_time' => 'numeric|not_negative_integer',

        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()){
            return response()->json($validator->errors(), 401);
        }
        
        $per_page = $request->get('per_page');
        
        $lang = $request->get('lang');
        
        $tag_id = $request->get('tags');

        $tags = explode(",", $tag_id);

        $with = $request->get('with');
        
        $with = explode(",", $with);

        $diffTime = $request->get('diff_time');

        $category_id = $request->get('category');

        //TODO add validators

        App::setLocale($lang);

        //TODO implement using repository pattern (https://blog.devgenius.io/laravel-repository-design-pattern-a-quick-demonstration-5698d7ce7e1f)

        //return Meal::all();

        $query = Meal::query();
        $meals = new Meal();


        if (!empty($diffTime)) {
            $query->where('created_at', '>=', now()->subSeconds($diffTime));
        }


        //optimization group by meal, distinct not implemented
        //$q = Meal::query();
        //$q->join('meal_tag', 'meals.id', '=', 'meal_tag.meal_id')
        //  ->select('meal_id', DB::raw('GROUP_CONCAT(tag_id) as tag_ids'))
        //  ->groupBy('meal_id');
        
        //return Meal::all();

        //$mealIds = [];
        //$mealTags = $q->get();
        //return $mealTags;
        //foreach($mealTags as $item){
        //    $tagIdsArray = explode(',', $item->tag_ids);
            //return $tagIdsArray;
        //    if($tagIdsArray===$tags){
        //         return $item;
        //     }
        // }
        //return $mealIds;


        if (!empty($tag_id)){
            $mealsArray = [];
            for ($i = 0; $i < count($tags); $i++){
            $q = Meal::query();
            $q->join('meal_tag', 'meals.id', '=', 'meal_tag.meal_id')
            ->select('meals.*')
            ->where('tag_id', $tags[$i]);
            $mealsArray[$i] = $q->get();
        }
     
        $idArray = [];
        for ($i = 0; $i < count($mealsArray); $i++){
            $idArray[$i] = $mealsArray[$i]->pluck('id')->toArray();
        }
          
        $intersection = $idArray[0];
        for ($i = 1; $i < count($idArray); $i++){
            $intersection = array_intersect($intersection, $idArray[$i]);
        }

        
        $query->whereIn('id', $intersection);

        }

        if (!empty($category_id)){
            $query->where('meals.category_id', $category_id);
        }

        else {
            $meals = $query->paginate($per_page);
        }

        
        $meals = $query->paginate($per_page);

        
        if(in_array('tags', $with)){
            $meals->load('tags');
        }

        if(in_array('ingredients', $with)){
            $meals->load('ingredients');
        }     
        

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

        return response()->json($meals);
    }

}
