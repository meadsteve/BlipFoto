<?php
namespace MeadSteve\BlipFoto;

/**
 * @package    PHP blipfoto.com API
 * @author     Steve B <meadsteve@gmail.com>
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */

use Guzzle\Http\Client as GuzzleClient;

class Client {

	const BlipFotoBaseURL = "http://api.blipfoto.com/";

	/**
	 * Http client pointing to the BlipFoto API
	 * @var GuzzleClient
	 */
	protected $endPoint;

	/**
	 * BlipFoto App API key
	 * @var string
	 */
	protected $apiKey;

	/**
	 * The current request being built by the api
	 * @var \Guzzle\Http\Message\RequestInterface
	 */
	protected  $currentRequest;

	/**
	 * The query string of the current request being built.
	 * @var \Guzzle\Http\QueryString
	 */
	protected  $currentRequestQuery;

	/**
	 * The last response received by the API
	 * @var \Guzzle\Http\Message\Response
	 */
	protected  $lastResponse;


	/**
	 * Returns an instance using the specified API key. Optionally you can specify
	 * an alternative end point by passing either a url or a guzzle client as the
	 * 2nd argument.
	 * @param string $apiKey API key supplied by BlipFoto
	 * @param string|\Guzzle\Http\Client $endPoint Either a guzzle client or url to use
	 * @throws \InvalidArgumentException
	 */
	public function __construct($apiKey, $endPoint = null) {
		if ($endPoint instanceof GuzzleClient) {
			$this->endPoint = $endPoint;
		}
		else if (is_string($endPoint)) {
			// Consumer has passed in a string so build a guzzle client with that as
			// as base url
			$this->endPoint = new GuzzleClient($endPoint);
		}
		else if ($endPoint === null) {
			// If nothing has been specified we use a default end point.
			$this->endPoint = new GuzzleClient(static::BlipFotoBaseURL);
		}
		else {
			throw new \InvalidArgumentException('$endPoint was not understood');
		}

		$this->apiKey = $apiKey;
	}

	/**
	 * Starts building a request for get/search
	 * @return Requests\SearchRequest
	 */
	public function search() {
		return new Requests\SearchRequest($this->buildBaseGetRequest('get/search/'));
	}

	/**
	 * Starts building a request for get/entry
	 * @return Requests\EntryRequest
	 */
	public function entry() {
		return new Requests\EntryRequest($this->buildBaseGetRequest('get/entry/'));
	}

	/**
	 * Returns a guzzle http request for the specified URI. The api key will
	 * automatically be attached and the format set to json.
	 * @param $URI
	 * @return \Guzzle\Http\Message\RequestInterface
	 */
	protected function buildBaseGetRequest($URI) {
		$this->currentRequest = $this->endPoint->get($URI);
		$this->currentRequestQuery = $this->currentRequest->getQuery();
		$this->currentRequestQuery->set('api_key', $this->apiKey)
			                      ->set('format', 'json');

		return $this->currentRequest;
	}

}
