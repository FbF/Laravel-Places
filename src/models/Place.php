<?php namespace Fbf\LaravelPlaces;

class Place extends \Eloquent {

	/**
	 * Status values for the database
	 */
	const DRAFT = 'DRAFT';
	const APPROVED = 'APPROVED';

	/**
	 * Name of the table to use for this model
	 * @var string
	 */
	protected $table = 'fbf_places';

	/**
	 * The prefix string for config options.
	 *
	 * Defaults to the package's config prefix string
	 *
	 * @var string
	 */
	protected $configPrefix = 'laravel-places::';

	/**
	 * Used for Cviebrock/EloquentSluggable
	 * @var array
	 */
	public static $sluggable = array(
		'build_from' => 'title',
		'save_to' => 'slug',
		'separator' => '-',
		'unique' => true,
		'include_trashed' => true,
	);

	/**
	 * Query scope for "live" places, adds conditions for status = APPROVED and published date is in the past
	 *
	 * @param $query
	 * @return mixed
	 */
	public function scopeLive($query)
	{
		return $query->where('status', '=', self::APPROVED)
			->where('published_date', '<=', \Carbon\Carbon::now());
	}

	/**
	 * To filter items by a relationship, you should extend this class and define both the relationship and the
	 * scopeByRelationship() method in your subclass. See the package readme for an example.
	 *
	 * @param $query
	 * @param $relationshipIdentifier
	 * @throws Exception
	 */
	public function scopeByRelationship($query, $relationshipIdentifier)
	{
		throw new Exception('Extend this class and override this method according to your app\'s requirements');
	}

	/**
	 * Returns the URL of the place
	 * @return string
	 */
	public function getUrl()
	{
		return \URL::action('Fbf\LaravelPlaces\PlacesController@view', array('slug' => $this->slug));
	}

	/**
	 * Returns the HTML img tag for the requested image type and size for this place
	 *
	 * @param $type
	 * @param $size
	 * @return null|string
	 */
	public function getImage($type, $size)
	{
		if (empty($this->$type))
		{
			return null;
		}
		$html = '<img src="' . $this->getImageSrc($type, $size) . '"';
		$html .= ' alt="' . $this->{$type.'_alt'} . '"';
		$html .= ' width="' . $this->getImageWidth($type, $size) . '"';
		$html .= ' height="' . $this->getImageWidth($type, $size) . '" />';
		return $html;
	}

	/**
	 * Returns the value for use in the src attribute of an img tag for the given image type and size
	 *
	 * @param $type
	 * @param $size
	 * @return null|string
	 */
	public function getImageSrc($type, $size)
	{
		if (empty($this->$type))
		{
			return null;
		}
		return $this->getImageConfig($type, $size, 'dir') . $this->$type;
	}

	/**
	 * Returns the value for use in the width attribute of an img tag for the given image type and size
	 *
	 * @param $type
	 * @param $size
	 * @return null|string
	 */
	public function getImageWidth($type, $size)
	{
		if (empty($this->$type))
		{
			return null;
		}
		$method = $this->getImageConfig($type, $size, 'method');

		// Width varies for images that are 'portrait', 'auto', 'fit', 'crop'
		if (in_array($method, array('portrait', 'auto', 'fit', 'crop')))
		{
			list($width) = $this->getImageDimensions($type, $size);
			return $width;
		}
		return $this->getImageConfig($type, $size, 'width');
	}

	/**
	 * Returns the value for use in the height attribute of an img tag for the given image type and size
	 *
	 * @param $type
	 * @param $size
	 * @return null|string
	 */
	public function getImageHeight($type, $size)
	{
		if (empty($this->$type))
		{
			return null;
		}
		$method = $this->getImageConfig($type, $size, 'method');

		// Height varies for images that are 'landscape', 'auto', 'fit', 'crop'
		if (in_array($method, array('landscape', 'auto', 'fit', 'crop')))
		{
			list($width, $height) = $this->getImageDimensions($type, $size);
			return $height;
		}
		return $this->getImageConfig($type, $size, 'height');
	}

