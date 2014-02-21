<div class="item-list">

	@if (!$places->isEmpty())

		@foreach ($places as $place)

			<div class="item">

				<h2 class="item--title">
					<a href="{{ $place->getUrl() }}" title="{{ $place->title }}">
						{{ $place->title }}
					</a>
				</h2>

				<p class="item--date">
					{{ $place->getDate() }}
				</p>

				@if (!empty($place->you_tube_video_id))
					<div class="item--thumb item--thumb__youtube">
						<a href="{{ $place->getUrl() }}" title="{{ $place->title }}">
							{{ $place->getYouTubeThumbnailImage() }}
						</a>
					</div>
				@elseif (!empty($place->main_image))
					<div class="item--thumb item--thumb__image">
						<a href="{{ $place->getUrl() }}" title="{{ $place->title }}">
							{{ $place->getImage('main_image', 'thumbnail') }}
						</a>
					</div>
				@endif

				<div class="item--summary">
					{{ $place->summary }}
				</div>

				<p class="item--more-link">
					<a href="{{ $place->getUrl() }}" title="{{ $place->title }}">
						{{ trans('laravel-places::messages.list.more_link_text') }}
					</a>
				</p>

			</div>

		@endforeach

		{{ $places->links() }}

	@else

		<p class="item-list--empty">
			{{ trans('laravel-places::messages.list.no_items') }}
		</p>

	@endif

</div>