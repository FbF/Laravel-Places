<div class="item{{ $place->is_sticky ? ' item__sticky' : '' }}">

	<p class="item--all-link">
		<a href="{{ action('Fbf\LaravelPlaces\PlacesController@index') }}">
			{{ trans('laravel-places::messages.details.all_link_text') }}
		</a>
	</p>

	<h2 class="item--title">
		{{ $place->title }}
	</h2>

	<p class="item--date">
		{{ $place->getDate() }}
	</p>

	<div class="item--summary">
		{{ $place->summary }}
	</div>

	@if (Config::get('laravel-places::views.view_page.show_share_partial'))
		@include('laravel-places::partials.share')
	@endif

	@if (!empty($place->you_tube_video_id))
		<div class="item--media item--media__youtube">
			<a href="{{ $place->getUrl() }}" title="{{ $place->title }}">
				{{ $place->getYouTubeEmbedCode() }}
			</a>
		</div>
	@elseif (!empty($place->main_image))
		<div class="item--media item--media__image">
			<a href="{{ $place->getUrl() }}" title="{{ $place->title }}">
				{{ $place->getImage('main_image', 'resized') }}
			</a>
		</div>
	@endif

	{{ $place->content }}

	@if (Config::get('laravel-places::link.show') && !empty($place->link_url) && !empty($place->link_text))
		<p class="item--external-link">
			<a href="{{ $place->link_url }}">
				{{ $place->link_text }}
			</a>
		</p>
	@endif

</div>

@if (Config::get('laravel-places::map.show') && $place->hasMap())
	@include('laravel-places::partials.map')
@endif