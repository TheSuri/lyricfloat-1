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
						if (isset($_GET['artists'])) {
						    $artists = $_GET['artists'];
							try {
								if (!isset($WC)) {
									$WC = new WordCloud();
									$data = getLyrics($artists, new RapGenius());
									$WC->generateCloud($data);
								} else {
									// Get rid of saved artists that were not searched for
									foreach ($WC->artists as $artist_name => $artist) {
										if (!in_array($artist_name, $artists)) {
											unset($WC->artists[$artist_name]);
										}
									}
									foreach ($artists as $artist) {
									    if (!isset($WC->artists[$artist])) {
											$data = getLyrics(array($artist), new RapGenius());
											$WC->mergeData($data);
									    }
									}
									$WC->filter_stopwords();
									$WC->countWordFreq();
								}
								$_SESSION['WC'] = $WC;
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
							<input id="search-box" form="artist_name_form" type="search" name="artists[]" autofocus required placeholder="Artist Name">
							<!-- <input form="artist_name_form" type="checkbox" name="clear_artist" style="display:none;"> -->
						</div>
						<div class="inner-wrap">
							<button id="add_to_cloud_btn" class="third-button" onclick="addToCloud(event)">Add To Cloud</button>
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
	function addToCloud(e) {
		e.preventDefault();
		var artists = <?php echo json_encode($_GET['artists']); ?>;
		artists.push($("#search-box").val());
		console.log(artists);
		// $("#artist_name_form").submit();
		location.href = '/LyricFloat/word-cloud.php?'+artists.map(function(artist) {
			return encodeURIComponent("artists[]="+artist);
		}).join("&");
	};
	(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=1422647264695991&version=v2.0";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
	// $(document).ready(function(){
	// 	var decodedPng;
	// 	html2canvas(document.getElementById("wordcloud"), { height: null }).then(function(canvas) {
	// 		var data = canvas.toDataURL("image/png");
	// 		var encodedPng = data.substring(data.indexOf(',') + 1, data.length);
 //            $.ajax({
 //                url: 'https://api.imgur.com/3/image',
 //                headers: {
 //                    'Authorization': 'Client-ID ea64f4ea98a0bb8'
 //                },
 //                type: 'POST',
 //                data: {
 //                    'image': encodedPng,
 //                    'type': 'base64'
 //                },
 //                success: function(response) {
 //                    decodedPng = response.data.link;
 //                }, error: function() {
 //                    alert("Error while uploading...");
 //                }
 //            });
	// 		$('#share_btn').click(function(e){
	// 			e.preventDefault();
	// 			FB.ui({
	// 				method: 'feed',
	// 				name: 'LyricFloat word cloud!',
	// 				link: 'http://localhost/LyricFloat',
	// 				picture: decodedPng,
	// 				caption: 'Come and see the word cloud I generated.',
	// 				description: 'Such Lyric, so float, much cloud.'
	// 			});
	// 		});
	// 	});
	// });
	$('#search-box').autocomplete({
		source:
		function (query, process) {
			$.when(
				$.ajax({
				    url: 'http://ws.spotify.com/search/1/artist.json?q=' + query.term,
				})
			).then(function (data) {
				var process_data = [];
				$.each(data.artists.slice(0, 4), function(i, item) {
				  $.when (
				   $.ajax({
				      url: 'https://embed.spotify.com/oembed/?url=' + item.href,
				      dataType: 'jsonp'
				   })
				  ).then(function (image) {
	                process_data.push( { label: item.name, image: image.thumbnail_url.replace("cover", "60")} );
	                process( process_data );
	              });
				});
			});
		},
		open: function(event, ui) {
			event.preventDefault();
			console.log(ui.item.image);
			console.log($(this));
			$(this).html("<img src="+ui.item.image+">");
		},
		select: function (e, ui) {
			e.preventDefault();
			$(this).val(ui.item.label);
		},
		messages: {
			noResults: '',
			results: function() {}
		}
	}).data('ui-autocomplete')._renderItem = function(ul, item) {
      return $('<li>')
          .data( "ui-autocomplete-item", item)
          .append('<img width="50" src="' + item.image + '"/>' + '<span class="ui-autocomplete-artist">' + item.label  + '</span>')
          .appendTo(ul);
    };
</script>
