<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\Interfaces\MealRepositoryInterface;
use App\Repositories\MealRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(MealRepositoryInterface::class, MealRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Validator::extend('not_negative_integer', function ($attribute, $value, $parameters, $validator) {
            return intval($value) == $value && $value >= 0;
        });

        Validator::extend('non_negative_integer_array', function ($attribute, $value, $parameters, $validator) {
            $numbers = explode(',', $value);
            
            foreach ($numbers as $number) {
                if (!is_numeric($number) || intval($number) != $number || $number < 0) {
                    return false;
                }
            }
            
            return true;
        });

        Validator::extend('two_character_lang_tag', function ($attribute, $value, $parameters, $validator) {
            return is_string($value) && strlen($value) === 2;
        });

        Validator::extend('with_tag_false', function ($attribute, $value, $parameters, $validator) {
            if (empty($value)) {
                return true; 
            }
            $expectedWords = ['ingredients', 'category', 'tags'];
            $words = explode(',', $value);
            
            if (count($words) > count($expectedWords)) {
                return false;
            }
            
            foreach ($words as $word) {
                if (!in_array(trim($word), $expectedWords)) {
                    return false;
                }
            }
            
            return true;
        });
    }

}
