<?php namespace Fbf\LaravelPlaces;

class FakePlacesSeeder extends \Seeder {

	protected $place;

	public function run()
	{
		$this->truncate();

		$this->faker = \Faker\Factory::create();

		$numberToCreate = \Config::get('laravel-places::seed.number');

		for ($i = 0; $i < $numberToCreate; $i++)
		{
			$this->create();
		}

		echo 'Database seeded' . PHP_EOL;
	}

	protected function truncate()
	{
		$replace = \Config::get('laravel-places::seed.replace');
		if ($replace)
		{
			\DB::table('fbf_places')->delete();
		}
	}

	protected function create()
	{
		$this->place = new Place();
		$this->setTitle();
		$this->setMedia();
		$this->setSummary();
		$this->setContent();
		$this->setLink();
		$this->setMap();
		$this->setIsSticky();
		$this->setPageTitle();
		$this->setMetaDescription();
		$this->setMetaKeywords();
		$this->setStatus();
		$this->setPublishedDate();
		$this->place->save();
	}

	protected function setTitle()
	{
		$title = $this->faker->sentence(rand(1, 10));
		$this->place->title = $title;
	}

	protected function setMedia()
	{
		if ($this->hasYouTubeVideos())
		{
			$this->setYouTubeVideoId();
		}
		elseif ($this->hasMainImage())
		{
			$this->doMainImage();
		}
	}

	protected function hasYouTubeVideos()
	{
		$youTubeVideoFreq = \Config::get('laravel-places::seed.you_tube.freq');
		$hasYouTubeVideos = $youTubeVideoFreq > 0 && rand(1, $youTubeVideoFreq) == $youTubeVideoFreq;
		return $hasYouTubeVideos;
	}

	protected function setYouTubeVideoId()
	{
		$this->place->you_tube_video_id = $this->faker->randomElement(\Config::get('laravel-places::seed.you_tube.video_ids'));
	}

	protected function hasMainImage()
	{
		$mainImageFreq = \Config::get('laravel-places::seed.images.main_image.freq');
		$hasMainImage = $mainImageFreq > 0 && rand(1, $mainImageFreq) == $mainImageFreq;
		return $hasMainImage;
	}

	protected function doMainImage()
	{
		$imageOptions = \Config::get('laravel-places::images.main_image');
		if (!$imageOptions['show'])
		{
			return false;
		}
		$seedOptions = \Config::get('laravel-places::seed.images.main_image');
		$original = $this->faker->image(
			public_path($imageOptions['original']['dir']),
			$seedOptions['original_width'],
			$seedOptions['original_height'],
			$seedOptions['category']
		);
		$filename = basename($original);
		foreach ($imageOptions['sizes'] as $sizeOptions)
		{
			$image = $this->faker->image(
				public_path($sizeOptions['dir']),
				$sizeOptions['width'],
				$sizeOptions['height']
			);
			rename($image, public_path($sizeOptions['dir']) . $filename);
		}
		$this->place->main_image = $filename;
		$this->place->main_image_alt = $this->place->title;
	}

	protected function setSummary()
	{
		$this->place->summary = '<p>'.implode('</p><p>', $this->faker->paragraphs(rand(1, 2))).'</p>';
	}

	protected function setContent()
	{
		$this->place->content = '<p>'.implode('</p><p>', $this->faker->paragraphs(rand(4, 10))).'</p>';
	}

	protected function setLink()
	{
		if ($this->hasLink())
		{
			$this->setLinkText();
			$this->setLinkUrl();
		}
	}

	protected function hasLink()
	{
		$showLink =  \Config::get('laravel-places::link.show');
		if (!$showLink)
		{
			return false;
		}
		$linkFreq = \Config::get('laravel-places::seed.link.freq');
		$hasLink = $linkFreq > 0 && rand(1, $linkFreq) == $linkFreq;
		return $hasLink;
	}

	protected function setLinkText()
	{
		$linkTexts = \Config::get('laravel-places::seed.link.texts');
		$this->place->link_text = $this->faker->randomElement($linkTexts);
	}

