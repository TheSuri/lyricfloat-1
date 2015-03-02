<?php  
	session_start();
	if( isset($_GET['artist_name']) ) {
	    $artist = $_GET['artist_name'];
	    // echo $artist;
	    $_SESSION['alert'] = array('success' => 'The user searched for '.$artist);
	} else {
		$_SESSION['alert'] = array('error' => 'No artist name was submitted');
	}

	header( 'Location: http://localhost/LyricFloat/index.php' );  
?>

