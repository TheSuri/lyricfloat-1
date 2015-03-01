<?php

require_once('Artist.php');
require_once('Song.php');
require_once('WC_Word.php');

class WordCloud {
    public $artists = array();
    public $maxNumWords = 250;
    public $words = array();
    private $stopwords = array();

    function __construct() {
    	// STOPWORD LIST IS THE DEFAULT MySQL STOPWORDS
    	$this->stopwords = explode(",", "1,2,3,4,5,6,7,8,9,2x,3x,4x,5x,6x,x2,x3,x4,x5,x6,?,!,+,-,@,#,$,%,^,&,*,(,),=,able,about,above,according,accordingly,across,actually,after,afterwards,again,against,ain't,all,allow,allows,almost,alone,along,already,also,although,always,am,among,amongst,an,and,another,any,anybody,anyhow,anyone,anything,anyway,anyways,anywhere,apart,appear,appreciate,appropriate,are,aren't,around,as,aside,ask,asking,associated,at,available,away,awfully,be,became,because,become,becomes,becoming,been,before,beforehand,behind,being,believe,below,beside,besides,best,better,between,beyond,both,brief,but,by,c'mon,c's,came,can,can't,cannot,cant,cause,causes,certain,certainly,changes,clearly,co,com,come,comes,concerning,consequently,consider,considering,contain,containing,contains,corresponding,could,couldn't,course,currently,definitely,described,despite,did,didn't,different,do,does,doesn't,doing,don't,done,down,downwards,during,each,edu,eg,eight,either,else,elsewhere,enough,entirely,especially,et,etc,even,ever,every,everybody,everyone,everything,everywhere,ex,exactly,example,except,far,few,fifth,first,five,followed,following,follows,for,former,formerly,forth,four,from,further,furthermore,get,gets,getting,given,gives,go,goes,going,gone,got,gotten,greetings,had,hadn't,happens,hardly,has,hasn't,have,haven't,having,he,he's,hello,help,hence,her,here,here's,hereafter,hereby,herein,hereupon,hers,herself,hi,him,himself,his,hither,hopefully,how,howbeit,however,i'd,i'll,i'm,i've,ie,if,ignored,immediate,in,inasmuch,inc,indeed,indicate,indicated,indicates,inner,insofar,instead,into,inward,is,isn't,it,it'd,it'll,it's,its,itself,just,keep,keeps,kept,know,knows,known,last,lately,later,latter,latterly,least,less,lest,let,let's,like,liked,likely,little,look,looking,looks,ltd,mainly,many,may,maybe,me,mean,meanwhile,merely,might,more,moreover,most,mostly,much,must,my,myself,name,namely,nd,near,nearly,necessary,need,needs,neither,never,nevertheless,new,next,nine,no,nobody,non,none,noone,nor,normally,not,nothing,novel,now,nowhere,obviously,of,off,often,oh,ok,okay,old,on,once,one,ones,only,onto,or,other,others,otherwise,ought,our,ours,ourselves,out,outside,over,overall,own,particular,particularly,per,perhaps,placed,please,plus,possible,presumably,probably,provides,que,quite,qv,rather,rd,re,really,reasonably,regarding,regardless,regards,relatively,respectively,right,said,same,saw,say,saying,says,second,secondly,see,seeing,seem,seemed,seeming,seems,seen,self,selves,sensible,sent,serious,seriously,seven,several,shall,she,should,shouldn't,since,six,so,some,somebody,somehow,someone,something,sometime,sometimes,somewhat,somewhere,soon,sorry,specified,specify,specifying,still,sub,such,sup,sure,t's,take,taken,tell,tends,th,than,thank,thanks,thanx,that,that's,thats,the,their,theirs,them,themselves,then,thence,there,there's,thereafter,thereby,therefore,therein,theres,thereupon,these,they,they'd,they'll,they're,they've,think,third,this,thorough,thoroughly,those,though,three,through,throughout,thru,thus,to,together,too,took,toward,towards,tried,tries,truly,try,trying,twice,two,un,under,unfortunately,unless,unlikely,until,unto,up,upon,us,use,used,useful,uses,using,usually,value,various,very,via,viz,vs,want,wants,was,wasn't,way,we,we'd,we'll,we're,we've,welcome,well,went,were,weren't,what,what's,whatever,when,whence,whenever,where,where's,whereafter,whereas,whereby,wherein,whereupon,wherever,whether,which,while,whither,who,who's,whoever,whole,whom,whose,why,will,willing,wish,with,within,without,won't,wonder,would,would've,wouldn't,yes,yet,you,you'd,you'll,you're,you've,your,yours,yourself,yourselves,zero,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z");
    }

