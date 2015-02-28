<?php
/**
 * Created by PhpStorm.
 * User: Janet
 * Date: 2/25/2015
 * Time: 10:42 AM
 */

require_once 'RapGenius-PHP-master/src/rapgenius.php';
require_once 'RapGenius-PHP-master/src/rap_genius_wrapper.php';


function getLyrics($artist_results)
{
    $rapgenius = new RapGenius();

    $artists = array();
    foreach ($artist_results as $artist) {
        $artists[$artist] = array();
        $song_results = $rapgenius->param_q(array('q' => $artist))
            ->execute_request();
    //print_r($song_results);

        $songs = array();

        foreach ($song_results as $song) {
            $songs[] = array(
                'title' => $song['result']['title'],
                'id' => $song['result']['id'],
                'lyrics' => lyricsByID($song['result']['id'])['lyrics']
            );
        }
        $artists[$artist]['songs'] = $songs;
    }

    return $artists;
}




//$songs = array();
//foreach($albums as $album) {
//    $songs[] = tracklist($album['link']);
//}
//
//print_r($songs);