	/**
	 * Returns an array of the width and height of the current instance's image $type and $size
	 *
	 * @param $type
	 * @param $size
	 * @return array
	 */
	protected function getImageDimensions($type, $size)
	{
		$pathToImage = public_path($this->getImageConfig($type, $size, 'dir') . $this->$type);
		if (is_file($pathToImage) && file_exists($pathToImage))
		{
			list($width, $height) = getimagesize($pathToImage);
		}
		else
		{
			$width = $height = false;
		}
		return array($width, $height);
	}

	/**
	 * Returns the config setting for an image
	 *
	 * @param $imageType
	 * @param $size
	 * @param $property
	 * @internal param $type
	 * @return mixed
	 */
	public function getImageConfig($imageType, $size, $property)
	{
		$config = $this->getConfigPrefix().'images.' . $imageType . '.';
		if ($size == 'original')
		{
			$config .= 'original.';
		}
		elseif (!is_null($size))
		{
			$config .= 'sizes.' . $size . '.';
		}
		$config .= $property;
		return \Config::get($config);
	}

	/**
	 * Helper function to determine whether the item has a YouTube video
	 *
	 * @return bool
	 */
	public function hasYouTubeVideo()
	{
		return !empty($this->you_tube_video_id);
	}

	/**
	 * Returns the thumbnail image code defined in the config, for the current item's you tube video id
	 *
	 * @return string
	 */
	public function getYouTubeThumbnailImage()
	{
		return str_replace('%YOU_TUBE_VIDEO_ID%', $this->you_tube_video_id, \Config::get($this->getConfigPrefix().'you_tube.thumbnail_code'));
	}

	/**
	 * Returns the embed code defined in the config, for the current item's you tube video id
	 *
	 * @return string
	 */
	public function getYouTubeEmbedCode()
	{
		return str_replace('%YOU_TUBE_VIDEO_ID%', $this->you_tube_video_id, \Config::get($this->getConfigPrefix().'you_tube.embed_code'));
	}

	public function getMapZoom()
	{
		if (\Config::get($this->getConfigPrefix().'map.variable_map_zoom'))
		{
			return $this->map_zoom;
		}
		return \Config::get($this->getConfigPrefix().'map.default_map_zoom');
	}

	public function getMapLatitude()
	{
		if (\Config::get($this->getConfigPrefix().'map.map_centre_different_to_marker'))
		{
			return $this->map_latitude;
		}
		return $this->getMarkerLatitude();
	}

	public function getMapLongitude()
	{
		if (\Config::get($this->getConfigPrefix().'map.map_centre_different_to_marker'))
		{
			return $this->map_longitude;
		}
		return $this->getMarkerLongitude();
	}

	public function getMarkerLatitude()
	{
		return $this->marker_latitude;
	}

	public function getMarkerLongitude()
	{
		return $this->marker_longitude;
	}

	public function hasMap()
	{
		return $this->marker_latitude != 0 && $this->marker_longitude != 0;
	}

	/**
	 * Help function to determine whether the item has a link
	 * @return bool
	 */
	public function hasLink()
	{
		return !empty($this->link_text) && !empty($this->link_url);
	}

	/**
	 * Returns the published date formatted according to the config setting
	 * @return string
	 */
	public function getDate()
	{
		return date(\Config::get($this->getConfigPrefix().'views.published_date_format'), strtotime($this->published_date));
	}

	/**
	 * Returns the config prefix
	 *
	 * @return string
	 */
	public function getConfigPrefix()
	{
		return $this->configPrefix;
	}

	/**
	 * Sets the config prefix string
	 *
	 * @param $configBase string
	 * @return string
	 */
	public function setConfigPrefix($configBase)
	{
		return $this->configPrefix = $configBase;
	}

}