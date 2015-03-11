<?php

require_once('../../../RapGenius-PHP-master/src/rap_genius_wrapper.php');

class APITest extends PHPUnit_Framework_TestCase
{	
	public function testSanity()
	{
		$rapgenius = new RapGenius();
		
		$this->assertNotNull($rapgenius);
		
		return $rapgenius;
	}
	
	/**
	 * @depends testSanity
	 */
	public function testParams(RapGenius $rapgenius)
	{
		$this->assertEmpty($rapgenius->_query_parameters);
		
		$key = "key";
		$value = "value";
		
		$query = array($key => $value);
		
		$rapgenius->param_q($query);
		
		$this->assertNotEmpty($rapgenius->_query_parameters);
		$this->assertArrayHasKey($key, $rapgenius->_query_parameters);
		
		return $rapgenius;
	}
	
	/**
	 * @depends testParams
	 */
	public function testQuery(RapGenius $rapgenius)
	{
		$key = "key";
		$value = "value";
		$expected = "api.rapgenius.com/search/?".$key."=".$value."&format=json";
		
		$actual = $rapgenius->build_query_url();
		
		$this->assertEquals($expected, $actual);
	}
	
	/**
	 * @depends testParams
	 */
	public function testExecute(RapGenius $rapgenius)
	{
		$this->assertNotEmpty($rapgenius->_query_parameters);
		
		$result = $rapgenius->execute_request();
		
		$this->assertNotNull($result);
	}
	
	/**
	 * @depends testParams
	 */
	public function testReset(RapGenius $rapgenius)
	{
		$this->assertNotEmpty($rapgenius->_query_parameters);
		
		$rapgenius->reset_params();
		
		$this->assertEmpty($rapgenius->_query_parameters);
	}
}

?>