    // takes in a list of artists, their songs
    // and the lyrics to their songs and initiatlizes
    // the data. Should be in this format:
	// {
	//   "Blink 182": [
	//     {
	//       "id": "fdsafds324fds",
	//       "title": "All the small things",
	//       "lyrics": "Lots of small thins"
	//     },
	//     {
	//       "id": "12fds54232f",
	//       "title": "When I was young",
	//       "lyrics": "I wish I was young again"
	//     }
	//   ],
	//   "Disclosure": [
	//     {
	//       "id": "fdsaf8ds978",
	//       "title": "You & Me",
	//       "lyrics": "disclosure is so amazing"
	//     },
	//     {
	//       "id": "fds789fds78",
	//       "title": "Latch",
	//       "lyrics": "You latch onto me, oh ya ya"
	//     }
	//   ]
	// }
	function loadData($data) {
		try {
			foreach($data as $name => $songs) {
				$artist = new Artist($name);
				foreach ($songs as $song) {
					array_push($artist->songs, new Song($song['id'], $song['title'], $song['lyrics']));
				}
				array_push($this->artists, $artist);
			}
		} catch (Exception $e) {
			return $e;
		}
	}

    // iterates over each artist, 
    // and each song to collect the word count
    // of the lyrics of that song, then calls
    // mergeWordCount for the wordcount of that song.
    function countWordFreq() {
    	try {
	        foreach ($this->artists as $artist) {
	            foreach ($artist->songs as $song) {
	                $wordCount = $song->getWordCount();
	                // if (Settings->DEBUG) echo "Got this word count from song: ", json_encode($wordCount);
	                $this->mergeWordCount($wordCount);
	            }
	        }
    	} catch (Exception $e) {
    		return $e;
    	}
    }

    // Takes a key value pair of words and frequency
    // and merges it into $words.
    // If the word does not exist in $words, it adds it
    // Otherwise just increases the count value.
    function mergeWordCount($wordCount) {
        foreach($wordCount as $word => $count) {
            if (isset($this->words[$word])) {
                $this->words[$word]->freq += $count;
            } else {
                $this->words[$word] = new WC_Word($word, $count);
            }
        }
    }

	function filter_stopwords() {
	    foreach ($this->words as $word => $wc_word) {
	        if (!in_array(strtolower($word), $this->stopwords, TRUE)) {
	            $filtered_words[$word] = $wc_word->freq;
	        }
	    }
	    return $filtered_words;
	}

    // Takes the current $words, and generates
    // a word cloud utilizing $maxNumWords
    function generateWC() {
    	$words = $this->filter_stopwords();
    	$tags = 0;
	    $cloud = array();
    	if (count($words)==0) return implode('', $cloud);

    	arsort($words);

	    /* This word cloud generation algorithm was taken from the Wikipedia page on "word cloud"
	       with some minor modifications to the implementation */
	    
	    /* Initialize some variables */
	    $fmax = 3; /* Maximum font size */
	    $fmin = 0.3; /* Minimum font size */
	    $mean = array_sum($words) / count($words);
	    $sd = $this->standardDeviation($words, $mean);

	    foreach ($words as $word => $freq) {
	    	$wordSD = (($freq - $mean) / $sd);
	    	if ($wordSD > 1.3) $font_size = $fmax;
	    	elseif ($wordSD < -1.3) $font_size = $fmin;
	    	else $font_size = (($fmax+$fmin)/2) + ( ($wordSD/1.3) * (($fmax-$fmin)/2) );
	    	// Fontsize average + (ratio of standard deviations * Fontsize range/2)
	    	// ratio of standard deviation uses 1.3 because we assume that our data will
	    	// typically be no more than 1.3 standard deviations away from each other. 
	    	// if there is an outlier, we just set it to the min or max font size.
            $color = $this->words[$word]->color;
            array_push($cloud, "<a href='#{$word}'><span style=\"font-size: {$font_size}em; color: {$color};\">$word</span></a> ");
            $tags++;
            if ($tags >= $this->maxNumWords) break;
	    }

	    shuffle($cloud);
	    	    
	    return implode('', $cloud);
    }

    function getSongsWith($word) {
    	$songs = array();
        foreach ($this->artists as $artist) {
            foreach ($artist->songs as $song) {
            	$count = $song->countWord($word);
            	if ($count!=0) $songs[$song] = $count;
			}
    	}
    	return $songs;
    }

	private function standardDeviation($words, $mean) {
		$sum = 0;
		foreach($words as $word => $freq) {
			$sum += pow($freq-$mean, 2);
		}
		return sqrt($sum / count($words));
	}

	private function shuffle_assoc($list) { 
		if (!is_array($list)) return $list; 

		$keys = array_keys($list); 
		shuffle($keys); 
		$random = array(); 
		foreach ($keys as $key) { 
			$random[$key] = $list[$key]; 
		}
		return $random; 
	} 
}

?>