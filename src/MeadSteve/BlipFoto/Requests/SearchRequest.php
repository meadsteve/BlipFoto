<?php
namespace MeadSteve\BlipFoto\Requests;

/**
 * @package    PHP blipfoto.com API
 * @author     Steve B <meadsteve@gmail.com>
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */

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
	 * @return SearchRequest
	 * @throws \InvalidArgumentException if $searchPhrase is invalid
	 */
	public function query($searchPhrase) {
		if (!is_string($searchPhrase)) {
			throw new \InvalidArgumentException('$searchPhrase must be a string');
		}
		$this->requestQuery->add('query', $searchPhrase);

		return $this;
	}

	/**
	 * Sets the maximum number of results to return.
	 * @param integer $maxResults
	 * @return SearchRequest
	 * @throws \InvalidArgumentException
	 */
	public function maxResults($maxResults) {
		if (!is_integer($maxResults)) {
			throw new \InvalidArgumentException('$maxResults must be an integer');
		}
		$this->requestQuery->add('max', $maxResults);

		return $this;
	}

	/**
	 * Sets the size of the returned thumbnails. Two constants are provided:
	 * THUMBNAIL_SIZE_Big and THUMBNAIL_SIZE_Small
	 * @param $size
	 * @return SearchRequest
	 */
	public function size($size) {
		$this->requestQuery->add('size', $size);

		return $this;
	}

	/**
	 * Sets the size of the returned thumbnails. Two constants are provided:
	 * THUMBNAIL_COLOR_Color and THUMBNAIL_COLOR_Grey
	 * @param $color
	 * @return SearchRequest
	 */
	public function color($color) {
		$this->requestQuery->add('color', $color);

		return $this;
	}
}
