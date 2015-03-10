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
	    	'When I was young' => new Song('12fds54232f', 'When I was young', 'I wish I was young again')
		);
	    $song = $this->artist->songs['All the small things'];
	    $this->wordcount = $song->getWordCount();
	    $this->words = array(
			'lots' => new WC_Word('lots', 1),
	    	'of' => new WC_Word('of',1),
	    	'small' => new WC_Word('small',1),
	    	'things' => new WC_Word('things',1),
	    	'i' => new WC_Word('i',2),
	    	'wish' => new WC_Word('wish',1),
	    	'was' => new WC_Word('was',1),
	    	'young' => new WC_Word('young',1),
	    	'again' => new WC_Word('again',1)
		);
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
		//Precondition
		$this->assertFalse(isset($wordcloud->artists['Blink 182']));
		
    	$wordcloud->mergeData($this->data);

    	$this->assertEquals($wordcloud->artists['Blink 182'], $this->artist);
		$this->assertNotEmpty($wordcloud->artists['Blink 182']->songs);
		$this->assertEquals($wordcloud->artists['Blink 182']->songs['All the small things'], $this->artist->songs['All the small things']);
    	return $wordcloud;
    }
	
	//Function to provide a starting word cloud to tests
	public function wordcloudProvider()
	{
		$wordcloud = new WordCloud();
		$wordcloud->mergeData($this->data);
		return array(array($wordcloud));
	}
	
	//Assert the equality of two arrays of words, minus the color which is random
	public function assertWordEquality($words1, $words2)
	{
		//Assert there are no elements in words1 not in words2 that do not have the same word & freq
		foreach($words1 as $name => $word)
		{
			$this->assertArrayHasKey($name, $words2);
			$this->assertEquals($word->word, $words2[$name]->word);
			$this->assertEquals($word->freq, $words2[$name]->freq);
		}
		//Assert there are no elements in words2 not in words1
		foreach($words2 as $name => $word)
		{
			$this->assertArrayHasKey($name, $words1);
		}
	}

   /**
	 * @dataProvider wordcloudProvider
	 * @depends testMergeData
	 */
    public function testMergeWordCount(WordCloud $wordcloud)
	{
		//Precondition
		$this->assertEmpty($wordcloud->words);
		
		//Check to see if new words get added
    	$wordcloud->mergeWordCount($this->wordcount);
    	
		$this->assertNotEmpty($wordcloud->words);
		
    	$this->assertEquals($wordcloud->words['lots']->freq, $this->words['lots']->freq);
    	$this->assertEquals($wordcloud->words['of']->freq, $this->words['of']->freq);
    	$this->assertEquals($wordcloud->words['small']->freq, $this->words['small']->freq);
    	$this->assertEquals($wordcloud->words['things']->freq, $this->words['things']->freq);

		$this->assertEquals($wordcloud->words['lots']->word, $this->words['lots']->word);
    	$this->assertEquals($wordcloud->words['of']->word, $this->words['of']->word);
    	$this->assertEquals($wordcloud->words['small']->word, $this->words['small']->word);
    	$this->assertEquals($wordcloud->words['things']->word, $this->words['things']->word);
		
		// Check to see if word counts increase
    	$wordcloud->mergeWordCount($this->wordcount);
		
    	$this->assertEquals($wordcloud->words['lots']->freq, 2*$this->words['lots']->freq);
    	$this->assertEquals($wordcloud->words['of']->freq, 2*$this->words['of']->freq);
    	$this->assertEquals($wordcloud->words['small']->freq, 2*$this->words['small']->freq);
    	$this->assertEquals($wordcloud->words['things']->freq, 2*$this->words['things']->freq);

    	return $wordcloud;
    }
       

	/**
	 * @depends testMergeData
	 */
	public function testCountWordFreq(WordCloud $wordcloud)
	{
		//Precondition
		$this->assertEmpty($wordcloud->words);
		
		//Check to see if counts get generated
		$wordcloud->countWordFreq();
		
		$this->assertNotEmpty($wordcloud->words);
		$this->assertWordEquality($wordcloud->words, $this->words);
		
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

	public function testGenerateCloud()
	{
		//1 is generateCloud; 2 is each step manually
		$wordcloud1 = new WordCloud();
		$wordcloud2 = new WordCloud();
		
		$wordcloud1->generateCloud($this->data);
		
		//We know these steps individually work because of the other tests
    	$wordcloud2->mergeData($this->data);
		$wordcloud2->countWordFreq();
		
		$this->assertEquals($wordcloud1->artists, $wordcloud2->artists);
		$this->assertWordEquality($wordcloud1->words, $wordcloud2->words);
		
		return $wordcloud1;
	}
	
	/**
	 * @depends testGenerateCloud
	 * @depends testFilterStopwords
	 */
	public function testGenerateWC($wordcloud, $words)
	{
		$cloud = $wordcloud->generateWC();
		foreach($words as $word => $frq)
		{
			//Assert words, colors exist in cloud 
			$this->assertContains($wordcloud->words[$word]->color, $cloud);
			$this->assertContains($word, $cloud);
			$this->assertContains($wordcloud->words[$word]->color . ";\">" . $word, $cloud);
		}
	}

	/**
	 * @dataProvider wordcloudProvider
	 * @depends testFilterStopwords
	 */
	public function testStandardDeviation(WordCloud $wordcloud, $words)
	{
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
}
?>