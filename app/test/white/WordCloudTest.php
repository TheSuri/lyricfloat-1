<?php
require_once('../../WordCloud.php');

class WordCloudTest extends PHPUnit_Framework_TestCase
{	
	

	protected $artist;

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
	    $this->words = array('Lots' => new WC_Word('Lots', 1),
	    					'of' => new WC_Word('of',1),
	    					'small' => new WC_Word('small',1),
	    					'things' => new WC_Word('things',1));
    }

	public function testWordCloud()
	{
		$wordcloud = new WordCloud($data);
		$this->assertEmpty($this->stopwords);
		
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

   /**
	 * @depends testWordCloud
	 */
    public function testMergeWordCount(WordCloud $wordcloud) {
    	$wordcloud->mergeWordCount($this->wordcount);
    	print_r(array_values($wordcloud->words));
    	$this->assertEquals($wordcloud->words['Lots']->freq, $this->words['Lots']->freq);

    	return $wordcloud;
    }
       

	/**
	 * @depends testMergeData
	 */
	// public function testCountWordFreq(WordCloud $wordcloud)
	// {
	// 	$wordcloud->countWordFreq();




	// 	//Sanity check
	// 	$this->assertEquals($this->lyrics, $song->lyrics);
		
	// 	$wordcount = $song->getWordCount();
	// 	$this->assertEquals(1, $wordcount['multiple']);
	// 	$this->assertEquals(2, $wordcount['lyrics']);
	// 	$this->assertEquals(2, count($wordcount));
		
	// 	return $song;
	// }

	// public function countWordFreq() {
 //    	try {
	//         foreach ($this->artists as $name => $artist) {
	//             foreach ($artist->songs as $title => $song) {
	//                 $wordCount = $song->getWordCount();
	//                 // if (Settings->DEBUG) echo "Got this word count from song: ", json_encode($wordCount);
	//                 $this->mergeWordCount($wordCount);
	//             }
	//         }
 //    	} catch (Exception $e) {
 //    		throw $e;
 //    	}
 //    }
	
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