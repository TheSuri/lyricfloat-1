<?php
require_once('../../Song.php');

class SongTest extends PHPUnit_Framework_TestCase
{	
	protected $id = 'id';
	protected $title = 'title';
	protected $lyrics = 'multiple Lyrics lyrics';
	public static $coverage;
	
	/**
	 * @codeCoverageIgnore
	 */
	public static function setUpBeforeClass()
	{
		SongTest::$coverage = new PHP_CodeCoverage();
	}
	
	/**
	 * @codeCoverageIgnore
	 */
	public function setUp()
	{
		SongTest::$coverage->start($this);
	}
	
	/**
	 * @codeCoverageIgnore
	 */
	public function tearDown()
	{
		SongTest::$coverage->stop();
	}
	/**
	 * @codeCoverageIgnore
	 */
	public static function tearDownAfterClass()
	{
		$writer = new PHP_CodeCoverage_Report_Clover;
		$writer->process(SongTest::$coverage, 'coverage/SongTest.xml');
		
		$writer = new PHP_CodeCoverage_Report_HTML;
		$writer->process(SongTest::$coverage, 'coverage/SongTest');
	}
	
	/**
	 * @covers Song::__construct
	 */
	public function testSongCreation()
	{
		$song = new Song($this->id, $this->title, $this->lyrics);
		$this->assertEquals($this->id, $song->id);
		$this->assertEquals($this->title, $song->title);
		$this->assertEquals($this->lyrics, $song->lyrics);
		
		return $song;
	}
	
	/**
	 * @depends testSongCreation
	 * @covers Song::getWordCount
	 */
	public function testGetWordCount(Song $song)
	{
		//Sanity check
		$this->assertEquals($this->lyrics, $song->lyrics);
		
		$wordcount = $song->getWordCount();
		$this->assertEquals(1, $wordcount['multiple']);
		$this->assertEquals(2, $wordcount['lyrics']);
		$this->assertEquals(2, count($wordcount));
		$this->assertArrayNotHasKey('missing', $wordcount);
		
		return $song;
	}
	
	/**
	 * @depends testGetWordCount
	 */
	public function testCountWord(Song $song)
	{
		//Sanity check
		$this->assertEquals($this->lyrics, $song->lyrics);
		
		$this->assertEquals(1, $song->countWord('multiple'));
		$this->assertEquals(2, $song->countWord('lyrics'));
		$this->assertEquals(0, $song->countWord('missing'));
	}
}
?>