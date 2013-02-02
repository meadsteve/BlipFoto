<?php

namespace MeadSteve\BlipFoto\Requests;

use Guzzle\Http\Message\RequestInterface;

abstract class BaseRequest
	implements GenericRequest
{

	/**
	 * The guzzle http request.
	 * @var RequestInterface
	 */
	protected $request;

	/**
	 * The query string of the current request being built.
	 * @var \Guzzle\Http\QueryString
	 */
	protected  $requestQuery;

	/**
	 * All requests are built on top of a guzzle request so this needs to be passed
	 * in.
	 * @param \Guzzle\Http\Message\RequestInterface $request
	 */
	public function __construct(RequestInterface $request) {
		$this->request = $request;
		$this->requestQuery = $request->getQuery();
	}

	/**
	 * Makes the equest and returns the response as an object assuming it was
	 * json encoded.
	 * @return \Guzzle\Http\Message\Response
	 */
	public function get() {
		return $this->request->send()->json();
	}
}
