<?php

class WC_Word {
	public static $colors = array("#DC143C", "#00FFFF", "#00008B", "#008B8B", "#B8860B", 
		"#A9A9A9", "#006400", "#BDB76B", "#8B008B", "#556B2F", "#FF8C00", "#9932CC", "#8B0000", 
		"#E9967A", "#8FBC8F", "#483D8B", "#2F4F4F", "#00CED1", "#9400D3", "#FF1493", "#00BFFF", 
		"#696969", "#1E90FF", "#B22222");

    public $color;
    public $word;
    public $freq = 1;

    function __construct($word, $freq) {
		$this->color = self::$colors[mt_rand(0, count(self::$colors) - 1)];
		$this->word = $word;
		$this->freq = $freq;
	}
}

?>