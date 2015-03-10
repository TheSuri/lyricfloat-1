<?php 
	session_start();
	// $alert = $_SESSION['alert'];
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>LyricFloat - Lyrical Word Clouds</title>
		<link rel="stylesheet" type="text/css" href="assets/stylesheets/styles.css">
		<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
		<meta charset="utf-8">	
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>
		<div class="container">			
			<div class="wrapper">
			<div class="header">
				<a href="/LyricFloat/"><img src="assets/images/LyricFloat.png" height="35%" width="35%" /></a>
			</div>
			<form  id="artist_name_form" action="word-cloud.php">	
				<div>
					<input id="search-box" form="artist_name_form" type="search" name="artist_name" autofocus required placeholder="Artist Name">
				</div>
				<div class="inner-wrap">
				   <button class="button" type="submit">Submit</button>		
				</div>
			</form>
			</div>
		</div>
	</body>
</html>
<script type="text/javascript">
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