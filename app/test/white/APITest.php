<?php

require_once('../../../RapGenius-PHP-master/src/rap_genius_wrapper.php');

class APITest extends PHPUnit_Framework_TestCase
{	
	public static $coverage;
	
	/**
	 * @codeCoverageIgnore
	 */
	public static function setUpBeforeClass()
	{
		APITest::$coverage = new PHP_CodeCoverage();
	}
	
	/**
	 * @codeCoverageIgnore
	 */
	public function setUp()
	{
		APITest::$coverage->start($this);
	}
	
	/**
	 * @codeCoverageIgnore
	 */
	public function tearDown()
	{
		APITest::$coverage->stop();
	}
	/**
	 * @codeCoverageIgnore
	 */
	public static function tearDownAfterClass()
	{
		$writer = new PHP_CodeCoverage_Report_Clover;
		$writer->process(APITest::$coverage, 'coverage/APITest.xml');
		
		$writer = new PHP_CodeCoverage_Report_HTML;
		$writer->process(APITest::$coverage, 'coverage/APITest');
	}

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
		$this->assertEquals($value, $rapgenius->_query_parameters[$key]);
		
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