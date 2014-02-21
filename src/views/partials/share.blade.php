<div class="share-buttons">
	<p>{{ trans('laravel-places::messages.details.share_label') }}</p>
	<p class="share-button share-button__twitter">
		<a href="https://twitter.com/intent/tweet?text={{ urlencode($place->title . ' ' . $place->getUrl()) }}" target="_blank">
			Share on Twitter
		</a>
	</p>
	<p class="share-button share-button__facebook">
		<a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($place->getUrl()) }}" target="_blank">
			Share on Facebook
		</a>
	</p>
</div>