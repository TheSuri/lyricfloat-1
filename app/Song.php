<?php

class Song {
    public $title;
    public $lyrics;
    public $id;

    // Cannot create a Song without an id, title, and lyrics
    function __construct($id, $title, $lyrics) {
    	$this->id = $id;
    	$this->title = $title;
		$this->lyrics = $lyrics;
	}

    // Returns a key value pair list of words
    // and their frequency in the song
    function getWordCount() {
        $wordCount = array();
        $this->lyrics = preg_replace('/\[([^\[\]]++|(?R))*+\]/', '', $this->lyrics);
        $words = preg_split('/((^\p{P}+)|(\p{P}*\s+\p{P}*)|(\p{P}+$))/', $this->lyrics, -1, PREG_SPLIT_NO_EMPTY);
        foreach ($words as $word) {
        	$word = strtolower($word);
            if (isset($wordCount[$word])) {
                $wordCount[$word] += 1;
            } else {
                $wordCount[$word] = 1;
            } 
        }
        return $wordCount;
    }

    function countWord($word) {
    	$wordCount = $this->getWordCount();
    	if (isset($wordCount[$word])) {
			return $wordCount[$word];
		}
    	return 0;
    }
}

?>