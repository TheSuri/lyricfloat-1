<?php
require_once('../../WordCloud.php');

class WordCloudTest extends PHPUnit_Framework_TestCase
{	
	

	protected $artist;
	protected $mean = 1;
	protected $word = 'small';

    protected $data = array('Blink 182' => array(
    	array(
    		'id' => 'fdsafds324fds',
    		'title' => 'All the small things',
    		'lyrics' => 'Lots of small things'
    		),
    	array(
    		'id' => '12fds54232f',
    		'title' => 'When I was young',
    		'lyrics' => 'I wish I was young again'
    		)
    	)
    );

    protected $wordcount;
    protected $words;
  
    protected function setUp()
    {
    	$this->artist = new Artist('Blink 182');

	    $this->artist->songs = array(
	    	'All the small things' => new Song('fdsafds324fds', 'All the small things', 'Lots of small things'),
	    	'When I was young' => new Song('12fds54232f', 'When I was young', 'I wish I was young again'));
	    $song = $this->artist->songs['All the small things'];
	    $this->wordcount = $song->getWordCount();
	    $this->words = array('lots' => new WC_Word('lots', 1),
	    					'of' => new WC_Word('of',1),
	    					'small' => new WC_Word('small',1),
	    					'things' => new WC_Word('things',1),
	    					'i' => new WC_Word('i',2),
	    					'wish' => new WC_Word('wish',1),
	    					'was' => new WC_Word('was',1),
	    					'young' => new WC_Word('young',1),
	    					'again' => new WC_Word('again',1));
    }

	public function testWordCloud()
	{
		$wordcloud = new WordCloud();
		$this->assertNotEmpty($wordcloud->stopwords);
		
		return $wordcloud;
	}

	/**
	 * @depends testWordCloud
	 */
    public function testMergeData($wordcloud)
    {
    	$wordcloud->mergeData($this->data);

    	$this->assertEquals($wordcloud->artists['Blink 182'], $this->artist);
    	return $wordcloud;
    }

    //set up function for testMergeWordCount()
    	private function setUpTestMergeWordCount()
	{
		$wordcloud = new WordCloud();
		$wordcloud->mergeData($this->data);
		return $wordcloud;
	}

   /**
	 * @depends testMergeData
	 */
    public function testMergeWordCount() {
    	$wordcloud = $this->setUpTestMergeWordCount();
    	$wordcloud->mergeWordCount($this->wordcount);
    	
    	$this->assertEquals($wordcloud->words['lots']->freq, $this->words['lots']->freq);
    	$this->assertEquals($wordcloud->words['of']->freq, $this->words['of']->freq);
    	$this->assertEquals($wordcloud->words['small']->freq, $this->words['small']->freq);
    	$this->assertEquals($wordcloud->words['things']->freq, $this->words['things']->freq);

		$this->assertEquals($wordcloud->words['lots']->word, $this->words['lots']->word);
    	$this->assertEquals($wordcloud->words['of']->word, $this->words['of']->word);
    	$this->assertEquals($wordcloud->words['small']->word, $this->words['small']->word);
    	$this->assertEquals($wordcloud->words['things']->word, $this->words['things']->word);


    	return $wordcloud;
    }
       

	/**
	 * @depends testMergeData
	 */
	public function testCountWordFreq(WordCloud $wordcloud)
	{
		$wordcloud->countWordFreq();

		$this->assertEquals($wordcloud->words['lots']->freq, $this->words['lots']->freq);
    	$this->assertEquals($wordcloud->words['of']->freq, $this->words['of']->freq);
    	$this->assertEquals($wordcloud->words['small']->freq, $this->words['small']->freq);
    	$this->assertEquals($wordcloud->words['things']->freq, $this->words['things']->freq);

		$this->assertEquals($wordcloud->words['lots']->word, $this->words['lots']->word);
    	$this->assertEquals($wordcloud->words['of']->word, $this->words['of']->word);
    	$this->assertEquals($wordcloud->words['small']->word, $this->words['small']->word);
    	$this->assertEquals($wordcloud->words['things']->word, $this->words['things']->word);

    	$this->assertEquals($wordcloud->words['i']->freq, $this->words['i']->freq);
    	$this->assertEquals($wordcloud->words['wish']->freq, $this->words['wish']->freq);
    	$this->assertEquals($wordcloud->words['was']->freq, $this->words['was']->freq);
    	$this->assertEquals($wordcloud->words['young']->freq, $this->words['young']->freq);
    	$this->assertEquals($wordcloud->words['again']->freq, $this->words['again']->freq);

		$this->assertEquals($wordcloud->words['i']->word, $this->words['i']->word);
    	$this->assertEquals($wordcloud->words['wish']->word, $this->words['wish']->word);
    	$this->assertEquals($wordcloud->words['was']->word, $this->words['was']->word);
    	$this->assertEquals($wordcloud->words['young']->word, $this->words['young']->word);
    	$this->assertEquals($wordcloud->words['again']->word, $this->words['again']->word);
		
		return $wordcloud;
	}

	/**
	 * @depends testCountWordFreq
	 */
	public function testFilterStopwords(WordCloud $wordcloud)
	{
		$words = $wordcloud->filter_stopwords();
		$this->assertArrayHasKey('lots', $words);
		$this->assertArrayHasKey('small', $words);
		$this->assertArrayHasKey('things', $words);
		$this->assertArrayHasKey('young', $words);

		$this->assertArrayNotHasKey('wish', $words);
		$this->assertArrayNotHasKey('again', $words);
		$this->assertArrayNotHasKey('of', $words);
		$this->assertArrayNotHasKey('i', $words);
		$this->assertArrayNotHasKey('was', $words);

		return $words;
	}

	/**
	 * @depends testCountWordFreq
	 */
	public function testGenerateWC($words)
	{

	}

	/**
	 * @depends testFilterStopwords
	 */
	public function testStandardDeviation($words)
	{
		$wordcloud = $this->setUpTestMergeWordCount();
		$stdDev = $wordcloud->standardDeviation($words, $this->mean);
		$this->assertEquals($stdDev, 0);
	}

	/**
	 * @depends testMergeData
	 */
	public function testGetSongsWith(WordCloud $wordcloud)
	{
		$songs = $wordcloud->getSongsWith($this->word);
		$this->assertEquals($songs, array('Blink 182' =>
				array('All the small things' => 1)));
	}

	// /**
	//  * @depends testGetWordCount
	//  */
	// public function testCountWord(Song $song)
	// {
	// 	//Sanity check
	// 	$this->assertEquals($this->lyrics, $song->lyrics);
		
	// 	$this->assertEquals(1, $song->countWord('multiple'));
	// 	$this->assertEquals(2, $song->countWord('lyrics'));
	// 	$this->assertEquals(0, $song->countWord('missing'));
	// }
}
?>