<?php
require_once('../../WC_Word.php');

class WC_WordTest extends PHPUnit_Framework_TestCase
{	
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