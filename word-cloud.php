<?php  
	require_once('app/WordCloud.php');
	require_once('app/search_rapgenius.php');
	require_once('RapGenius-PHP-master/src/rapgenius.php');
	require_once('RapGenius-PHP-master/src/rap_genius_wrapper.php');
	session_start();
	$WC = $_SESSION['WC'];
?>


<!DOCTYPE html>
	<head>
		<title>LyricFloat - Word Cloud</title>
		<link rel="stylesheet" type="text/css" href="assets/stylesheets/styles.css">
		<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
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
									$data = getLyrics(array($artist), new RapGenius());
									if (isset($_GET['additional_artist']) && $_GET['additional_artist']) {
										$WC->mergeData($data);
									}
									else { 
										$WC = new WordCloud();
										$WC->generateCloud($data);
									}
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
				<div id="fb-root"></div>
				<div class="wc_form">
					<form  id="artist_name_form" action="/LyricFloat/word-cloud.php">
						<div>
							<input form="artist_name_form" type="checkbox" name="additional_artist" style="display:none;">
							<input id="search-box" form="artist_name_form" type="search" name="artist_name" autofocus required placeholder="Artist Name">
						</div>
						<div class="inner-wrap">
							<button id="add_to_cloud_btn" class="third-button" onclick="addToCloud()">Add To Cloud</button>
							<img id="share_btn" src="/LyricFloat/assets/images/share_button.png" >
							<button id="new_cloud_btn" class="third-button" type="submit">Submit</button>		
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
<script src="assets/javascript/html2canvas.js" type="text/javascript"></script>
<script src="assets/javascript/base64binary.js" type="text/javascript"></script>
<script type="text/javascript">
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
			var data = canvas.toDataURL("image/png");
			var encodedPng = data.substring(data.indexOf(',') + 1, data.length);
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
					link: 'http://localhost/LyricFloat',
					picture: decodedPng,
					caption: 'Come and see the word cloud I generated.',
					description: 'Such Lyric, so float, much cloud.'
				});
			});
		});
	});
	$('#search-box').autocomplete({
		source:
		function (query, process) {
			$.when(
				$.ajax({
				    url: 'http://ws.spotify.com/search/1/album.json?q=' + query.term,
				})
			).then(function (data) {
				var process_data = [];
				$.each(data.albums.slice(0, 4), function(i,item) {
				  $.when (
				   $.ajax({
				      url: 'https://embed.spotify.com/oembed/?url=' + item.href,
				      dataType: 'jsonp'
				   })
				  ).then(function (image) {
				    process_data.push( { label: item.artists[0].name } );
				    process( process_data );
				  });
				});
			});
		},
		open: function(event, ui) {
			event.preventDefault();
		},
		select: function (e, ui) {
			e.preventDefault();
			$(this).val(ui.item.label);
		},
		messages: {
			noResults: '',
			results: function() {}
		}
	});
</script>
