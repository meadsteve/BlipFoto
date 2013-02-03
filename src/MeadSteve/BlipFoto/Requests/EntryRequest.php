<?php
namespace MeadSteve\BlipFoto\Requests;

/**
 * @package    PHP blipfoto.com API
 * @author     Steve B <meadsteve@gmail.com>
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */

use Guzzle\Http\Message\RequestInterface;

class EntryRequest
	extends BaseRequest
{

	/**
	 * Passing this keyword to BlipFoto tells it to request the latest date.
	 */
	const KEYWORD_Latest = "latest";

	/**
	 * This is the format of dates that blipfoto accepts.
	 */
	const FORMAT_Date = "Y-m-d";

	/**
	 * The blipfoto api doesn't return any fields by default so the API requests
	 * these fields if none are specified.
	 */
	const FIELDS_Default = "entry_id,date,title,thumbnail";

	/**
	 * Sets the user_name parameter of the request.
	 * @param string|string[] $displayName
	 * @return EntryRequest Returns itself. Fluent.
	 */
	public function forUser($displayName) {
		if (is_array($displayName)) {
			$displayName = implode(',', $displayName);
		}
		$this->requestQuery->add('user_name', $displayName);

		return $this;
	}


	/**
	 * Sets the entry_date parameter. This can be a string, a datetime object,
	 * an array of either, a mixed array of both or a \DatePeriod.
	 * @param string|\DateTime|string[]|\DateTime[]|DatePeriod $date
	 * @return EntryRequest
	 * @throws \InvalidArgumentException if the $date is not of an allowed type.
	 */
	public function forDate($date) {
		$this->requestQuery->add('entry_date', $this->getProcessedDate($date));

		return $this;
	}

	/**
	 * Sets the entry_date to return the latest. Shorthand for forDate('Latest')
	 * @return EntryRequest
	 */
	public function theLatest() {
		return $this->forDate(static::KEYWORD_Latest);
	}

	/**
	 * Specifies one or more specific entry_id
	 * @param string|string[]|int|int[] $entryID
	 * @return EntryRequest
	 */
	public function withEntryID($entryID) {
		if (is_array($entryID)) {
			$entryID = implode(',', $entryID);
		}
		$this->requestQuery->add('entry_id', $entryID);

		return $this;
	}

	/**
	 * Specifies the fields from http://api.blipfoto.com/docs/resources/get/entry/v1
	 * if not set then the const self::FIELDS_Default will be used.
	 * @param string|string[] $fields
	 * @return EntryRequest
	 */
	public function fields($fields) {
		if (is_array($fields)) {
			$fields = implode(',', $fields);
		}
		// BlipFoto doesn't like spaces in it's field list so stripping
		// out any trailing spaces after commas.
		$this->requestQuery->add('data', str_replace(', ', ',', $fields));
		return $this;
	}


	/**
	 * Gets the response from the request ensuring that the default fields
	 * are returned.
	 * @return \Guzzle\Http\Message\Response
	 */
	public function get() {
	// If no fields are specified request the default
		if(!$this->requestQuery->hasKey('data')) {
			$this->fields(static::FIELDS_Default);
		}

		return parent::get();
	}
}