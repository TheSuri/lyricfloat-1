<?php

require_once('../../search_rapgenius.php');
require_once('../../../RapGenius-PHP-master/src/rapgenius.php');
require_once('../../../RapGenius-PHP-master/src/rap_genius_wrapper.php');

class MockGenius extends RapGenius {

	public function execute_request($ch = null)
	{
		$query_result = "{\"meta\":{\"status\":200},\"response\":{\"hits\":[{\"result\":{\"annotation_count\":1,\"updated_by_human_at\":1415132331,\"lyrics_updated_at\":1415132195,\"primary_artist\":{\"url\":\"http://genius.com/artists/Quad-city-djs\",\"name\":\"Quad City DJ's\",\"image_url\":null,\"id\":9554},\"title\":\"Space Jam\",\"id\":38322,\"pyongs_count\":2},\"highlights\":{}}]}}";
		$full_result = json_decode($query_result, true);
        return $this->_result = $full_result['response']['hits'];   
	}

}
class SearchRapgeniusTest extends PHPUnit_Framework_TestCase
{
	public function testSearch()
	{
		$rapgenius = new MockGenius();
		$artists = array("qcd");
		
		$result = getLyrics($artists, $rapgenius);
		$id = "38322";
		$title = "Space Jam";
		$this->assertEquals($id, $result["qcd"][0]['id']);
		$this->assertEquals($title, $result["qcd"][0]['title']);
		
	}
}
?>