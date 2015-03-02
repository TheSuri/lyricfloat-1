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
		<meta property="fb:app_id" content="1422647264695991" /> 
		<meta property="og:site_name" content="LyricFloat" />
		<meta property="og:site" content="www.mushroomsensei.com" />
		<meta property="og:title" content="Word Cloud" />
		<meta property="og:description" content="Come check the interactive word cloud I generated!" />
		<meta property="og:url" content="http://www.mushroomsensei.com" /> 
		<meta property="og:type" content="Word Cloud" />
		<meta id="fb_image" property="og:image" />
	</head>

	<body>
		<div class="container">
			<div class="wrapper">
				<div class="header">
					<img src="assets/images/LyricFloat.png" height="35%" width="35%" />
				</div>
				<div id="wordcloud" class="word-cloud-wrap">
					<?php
					// TODO: Show loading bar
						if (isset($_GET['artist_name'])) {
						    $artist = $_GET['artist_name'];
							try {
							    if (!isset($WC->artists[$artist])) {
									$data = getLyrics(array($artist));
									if (isset($_GET['additional_artist']) && $_GET['additional_artist']) 
										$WC->mergeData($data);
									else 
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
					<form  id="artist_name_form" action="/LyricFloat/word-cloud.php">
					
						<div>
							<input form="artist_name_form" type="checkbox" name="additional_artist" style="display:none;">
							<input form="artist_name_form" type="search" name="artist_name" autofocus required placeholder="Artist Name">
						</div>
						<div class="inner-wrap">
						   <button id="add_to_cloud_btn" class="third-button" onclick="addToCloud()">Add To Cloud</button>	
							
							<div id="fb-root"></div>
						   								

							<img id="share_btn" src="share_button.png" >

						   <button id="new_cloud_btn" class="third-button" type="submit">Submit</button>		
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js" type="text/javascript"></script>
<script src="external/html2canvas.js" type="text/javascript"></script>
<script type="text/javascript">
	(function() {
		var e = document.createElement('script');
		e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
		e.async = true;
		document.getElementById('fb-root').appendChild(e);
	}());
	window.fbAsyncInit = function() {
		FB.init({
		  appId  : '1422647264695991',
		  status : true, // check login status
		  cookie : true, // enable cookies to allow the server to access the session
		  xfbml  : true  // parse XFBML
		});
	};
	function addToCloud() {
		$("input[type=checkbox]").prop('checked', true);
		$("#artist_name_form").submit();
	};
	// $(document).ready(function(){
	// 	$('#share_btn').click(function(e){
	// 		e.preventDefault();
	// 			var dataUrl;
	// 			html2canvas(document.getElementById("wordcloud")).then(function(canvas) {
	// 				dataUrl = canvas.toDataURL(); //get's image string
	// 				$("#fb_image").attr("content", dataUrl);
	// 			});			
	// 			FB.ui({
	// 			method: 'feed',
	// 			name: 'LyricFloat word cloud!',
	// 			link: ' http://www.mushroomsensei.com/',
	// 			picture: dataUrl,
	// 			caption: 'Come and see the word cloud I generated.',
	// 			description: 'Such Lyric, so float, much cloud.',
	// 			message: ''
	// 		});
	// 	});
	// });
	$(document).ready(function(){
		$('#share_btn').click(function(e){
			e.preventDefault();
			var dataUrl;
			html2canvas(document.getElementById("wordcloud")).then(function(canvas) {
				dataUrl = canvas.toDataURL(); //get's image string
				$("#fb_image").attr("content", dataUrl);
			});			
			FB.ui({
				method: 'share_open_graph',
				action_type: 'og.likes',
				action_properties: JSON.stringify({
				object:'http://www.mushroomsensei.com',
				})
			}, function(response){});
		});
	});
</script>
