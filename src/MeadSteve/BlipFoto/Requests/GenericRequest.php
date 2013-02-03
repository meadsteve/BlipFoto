<?php
namespace MeadSteve\BlipFoto\Requests;

/**
 * @package    PHP blipfoto.com API
 * @author     Steve B <meadsteve@gmail.com>
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */

interface GenericRequest {

    /**
	 * Gets the response from the request.
	 * @return \Guzzle\Http\Message\Response
	 */
	public function get();
}
