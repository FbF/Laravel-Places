<div class="share-buttons">
	<p>{{ trans('laravel-places::messages.share.label') }}</p>
	<p class="share-button share-button__twitter">
		<a href="https://twitter.com/intent/tweet?text={{ urlencode($place->title . ' ' . $place->getUrl()) }}" target="_blank">
			{{ trans('laravel-places::messages.share.twitter') }}
		</a>
	</p>
	<p class="share-button share-button__facebook">
		<a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($place->getUrl()) }}" target="_blank">
			{{ trans('laravel-places::messages.share.facebook') }}
		</a>
	</p>
</div>