<?php
require_once('../../Artist.php');

class ArtistTest extends PHPUnit_Framework_TestCase
{	
	public static $coverage;
	
	/**
	 * @codeCoverageIgnore
	 */
	public static function setUpBeforeClass()
	{
		ArtistTest::$coverage = new PHP_CodeCoverage();
	}
	
	/**
	 * @codeCoverageIgnore
	 */
	public function setUp()
	{
		ArtistTest::$coverage->start($this);
	}
	
	/**
	 * @codeCoverageIgnore
	 */
	public function tearDown()
	{
		ArtistTest::$coverage->stop();
	}
	/**
	 * @codeCoverageIgnore
	 */
	public static function tearDownAfterClass()
	{
		$writer = new PHP_CodeCoverage_Report_Clover;
		$writer->process(ArtistTest::$coverage, 'coverage/ArtistTest.xml');
		
		$writer = new PHP_CodeCoverage_Report_HTML;
		$writer->process(ArtistTest::$coverage, 'coverage/ArtistTest');
	}
	
	public function testArtistCreation()
	{
		$name = 'name';
		
		$artist = new Artist($name);
		$this->assertEquals($name, $artist->name);
		$this->assertNotNull($artist->songs);
		$this->assertEmpty($artist->songs);
	}
}
?>