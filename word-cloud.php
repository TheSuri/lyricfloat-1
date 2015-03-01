<?php  
	require_once('app/WordCloud.php');
	require_once('app/search_rapgenius.php');

	session_start();
	$WC = $_SESSION['WC'];
?>


<!DOCTYPE html>
	<head>
		<title>LyricFloat - Word Cloud</title>
		<link rel="stylesheet" type="text/css" href="assets/stylesheets/styles.css">
	</head>

	<body>

		<div class="container">
		<div class="top-bar"></div>
			<!-- <div class="alert alert-success hide" role="alert"></div>
			<div class="alert alert-danger hide" role="alert"></div> -->
			
			<div class="wrapper">
				<div class="header">
					<img src="assets/images/LyricFloat.png" height="35%" width="35%" />
				</div>
				<div class="word-cloud-wrap">
					<?php
					// TODO: Show loading bar
						if (isset($_GET['artist_name']) ) {
						    $artist = $_GET['artist_name'];
							try {
							    if (!isset($WC->artists[$artist])) {
									$data = getLyrics(array($artist));
									$WC = new WordCloud($data);
									$_SESSION['WC'] = $WC;
							    }
								echo $WC->generateWC();
							} catch (Exception $e) {
								echo $e->getMessage();
							}
						} else {
							if (isset($WC)) {
								try {
									echo $WC->generateWC();
								} catch (Exception $e) {
									echo $e->getMesage();
								}
							} else {
								echo "Please provide an artist";
							}
						}
					?>
				</div>
				
				<div class="wc_form">
					<form  id="artist_name_form" action="getLyricsForWC.php">
					
						<div>
							<input form="wc_artist_name_form" type="search" name="artist_name" autofocus required placeholder="Artist Name">
						</div>
						<div class="inner-wrap">
						   <button class="third-button" type="submit">Add To Cloud</button>	
							
							<div id="fb-root"></div>
						   								

							<img id="share_button" src="share_button.png" >

						   <button class="third-button" type="submit">Submit</button>		
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
	window.fbAsyncInit = function() {
		FB.init({
		  appId  : '1422647264695991',
		  status : true, // check login status
		  cookie : true, // enable cookies to allow the server to access the session
		  xfbml  : true  // parse XFBML
		});
	};

	(function() {
		var e = document.createElement('script');
		e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
		e.async = true;
		document.getElementById('fb-root').appendChild(e);
	}());
	$(document).ready(function(){
		$('#share_button').click(function(e){
			e.preventDefault();
			FB.ui({
				method: 'feed',
				name: 'LyricFloat word cloud!',
				link: ' http://www.mushroomsensei.com/',
				picture: 'http://www.osamuko.com/blog/wp-content/uploads/2009/09/8.jpg',
				caption: 'Come and see the word cloud I generated.',
				description: 'Such Lyric, so float, much cloud.',
				message: ''
			});
		});
	});
</script>