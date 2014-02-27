<?php

// Main default listing e.g. http://domain.com/events
Route::get(Config::get('laravel-places::routes.base_uri'), 'Fbf\LaravelPlaces\PlacesController@index');

if (Config::get('laravel-places::routes.relationship_uri_prefix'))
{
	// Relationship filtered listing, e.g. by category or tag, e.g. http://domain.com/places/category/my-category
	Route::get(Config::get('laravel-places::routes.base_uri').'/'.Config::get('laravel-places::routes.relationship_uri_prefix').'/{relationshipIdentifier}', 'Fbf\LaravelPlaces\PlacesController@indexByRelationship');
}

// e.g. http://domain.com/places/my-place-slug
Route::get(Config::get('laravel-places::routes.base_uri').'/{slug}', 'Fbf\LaravelPlaces\PlacesController@view');