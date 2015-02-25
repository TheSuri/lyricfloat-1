<?php 
	session_start();
	$alert   = $_SESSION['alert'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">	
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<title>LyricFloat - Lyrical Word Clouds</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/stylesheets/styles.css">
	<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
	<div class="alert alert-success hide" role="alert"></div>
	<div class="alert alert-danger hide" role="alert"></div>
  	<div class="header">
		<h1>LyricFloat</h1>
	</div>

	<!-- START BLOCK -->



	<form  id="artist_name_form" action="getLyricsForWC.php">
		<div class="center-block">
			<div>
				<input form="artist_name_form" type="search" name="artist_name" autofocus required placeholder="Artist Name">
			</div>
			<div>
			   <input class="btn btn-xs btn-default" type="submit">			
			</div>
		</div>
	</form>



	<!-- END BLOCK -->
</div>
</body>
</html>
<script type="text/javascript">
	$(document).ready(function() {
	<?php if (isset($alert['success']) ) { ?>
		$('.alert-success').html('<?php echo $alert['success'] ?>').toggleClass('hide');
	<? } elseif (isset($alert['error']) ) { ?>
		$('.alert-danger').html('<?php echo $alert['error'] ?>').toggleClass('hide');
	<? } ?>
	});
</script>
