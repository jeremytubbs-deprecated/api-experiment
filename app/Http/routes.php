<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


// api/contents/
// api/contents/1234

// api/contents?q=search
// api/contents?page=2
// api/contents?limit=10
// api/contents?fields=title

// api/contents?filter[category]=art&filter[type]=project
// or
// api/contents?category=art&type=projects

// api/contents?filter[type]=posts
// or
// api/contents?type=posts
// or
// api/type/1234/contents

// api/contents?category=art
// or
// api/categories/1234/contents


// api/types
// api/types/1234
// api/types/1234/contents

// api/categories
// api/categories/1234
// api/categories/1234/contents



Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'api'], function() {
    require 'Routes/contents.php';
});

// Route::group(['prefix' => 'api', 'middleware' => 'apiV1'], function()
// {
//     Route::get('contents', function () {
//         $query = Request::get('q') ? Request::get('q') : NULL;
//         $limit = Request::get('limit') ? Request::get('limit') : 10;

//         $content = App\Models\Content::with(['type', 'category'])->paginate($limit);
//         return Fractal::collection($content, new App\Transformers\ContentTransformer)->responseJson(200);
//     });

//     Route::get('{type_slug}', function ($type_slug) {
//         $type_id = App\Models\Type::where('slug', '=', $type_slug)->pluck('id');
//         $content = App\Models\Content::with(['type', 'category'])->where('type_id', '=', $type_id)->paginate();
//         return Fractal::collection($content, new App\Transformers\ContentTransformer)->responseJson(200);
//     });

//     Route::get('{type_slug}/{content_id}', function ($type_slug, $content_id) {
//         $content = App\Models\Content::with(['type', 'category'])->find($content_id);
//         return Fractal::item($content, new App\Transformers\ContentTransformer)->responseJson(200);
//     });

// });