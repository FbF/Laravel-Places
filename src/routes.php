<?php

// e.g. http://domain.com/places
Route::get(Config::get('laravel-places::routes.uri'), 'Fbf\LaravelPlaces\PlacesController@index');

// e.g. http://domain.com/places/my-place-slug
Route::get(Config::get('laravel-places::routes.uri').'/{slug}', 'Fbf\LaravelPlaces\PlacesController@view');