	protected function setLinkUrl()
	{
		$linkUrls = \Config::get('laravel-places::seed.link.urls');
		$this->place->link_url = $this->faker->randomElement($linkUrls);
	}

	protected function setMap()
	{
		if (!$this->hasMap())
		{
			return false;
		}
		$this->setMarkerLatLong();
		$this->setMapZoom();
		$this->setMapLatLong();
		$this->setMarkerTitle();
	}

	protected function setMarkerLatLong()
	{
		$markerLatMin = \Config::get('laravel-places::seed.map.marker.latitude.min');
		$markerLatMax = \Config::get('laravel-places::seed.map.marker.latitude.max');
		$markerLonMin = \Config::get('laravel-places::seed.map.marker.longitude.min');
		$markerLonMax = \Config::get('laravel-places::seed.map.marker.longitude.max');
		$this->place->marker_latitude = rand($markerLatMin*1000000,$markerLatMax*1000000) / 1000000;
		$this->place->marker_longitude = rand($markerLonMin*1000000,$markerLonMax*1000000) / 1000000;
	}

	protected function setMapZoom()
	{
		$variableMapZoom = \Config::get('laravel-places::map.variable_map_zoom');
		if (!$variableMapZoom)
		{
			$defaultMapZoom = \Config::get('laravel-places::map.default_map_zoom');
			$this->place->map_zoom = $defaultMapZoom;
		}
		else
		{
			$this->place->map_zoom = rand(6,14);
		}
	}

	protected function setMapLatLong()
	{
		$mapCentreDifferentToMarker = \Config::get('laravel-places::map.map_centre_different_to_marker');
		if (!$mapCentreDifferentToMarker)
		{
			return false;
		}
		$this->place->map_latitude = $this->place->marker_latitude + $this->getMapCentreOffsetByZoom();
		$this->place->map_longitude = $this->place->marker_longitude + $this->getMapCentreOffsetByZoom();
	}

	protected function getMapCentreOffsetByZoom()
	{
		$maxOffsets = array(
			0 => 90,
			1 => 45,
			2 => 22.5,
			3 => 10,
			4 => 5,
			5 => 3,
			6 => 2,
			7 => 1,
			8 => 0.5,
			9 => 0.25,
			10 => 0.125,
			11 => 0.05,
			12 => 0.025,
			13 => 0.0125,
			14 => 0.005,
			15 => 0.0025,
			16 => 0.00125,
			17 => 0.0005,
			18 => 0.00025,
			19 => 0.000125,
		);
		$maxOffset = $maxOffsets[$this->place->map_zoom];
		return rand($maxOffset*-1000000, $maxOffset*1000000) / 1000000;
	}

	protected function hasMap()
	{
		$showMap = \Config::get('laravel-places::map.show');
		if (!$showMap)
		{
			return false;
		}
		$mapFreq = \Config::get('laravel-places::seed.map.freq');
		$hasMap = $mapFreq > 0 && rand(1, $mapFreq) == $mapFreq;
		return $hasMap;
	}

	protected function setMarkerTitle()
	{
		$this->place->marker_title = $this->faker->words(rand(1, 6), true);
	}

	protected function setIsSticky()
	{
		$this->post->is_sticky = (bool) rand(0, 1);
	}

	protected function setInRss()
	{
		$this->place->in_rss = (bool) rand(0, 1);
	}

	protected function setPageTitle()
	{
		$this->place->page_title = $this->place->title;
	}

	protected function setMetaDescription()
	{
		$this->place->meta_description = $this->faker->paragraph(rand(1, 2));
	}

	protected function setMetaKeywords()
	{
		$this->place->meta_keywords = $this->faker->words(10, true);
	}

	protected function setStatus()
	{
		$statuses = array(
			Place::DRAFT,
			Place::APPROVED
		);
		$this->place->status = $this->faker->randomElement($statuses);
	}

	protected function setPublishedDate()
	{
		$this->place->published_date = $this->faker->dateTimeBetween('-2 years', '+1 month')->format('Y-m-d H:i:s');
	}

}