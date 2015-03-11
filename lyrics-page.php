<?php
	$artist = null;
	$song_name = null;
	require_once('app/WordCloud.php');
	require_once('app/search_rapgenius.php');
	require_once('RapGenius-PHP-master/src/rapgenius.php');
	require_once('RapGenius-PHP-master/src/rap_genius_wrapper.php');

	session_start();
	$WC = $_SESSION['WC'];
	if (!isset($WC)) {
		$data = getLyrics($_GET['artists'], new RapGenius());
		$WC = new WordCloud();
		$WC->generateCloud($data);
		$_SESSION['WC'] = $WC;
	}	
	if (isset($_GET['artist'])) $artist = $_GET['artist'];
	if (isset($_GET['song_name'])) $song_name = $_GET['song_name'];
	if (isset($_GET['searched_word'])) $searched_word = $_GET['searched_word'];
?>

<!DOCTYPE html>
	<head>
		<title>LyricFloat - Lyrics Page</title>
		<link rel="stylesheet" type="text/css" href="assets/stylesheets/styles.css">
		<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
	</head>

	<body>
		<div class="container">
			<div class="wrapper">
				<div class="header">
					<a href="/LyricFloat/"><img src="assets/images/LyricFloat.png" height="35%" width="35%" /></a>
				</div>
				<div class="lyric-page-wrap">
					<div id="song-info">
						<span id="song-name"><?php if (isset($song_name) && isset($artist)) echo "{$artist} - {$song_name}"; else echo "Please select a song"; ?></span>
					</div>
					<div class="song-lyrics">
						<div class="lyrics">
							<?php
								if (isset($song_name) && isset($artist)) {
									echo "<pre>".$WC->artists[$artist]->songs[$song_name]->lyrics."</pre>";
								} else {
									$_SESSION["alert"] = "Error: Please select a song to display";
									header("Location: http://localhost/LyricFloat/song-page.php");
								}								
							?>
						</div>
					</div>
				</div>
				<div class="nav-manager">
					<button class="third-button" type="submit" onclick="window.location.href='/LyricFloat/song-page.php'">Song Selection</button>
					<button class="third-button" type="submit" onclick="window.location.href='/LyricFloat/word-cloud.php'">Word Cloud</button>
				<div>
			</div>
		</div>

	</body>
</html>
<script type="text/javascript">
	$(document).ready(function(){
		var query = new RegExp("(\\b" + "<?php echo $searched_word ?>" + "\\b)", "gim");
	    var e = $(".lyrics")[0].innerHTML;
	    var enew = e.replace(/(<span>|<\/span>)/igm, "");
	    $(".lyrics")[0].innerHTML = enew;
	    var newe = enew.replace(query, "<span>$1</span>");
	    $(".lyrics")[0].innerHTML = newe;
	});
</script>