<?php

/**
 * Configuration options for the built-in views
 */
return array(

	/**
	 * Configuration options for the index page
	 */
	'index_page' => array(

		/**
		 * The view to use for the places index page. You can change this to a view in your
		 * app, and inside your own view you can @include the various partials in the package
		 * or you can use this one provided, but there's no layout or anything.
		 */
		'view' => 'laravel-places::places.index',

		/**
		 * The number of places to show per page on the index
		 *
		 * @type int
		 */
		'results_per_page' => 4,

	),

	/**
	 * Configuration options for the view page
	 */
	'view_page' => array(

		/**
		 * The view to use for the place detail page. You can change this to a view in your
		 * app, and inside your own view you can @include the various partials in the package
		 * or you can use this one provided, but there's no layout or anything.
		 */
		'view' => 'laravel-places::places.view',

		/**
		 * Determines whether to show the share partial on the place view page
		 *
		 * @type bool
		 */
		'show_share_partial' => true,
	),

	/**
	 * Date format for published date, shown in places.list and places.details partials. Should be
	 * a valid date() format string, e.g.
	 *
	 * @type string
	 */
	'published_date_format' => 'j\<\s\u\p\>S\<\/\s\u\p\> F \'y',

);