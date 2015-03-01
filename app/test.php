<?php

require_once('WordCloud.php');

$data = array(
		"Blink 182" => array(
				array(
					"id" => "fdsafds324fds",
					"title" => "All the small things",
					"lyrics" => "Lots of small things, so small"
				), array(
					"id" => "12fds54232f",
					"title" => "When I was young",
					"lyrics" => "I wish I was young again"
				)
			),
		"Disclosure" => array (
				array(
					"id" => "fdsaf8ds978",
					"title" => "You & Me",
					"lyrics" => "disclosure is so amazing"
				), array(
					"id" => "fds789fds78",
					"title" => "Latch",
					"lyrics" => "You latch onto me, oh ya ya")
			)
		);


$WC = new WordCloud();
$err = $WC->loadData($data);
if (!isset($err)) {
	$err = $WC->countWordFreq();
	if (!isset($err)) {
		echo $WC->generateWC();
	} else {
		echo $err;
	}
} else {
	echo $err;
}

?>