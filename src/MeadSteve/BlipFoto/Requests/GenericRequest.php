<?php
namespace MeadSteve\BlipFoto\Requests;

interface GenericRequest {

    /**
	 * Gets the response from the request.
	 * @return \Guzzle\Http\Message\Response
	 */
	public function get();
}
