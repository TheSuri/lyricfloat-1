<?php
require_once('../../Artist.php');

class ArtistTest extends PHPUnit_Framework_TestCase
{	
	public function testArtistCreation()
	{
		$artist = new Artist('name');
		$this->assertEquals('name', $artist->name);
		

	}
}
?>