<?php
require_once('../../Song.php');

class SongTest extends PHPUnit_Framework_TestCase
{	
	protected $id = 'id';
	protected $title = 'title';
	protected $lyrics = 'multiple Lyrics lyrics';
	
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
	 */
	public function testGetWordCount(Song $song)
	{
		//Sanity check
		$this->assertEquals($this->lyrics, $song->lyrics);
		
		$wordcount = $song->getWordCount();
		$this->assertEquals(1, $wordcount['multiple']);
		$this->assertEquals(2, $wordcount['lyrics']);
		$this->assertEquals(2, count($wordcount));
		
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