<?php

return array(

	/**
	 * Model title
	 *
	 * @type string
	 */
	'title' => 'Places',

	/**
	 * The singular name of your model
	 *
	 * @type string
	 */
	'single' => 'place',

	/**
	 * The class name of the Eloquent model that this config represents
	 *
	 * @type string
	 */
	'model' => 'Fbf\LaravelPlaces\Place',

	/**
	 * The columns array
	 *
	 * @type array
	 */
	'columns' => array(
		'title' => array(
			'title' => 'Title'
		),
		'status' => array(
			'title' => 'Status',
			'select' => "CASE (:table).status WHEN '".Fbf\LaravelPlaces\Place::APPROVED."' THEN 'Approved' WHEN '".Fbf\LaravelPlaces\Place::DRAFT."' THEN 'Draft' END",
		),
		'updated_at' => array(
			'title' => 'Last Updated'
		),
	),

	/**
	 * The edit fields array
	 *
	 * @type array
	 */
	'edit_fields' => array(
		'title' => array(
			'title' => 'Title',
			'type' => 'text',
		),
		'main_image' => array(
			'title' => 'Image',
			'type' => 'image',
			'naming' => 'random',
			'location' => public_path() . Config::get('laravel-places::images.main_image.original.dir'),
			'size_limit' => 5,
			'sizes' => array(
				array(
					Config::get('laravel-places::images.main_image.sizes.resized.width'),
					Config::get('laravel-places::images.main_image.sizes.resized.height'),
					Config::get('laravel-places::images.main_image.sizes.resized.method'),
					public_path(Config::get('laravel-places::images.main_image.sizes.resized.dir')),
					100
				),
				array(
					Config::get('laravel-places::images.main_image.sizes.thumbnail.width'),
					Config::get('laravel-places::images.main_image.sizes.thumbnail.height'),
					Config::get('laravel-places::images.main_image.sizes.thumbnail.method'),
					public_path(Config::get('laravel-places::images.main_image.sizes.thumbnail.dir')),
					100
				),
			),
			'visible' => Config::get('laravel-places::images.main_image.show'),
		),
		'main_image_alt' => array(
			'title' => 'Image ALT text',
			'type' => 'text',
			'visible' => Config::get('laravel-places::images.main_image.show'),
		),
		'you_tube_video_id' => array(
			'title' => 'YouTube Video ID',
			'type' => 'text',
			'visible' => Config::get('laravel-places::you_tube.show'),
		),
		'summary' => array(
			'title' => 'Summary',
			'type' => 'wysiwyg',
		),
		'content' => array(
			'title' => 'Content',
			'type' => 'wysiwyg',
		),
		'link_text' => array(
			'title' => 'Link Text',
			'type' => 'text',
			'visible' => Config::get('laravel-places::link.show'),
		),
		'link_url' => array(
			'title' => 'Link URL',
			'type' => 'text',
			'visible' => Config::get('laravel-places::link.show'),
		),
		'map_latitude' => array(
			'title' => 'Map Latitude',
			'type' => 'number',
			'decimals' => 6,
			'visible' => Config::get('laravel-places::map.show') && Config::get('laravel-places::map.map_centre_different_to_marker'),
		),
		'map_longitude' => array(
			'title' => 'Map Longitude',
			'type' => 'number',
			'decimals' => 6,
			'visible' => Config::get('laravel-places::map.show') && Config::get('laravel-places::map.map_centre_different_to_marker'),
		),
		'map_zoom' => array(
			'title' => 'Map Zoom',
			'type' => 'enum',
			'options' => range(1,20),
			'visible' => Config::get('laravel-places::map.show') && Config::get('laravel-places::map.variable_map_zoom'),
		),
		'marker_latitude' => array(
			'title' => 'Map Marker Latitude',
			'type' => 'number',
			'decimals' => 6,
			'visible' => Config::get('laravel-places::map.show'),
		),
		'marker_longitude' => array(
			'title' => 'Map Marker Longitude',
			'type' => 'number',
			'decimals' => 6,
			'visible' => Config::get('laravel-places::map.show'),
		),
		'marker_title' => array(
			'title' => 'Map Marker Title',
			'type' => 'text',
			'visible' => function($model)
				{
					return Config::get('laravel-places::map.marker_title');
				},
		),
		'slug' => array(
			'title' => 'Slug',
			'type' => 'text',
			'visible' => function($model)
				{
					return $model->exists;
				},
		),
		'page_title' => array(
			'title' => 'Page Title',
			'type' => 'text',
		),
		'meta_description' => array(
			'title' => 'Meta Description',
			'type' => 'textarea',
			'height' => 130, //optional, defaults to 100
		),
		'meta_keywords' => array(
			'title' => 'Meta Keywords',
			'type' => 'textarea',
		),
		'published_date' => array(
			'title' => 'Published Date',
			'type' => 'datetime',
			'date_format' => 'yy-mm-dd', //optional, will default to this value
			'time_format' => 'HH:mm',    //optional, will default to this value
		),
		'status' => array(
			'type' => 'enum',
			'title' => 'Status',
			'options' => array(
				Fbf\LaravelPlaces\Place::DRAFT => 'Draft',
				Fbf\LaravelPlaces\Place::APPROVED => 'Approved',
			),
		),
		'created_at' => array(
			'title' => 'Created',
			'type' => 'datetime',
			'editable' => false,
		),
		'updated_at' => array(
			'title' => 'Updated',
			'type' => 'datetime',
			'editable' => false,
		),
	),

	/**
	 * The filter fields
	 *
	 * @type array
	 */
	'filters' => array(
		'title' => array(
			'title' => 'Title',
		),
		'summary' => array(
			'type' => 'text',
			'title' => 'Summary',
		),
		'content' => array(
			'type' => 'text',
			'title' => 'Content',
		),
		'published_date' => array(
			'title' => 'Published Date',
			'type' => 'datetime',
		),
		'status' => array(
			'type' => 'enum',
			'title' => 'Status',
			'options' => array(
				Fbf\LaravelPlaces\Place::DRAFT => 'Draft',
				Fbf\LaravelPlaces\Place::APPROVED => 'Approved',
			),
		),
	),

	/**
	 * The width of the model's edit form
	 *
	 * @type int
	 */
	'form_width' => 500,

	/**
	 * The validation rules for the form, based on the Laravel validation class
	 *
	 * @type array
	 */
	'rules' => array(
		'title' => 'required|max:255',
		'main_image' => 'max:50',
		'main_image_alt' => 'required_with:image|max:255',
		'you_tube_video_id' => 'max:20',
		'summary' => 'required',
		'content' => 'required',
		'link_text' => 'max:50',
		'link_url' => 'max:255',
		'map_latitude' => 'numeric|between:-90,90',
		'map_longitude' => 'numeric|between:-180,180',
		'map_zoom' => 'integer|between:1,20',
		'marker_latitude' => 'numeric|between:-90,90',
		'marker_longitude' => 'numeric|between:-180,180',
		'slug' => 'alpha_dash|max:255',
		'page_title' => 'required|max:255',
		'status' => 'required|in:'.Fbf\LaravelPlaces\Place::DRAFT.','.Fbf\LaravelPlaces\Place::APPROVED,
		'published_date' => 'required|date_format:"Y-m-d H:i:s"|date',
	),

	/**
	 * The sort options for a model
	 *
	 * @type array
	 */
	'sort' => array(
		'field' => 'updated_at',
		'direction' => 'desc',
	),

	/**
	 * If provided, this is run to construct the front-end link for your model
	 *
	 * @type function
	 */
	'link' => function($model)
		{
			return $model->getUrl();
		},

);