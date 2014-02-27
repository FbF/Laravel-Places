<?php namespace Fbf\LaravelPlaces;

class PlacesController extends \BaseController {

	/**
	 * @var \Fbf\LaravelPlaces\Place
	 */
	protected $place;

	/**
	 * @param \Fbf\LaravelPlaces\Place $place
	 */
	public function __construct(Place $place)
	{
		$this->place = $place;
	}

	/**
	 * @return mixed
	 */
	public function index()
	{
		// Get the selected places
		$places = $this->place->live()
			->orderBy('is_sticky', 'desc')
			->orderBy('published_date', 'desc')
			->paginate(\Config::get('laravel-places::views.index_page.results_per_page'));

		return \View::make(\Config::get('laravel-places::views.index_page.view'), compact('places'));
	}

	/**
	 * @param $relationshipIdentifier
	 * @return mixed
	 */
	public function indexByRelationship($relationshipIdentifier)
	{
		// Get the selected places
		$places = $this->place->live()
			->byRelationship($relationshipIdentifier)
			->orderBy($this->place->getTable().'.is_sticky', 'desc')
			->orderBy($this->place->getTable().'.published_date', 'desc')
			->paginate(\Config::get('laravel-places::views.index_page.results_per_page'));

		return \View::make(\Config::get('laravel-events::views.index_page.view'), compact('places', 'relationshipIdentifier'));
	}

	/**
	 * @param $slug
	 * @return mixed
	 */
	public function view($slug)
	{
		// Get the selected place
		$place = $this->place->live()
			->where('slug', '=', $slug)
			->firstOrFail();

		return \View::make(\Config::get('laravel-places::views.view_page.view'), compact('place'));
	}

}
