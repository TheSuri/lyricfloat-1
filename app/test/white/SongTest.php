<?php
require_once('../../Song.php');

class SongTest extends PHPUnit_Framework_TestCase
{	
	public function testSongCreation()
	{
		$song = new Song('id', 'title', 'multiple lyrics');
		$this->assertEquals('id', $song->id);
		$this->assertEquals('title', $song->title);
		$this->assertEquals('multiple lyrics', $song->lyrics);
		
		return $song;
	}
	/**
	 * @depends testSongCreation
	 */
	public function testGetWordCount(Song $song)
	{
		$this->assertEquals('multiple', $song->lyrics);
	}
}
?>gi