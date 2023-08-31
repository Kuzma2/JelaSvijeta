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
            //'category' => 'numeric|not_negative_integer',
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

        $with_keywords = $request->get('with');
        
        $with = explode(",", $with_keywords);

        $diffTime = $request->get('diff_time');

        $category_id = $request->get('category');

        if (!empty($lang))
            App::setLocale($lang);

            
        if (empty($per_page) and empty($tag_id) and empty($with_keywords) and empty($diffTime) and empty($category_id)){
            $meals = Meal::all();
            $meals->makeHidden('translations');
            return response()->json($meals);
        }

        //TODO implement using repository pattern (https://blog.devgenius.io/laravel-repository-design-pattern-a-quick-demonstration-5698d7ce7e1f)

        $query = Meal::query();
        if (!empty($tag_id)){

            $query = Meal::whereHas('tags', function ($query) use ($tags) {
                $query->whereIn('tag_id', $tags);
            }, '=', count($tags));
        }   

        if (!empty($category_id)){
            if ($category_id === '!NULL'){
                $query->whereNotNull('category_id');
            }
            else if ($category_id === 'NULL'){
                $query->whereNull('category_id');
            }
            else {
                $query->where('category_id', $category_id);
            }
        }
        

        if (!empty($diffTime)) {
            $query->where('created_at', '>=', now()->subSeconds($diffTime));
        }

        if (!empty($per_page))
        {
            $meals = $query->paginate($per_page);
        } 
        else {
            $meals = $query->paginate();
        }
        
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

        
        $meals->appends($request->except('page'));


        return response()->json($meals);
    }

}
