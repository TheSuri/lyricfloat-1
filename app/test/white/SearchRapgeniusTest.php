<?php

require_once('../../search_rapgenius.php');
require_once('../../../RapGenius-PHP-master/src/rapgenius.php');
require_once('../../../RapGenius-PHP-master/src/rap_genius_wrapper.php');

class MockGenius extends RapGenius
{
	public function execute_request($ch = null)
	{
		$query_result = "{\"meta\":{\"status\":200},\"response\":{\"hits\":[{\"result\":{\"annotation_count\":1,\"updated_by_human_at\":1415132331,\"lyrics_updated_at\":1415132195,\"primary_artist\":{\"url\":\"http://genius.com/artists/Quad-city-djs\",\"name\":\"Quad City DJ's\",\"image_url\":null,\"id\":9554},\"title\":\"Space Jam\",\"id\":38322,\"pyongs_count\":2},\"highlights\":{}},{\"result\":{\"annotation_count\":1,\"updated_by_human_at\":1415132331,\"lyrics_updated_at\":1415132195,\"primary_artist\":{\"url\":\"http://genius.com/artists/Fake-city-djs\",\"name\":\"Fake City DJ's\",\"image_url\":null,\"id\":9555},\"title\":\"Space Jelly\",\"id\":38323,\"pyongs_count\":2},\"highlights\":{}},{\"result\":{\"annotation_count\":1,\"updated_by_human_at\":1418947617,\"lyrics_updated_at\":1413925518,\"primary_artist\":{\"url\":\"http://genius.com/artists/Nice-peter-and-epiclloyd\",\"name\":\"Quad City DJ's\",\"image_url\":\"http://images.rapgenius.com/9e2c5aded4751aa3816147f7f2e1bb2f.480x360x1.jpg\",\"id\":26092},\"title\":\"Michael Jordan vs Muhammad Ali\",\"id\":282564,\"pyongs_count\":3},\"highlights\":{}}]}}";
		$full_result = json_decode($query_result, true);
        return $this->_result = $full_result['response']['hits'];   
	}

}

class EmptyGenius extends RapGenius
{
	public function execute_request($ch = null)
	{
		return array();
	}
}

class SearchRapgeniusTest extends PHPUnit_Framework_TestCase
{
	public function testSearch()
	{
		$rapgenius = new MockGenius();
		$artist = "Quad City DJ's";
		$artists = array($artist);
		
		$result = getLyrics($artists, $rapgenius);
		$id = "38322";
		$title = "Space Jam";
		$this->assertEquals($id, $result[$artist][0]['id']);
		$this->assertEquals($title, $result[$artist][0]['title']);
		$this->assertEquals(2, count($result[$artist]));
		$this->assertContains("Space Jam", $result[$artist][0]['lyrics']);
		$this->assertNotContains("Bugs Bunny", $result[$artist][0]['lyrics']);
	}
	
	public function testEmptySearch()
	{
		$rapgenius = new EmptyGenius();
		$artist = "Quad City DJ's";
		$artists = array($artist);
		
		$result = getLyrics($artists, $rapgenius);
		$this->assertEquals(0, count($result[$artist]));
	}
}
?>