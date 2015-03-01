<?php
/**
 * Created by PhpStorm.
 * User: Janet
 * Date: 2/20/2015
 * Time: 4:29 AM
 */
/*
 * Gets the songs by a particular artist specifed by the artist ID
 */


$artist_id = $_REQUEST['artist_id'];
//simply for testing purposes
$artist_id = 'ARH6W4X1187B99274F';

//if artist name is not in REQUEST
if (empty($artist_id))
    exit("Error: No artist name given.");

//wrapper that allows for easy access to artist names
require_once '../php-echonest-api-master/lib/EchoNest/Autoloader.php';
EchoNest_Autoloader::register();

$echonest = new EchoNest_Client();

//API Key... perhaps this should be hidden in a 'secret' file
$apikey = 'HBYJBMW3HY66L5L8D';
$echonest->authenticate($apikey);

$results = $echonest->getSongApi()->search(array('artist_id' => $artist_id,
                                                'results' => 100));
print_r($results);