<?php namespace Fbf\LaravelPlaces;

class PlacesController extends \BaseController {

	protected $place;

	public function __construct(Place $place)
	{
		$this->place = $place;
	}

	public function index()
	{
		$places = $this->place->live()
			->orderBy('published_date', 'desc')
			->paginate(\Config::get('laravel-places::views.index_page.results_per_page'));

		return \View::make(\Config::get('laravel-places::views.index_page.view'), compact('places'));
	}

	public function view($slug)
	{
		$place = $this->place->live()
			->where('slug', '=', $slug)
			->firstOrFail();

		return \View::make(\Config::get('laravel-places::views.view_page.view'), compact('place'));

	}

}
