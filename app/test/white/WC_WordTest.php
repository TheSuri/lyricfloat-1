<?php
require_once('../../WC_Word.php');

class WC_WordTest extends PHPUnit_Framework_TestCase
{	
	public static $coverage;
	
	/**
	 * @codeCoverageIgnore
	 */
	public static function setUpBeforeClass()
	{
		WC_WordTest::$coverage = new PHP_CodeCoverage();
	}
	
	/**
	 * @codeCoverageIgnore
	 */
	public function setUp()
	{
		WC_WordTest::$coverage->start($this);
	}
	
	/**
	 * @codeCoverageIgnore
	 */
	public function tearDown()
	{
		WC_WordTest::$coverage->stop();
	}
	/**
	 * @codeCoverageIgnore
	 */
	public static function tearDownAfterClass()
	{
		$writer = new PHP_CodeCoverage_Report_Clover;
		$writer->process(WC_WordTest::$coverage, 'coverage/WC_WordTest.xml');
		
		$writer = new PHP_CodeCoverage_Report_HTML;
		$writer->process(WC_WordTest::$coverage, 'coverage/WC_WordTest');
	}
	
	public function testWCGeneration()
	{
		$word = 'word';
		$freq = 1;
		$WC_Word = new WC_Word($word, $freq);

		$this->assertContains($WC_Word->color, WC_Word::$colors);
		$this->assertEquals($word, $WC_Word->word);
		$this->assertEquals($freq, $WC_Word->freq);
	}
}
?>