<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
});

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1'], function () {
    Route::get('whatsapp/queries', 'WhatsappApiController@getQueries');
    Route::get('whatsapp/answer', 'WhatsappApiController@getAnswer');
});
