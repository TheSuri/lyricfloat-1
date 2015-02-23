<?php
/**
 * Created by PhpStorm.
 * User: Janet
 * Date: 2/20/2015
 * Time: 4:17 AM
 */

/*
 * Gets all the matching artists that match the artist name
 */

$artist_name = $_REQUEST['artist_name'];
//simply for testing purposes
$artist_name = 'Radiohead';

//if artist name is not in REQUEST
if (empty($artist_name))
    exit("Error: No artist name given.");

//wrapper that allows for easy access to artist names
require_once 'php-echonest-api-master/lib/EchoNest/Autoloader.php';
EchoNest_Autoloader::register();

$echonest = new EchoNest_Client();

//API Key... perhaps this should be hidden in a 'secret' file
$apikey = 'HBYJBMW3HY66L5L8D';
$echonest->authenticate($apikey);

$results = $echonest->getArtistApi()->search(array('name' => $artist_name));
print_r($results);