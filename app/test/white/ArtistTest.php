<?php
require_once('../../Artist.php');

class ArtistTest extends PHPUnit_Framework_TestCase
{	
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