<?php

Route::get(
    'contents',
    ['uses' => 'ContentController@index']
);

Route::get(
    'contents/{id}',
    ['uses' => 'ContentController@show']
);

Route::post(
    '/contents',
    ['uses' => 'ContentController@store']
);

Route::delete(
    '/contents/{id}',
    ['uses' => 'ContentController@destroy']
);

Route::patch(
    '/contents/{id}',
    ['uses' => 'ContentController@update']
);