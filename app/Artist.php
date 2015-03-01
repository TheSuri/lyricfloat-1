<?php

require_once('Song.php');

	class Artist {
	    public $name;
	    public $songs = array();

	    function __construct($name) {
			$this->name = $name;
		}

	}

?>