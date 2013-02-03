<?php
namespace MeadSteve\BlipFoto;

/**
 * @package    PHP blipfoto.com API
 * @author     Steve B <meadsteve@gmail.com>
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */

use Guzzle\Http\Client as GuzzleClient;

include_once __DIR__ . "/bootstrap.php";

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Client
     */
    protected $object;

	/**
	 * @var GuzzleClient|\PHPUnit_Framework_MockObject_MockObject
	 */
	protected $guzzleClient;

	/**
	 * @var \Guzzle\Http\Message\RequestInterface
	 */
	protected $guzzleRequest;

	/**
	 * @var \Guzzle\Http\QueryString
	 */
	protected $guzzleRequestQuery;

	/**
	 * @var string
	 */
	protected $apiKey = "SuperSecretAPIKey";

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
		$this->guzzleClient = $this->getMock('Guzzle\Http\Client',
											 array('get'),
											 array(),
											 'MockedGuzzleClient',
											 false,
											 false);

		$this->guzzleRequest = $this->getMock('\Guzzle\Http\Message\RequestInterface',
											 array('getQuery'),
											 array(),
											 'MockedGuzzleRequest',
											 false,
											 false);

		$this->guzzleRequestQuery = $this->getMock('\Guzzle\Http\QueryString',
											 array('set'),
											 array(),
											 'MockedGuzzleRequestQuery',
											 false,
											 false);

		$this->guzzleRequest->expects($this->any())
				            ->method('getQuery')
						    ->will($this->returnValue($this->guzzleRequestQuery));

        $this->object = new Client($this->apiKey, $this->guzzleClient);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers MeadSteve\BlipFoto\Client::search
     */
    public function testSearch()
    {
        $this->guzzleClient->expects($this->once())
			               ->method('get')
		                   ->with('get/search/')
						   ->will($this->returnValue($this->guzzleRequest));

		$this->guzzleRequestQuery->expects($this->at(0))
				            ->method('set')
						    ->with('api_key', $this->apiKey)
							->will($this->returnValue($this->guzzleRequestQuery));
		$this->guzzleRequestQuery->expects($this->at(1))
				            ->method('set')
						    ->with('format', 'json')
			                ->will($this->returnValue($this->guzzleRequestQuery));

		$actualEntryRequest = $this->object->search();

		assertThat($actualEntryRequest,
				   is(anInstanceOf('\MeadSteve\BlipFoto\Requests\SearchRequest')));
    }

    /**
     * @covers MeadSteve\BlipFoto\Client::entry
     */
    public function testEntry()
    {
        $this->guzzleClient->expects($this->once())
			               ->method('get')
		                   ->with('get/entry/')
						   ->will($this->returnValue($this->guzzleRequest));

		$this->guzzleRequestQuery->expects($this->at(0))
				            ->method('set')
						    ->with('api_key', $this->apiKey)
							->will($this->returnValue($this->guzzleRequestQuery));
		$this->guzzleRequestQuery->expects($this->at(1))
				            ->method('set')
						    ->with('format', 'json')
			                ->will($this->returnValue($this->guzzleRequestQuery));

		$actualEntryRequest = $this->object->entry();

		assertThat($actualEntryRequest,
				   is(anInstanceOf('\MeadSteve\BlipFoto\Requests\EntryRequest')));
    }
}
