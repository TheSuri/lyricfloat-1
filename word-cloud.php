<?php  
	require_once('app/WordCloud.php');
	require_once('app/search_rapgenius.php');

	session_start();
	$WC = $_SESSION['WC'];
	$WC_html = 'Sorry, we could not find the artist specified';
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
						if( isset($_GET['artist_name']) ) {
						    $artist = $_GET['artist_name'];
							$data = getLyrics(array($artist));

							// TODO: if $WC is already set, then mergeData
							// else create new with $data;
							try {
								$WC = new WordCloud($data);
								$_SESSION['WC'] = $WC;
								echo $WC->generateWC();
							} catch (Exception $e) {
								echo $e->getMessage();
							}
						} else {
							echo "Please provide an artist";
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
						   <button class="fb-third-button" type="submit">TEMP</button>	
						   <button class="third-button" type="submit">Submit</button>		
						</div>
					</form>
				</div>

			</div>
		</div>

	</body>
</html>