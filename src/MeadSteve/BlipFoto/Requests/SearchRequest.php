<?php

namespace MeadSteve\BlipFoto\Requests;

use Guzzle\Http\Message\RequestInterface;

class SearchRequest
	extends BaseRequest
{
	/**
	 * The thumbnail size: big (124px, default)
	 */
	const THUMBNAIL_SIZE_Big = "big";

	/**
	 * The thumbnail size: small (48px)
	 */
	const THUMBNAIL_SIZE_Small = "small";

	const THUMBNAIL_COLOR_Color = "color";

	const THUMBNAIL_COLOR_Gray = "gray";


	/**
	 * Sets the query for the search
	 * @param string $searchPhrase
	 * @throws \InvalidArgumentException if $searchPhrase is invalid
	 */
	public function query($searchPhrase) {
		if (!is_string($searchPhrase)) {
			throw new \InvalidArgumentException('$searchPhrase must be a string');
		}
		$this->requestQuery->add('query', $searchPhrase);
	}

	/**
	 * Sets the maximum number of results to return.
	 * @param integer $maxResults
	 * @throws \InvalidArgumentException
	 */
	public function maxResults($maxResults) {
		if (!is_integer($maxResults)) {
			throw new \InvalidArgumentException('$maxResults must be an integer');
		}
		$this->requestQuery->add('max', $maxResults);
	}

	/**
	 * Sets the size of the returned thumbnails. Two constants are provided:
	 * THUMBNAIL_SIZE_Big and THUMBNAIL_SIZE_Small
	 * @param $size
	 */
	public function size($size) {
		$this->requestQuery->add('size', $size);
	}

	/**
	 * Sets the size of the returned thumbnails. Two constants are provided:
	 * THUMBNAIL_COLOR_Color and THUMBNAIL_COLOR_Grey
	 * @param $color
	 */
	public function color($color) {
		$this->requestQuery->add('color', $color);
	}
}
