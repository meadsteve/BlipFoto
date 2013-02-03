<?php
namespace MeadSteve\BlipFoto\Requests;

/**
 * @package    PHP blipfoto.com API
 * @author     Steve B <meadsteve@gmail.com>
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */

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

		/**
	 * Converts the input $date in to a format the blip API will understand.
	 * @param $dateInput
	 * @return string
	 * @throws \InvalidArgumentException If the $date can't be understood.
	 */
	protected function getProcessedDate($dateInput) {
		if ($dateInput instanceOf \DateTime) {
			return $dateInput->format(static::FORMAT_Date);
		}
		else if ($dateInput instanceOf \DatePeriod) {
			$arr = array();
			foreach($dateInput as $singleDate) {
				$arr[] = $singleDate;
			}
			return $this->getProcessedDate($arr);
		}
		else if(is_string($dateInput)) {
			return $dateInput;
		}
		else if(is_array($dateInput)) {
			$dateInput = array_map(array($this, 'getProcessedDate'), $dateInput);
			return implode(',', $dateInput);
		}
		else {
			throw new \InvalidArgumentException('$date parameter not understood');
		}
	}
}
