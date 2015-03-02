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

		<meta charset="utf-8">	
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">

	    <script type="text/javascript">
			$(document).ready(function() {
			<?php if (isset($alert['success']) ) { ?>
				$('.alert-success').html('<?php echo $alert['success'] ?>').toggleClass('hide');
			<? } elseif (isset($alert['error']) ) { ?>
				$('.alert-danger').html('<?php echo $alert['error'] ?>').toggleClass('hide');
			<? } ?>
			});
		</script>
	</head>

	<body>

		<div class="container">
			<div class="alert alert-success hide" role="alert"></div>
			<div class="alert alert-danger hide" role="alert"></div>
			
			<div class="wrapper">
			<div class="header">
				<a href="/LyricFloat/"><img src="assets/images/LyricFloat.png" height="35%" width="35%" /></a>
			</div>
			<form  id="artist_name_form" action="word-cloud.php">
				
					<div>
						<input form="artist_name_form" type="search" name="artist_name" autofocus required placeholder="Artist Name">
					</div>
					<div class="inner-wrap">
					   <button class="button" type="submit">Submit</button>		
					</div>
			</form>

			</div>

		</div>

	</body>

</html>