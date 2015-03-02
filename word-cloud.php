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
		<meta property="og:url" content="UP TOP!!!" /> 
		<meta property="og:type" content="Word Cloud" />
		<meta id="fb_image" property="og:image" />
	</head>

	<body>
		<div class="container">
			<div class="wrapper">
				<div class="header">
					<a href="/LyricFloat/"><img src="assets/images/LyricFloat.png" height="35%" width="35%" /></a>
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
						   								

							<img id="share_btn" src="/LyricFloat/assets/images/share_button.png" >

						   <button id="new_cloud_btn" class="third-button" type="submit">Submit</button>		
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js" type="text/javascript"></script>
<script src="assets/javascript/html2canvas.js" type="text/javascript"></script>
<script src="assets/javascript/base64binary.js" type="text/javascript"></script>
<script type="text/javascript">
	// (function() {
	// 	var e = document.createElement('script');
	// 	e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
	// 	e.async = true;
	// 	document.getElementById('fb-root').appendChild(e);
	// }());
	// window.fbAsyncInit = function() {
	// 	FB.init({
	// 	  appId  : '1422647264695991',
	// 	  status : true, // check login status
	// 	  cookie : true, // enable cookies to allow the server to access the session
	// 	  xfbml  : true  // parse XFBML
	// 	});
	// };
	function addToCloud() {
		$("input[type=checkbox]").prop('checked', true);
		$("#artist_name_form").submit();
	};
	(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=1422647264695991&version=v2.0";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));

	$(document).ready(function(){
		var decodedPng;
		html2canvas(document.getElementById("wordcloud"), { height: null }).then(function(canvas) {
			var data = canvas.toDataURL("image/png"); //get's image string
			var encodedPng = data.substring(data.indexOf(',') + 1, data.length);
			// decodedPng = Base64Binary.decode(encodedPng);

            $.ajax({
                url: 'https://api.imgur.com/3/image',
                headers: {
                    'Authorization': 'Client-ID ea64f4ea98a0bb8'
                },
                type: 'POST',
                data: {
                    'image': encodedPng,
                    'type': 'base64'
                },
                success: function(response) {
                    decodedPng = response.data.link;
                }, error: function() {
                    alert("Error while uploading...");
                }
            });

			$('#share_btn').click(function(e){
				e.preventDefault();
				FB.ui({
					method: 'feed',
					name: 'LyricFloat word cloud!',
					link: 'http://localhost:8888/LyricFloat',
					picture: decodedPng,
					caption: 'Come and see the word cloud I generated.',
					description: 'Such Lyric, so float, much cloud.'
				});
			});
		});

		// $('#share_btn').click(function(e){
		// 	e.preventDefault();
		// 	FB.ui({
		// 		method: 'share_open_graph',
		// 		action_type: 'og.likes',
		// 		action_properties: JSON.stringify({
		// 			object:'http://www.mushroomsensei.com',
		// 			name: 'LyricFloat word cloud!',
		// 			link: ' http://localhost:8888/LyricFloat',
		// 			picture: "http://images.forbes.com/30under30/images/footer/under30-standouts.jpg",
		// 			caption: 'Come and see the word cloud I generated.',
		// 			description: 'Such Lyric, so float, much cloud.'
		// 		})
		// 	}, function(response){});
		// });
	});
</script>
