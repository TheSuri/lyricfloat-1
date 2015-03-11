<?php
	$songs = null;
	require_once('app/WordCloud.php');

	session_start();
	$WC = $_SESSION['WC'];
	if (!isset($WC)) {
		$data = getLyrics($_GET['artists'], new RapGenius());
		$WC = new WordCloud();
		$WC->generateCloud($data);
		$_SESSION['WC'] = $WC;
	}
	if (isset($_GET['searched-word'])) {
		$searched_word = $_GET['searched-word'];
		$_SESSION['searched_word'] = $searched_word;
	} else {
		$searched_word = $_SESSION['searched_word'];
	}
?>

<!DOCTYPE html>
	<head>
		<title>LyricFloat - Song List Page</title>
		<link rel="stylesheet" type="text/css" href="assets/stylesheets/styles.css">
	</head>

	<body>
		<div class="container">
			<div class="wrapper">
				<div class="header">
					<a href="/LyricFloat/"><img src="assets/images/LyricFloat.png" height="35%" width="35%" /></a>
				</div>
				<div class="lyric-page-wrap">
					<div id="song-info">
						<span id="searched-word"><?php if (isset($searched_word)) echo $searched_word; else echo "USER SELECTED WORD"; ?></span>
					</div>
					<div class="song-lyrics">
						<div class="lyrics">
							<?php 
								if (isset($searched_word)) {
									$songs = $WC->getSongsWith($searched_word);
									if (isset($songs)) {
										echo "<ul>";
										$artist_url = $WC->getArtistsURL();
										foreach ($songs as $artist => $a_songs) {
											echo "<h2>{$artist}</h2>";
											foreach ($a_songs as $song => $count) {
												echo "<li><a href='/LyricFloat/lyrics-page.php?{$artist_url}&song_name={$song}&artist={$artist}'>$song ($count)</a></li>";
											}
										}
										echo "</ul>";
									} else {
										echo "Could not find specified artists or songs\nMake sure you've successfully created a word cloud,\n and your session cookies are turned on";
									}
								} else {
									echo "$searched_word is not set";
									// $_SESSION["alert"] = "Error: Please select a word to display";
									// header("Location: http://localhost/LyricFloat/word-cloud.php");
								}
							?>
						</div>
					</div>
				</div>

				<div class="nav-manager">
					<button class="third-button" type="submit" onclick="window.location.href='/LyricFloat/word-cloud.php?'">Back</button>
				<div>
			</div>
		</div>

	</body>
</html>