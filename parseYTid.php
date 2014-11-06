<?php

/** PHP Youtube ID grabber
 * Created to grab the Youtube video ID from a URL of various formats, using Regex and Php parsers.
 * 
 * Includes test cases with output.  
 * jle
 **/

function getYoutubeId($url){
	if (!strrpos($url,"v=")===false) {
		parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
		echo $my_array_of_vars['v'];  
	}
	else {
		$youtubeId = substr($url,(strrpos($url,'/'))+1);
		checkYoutubeID($youtubeId);
	}
}

function checkYoutubeId($youtubeId){
	if (strlen($youtubeId)==0){
		echo 'ID is invalid';
		return false;
		}
	else {
		$url = "http://gdata.youtube.com/feeds/api/videos/".$youtubeId;
		$check = get_headers($url, 0); //Check if valid ID via HTTP request of gdata site.
		if (!preg_match('/200/',(string)$check[0])===false){
			echo $youtubeId;
			return $youtubeId;
		}
		else 
			checkYoutubeID(substr($youtubeId, 0, -1)); //Deals with jargon at the end of URLs
	}
}

// Main // Test Cases
$urls = array("http://youtu.be/0Bmhjf0rKe8",
	"http//www.youtube.com/embed/0Bmhjf0rKe8",
	"http//www.youtube.com/watch?v=0Bmhjf0rKe8",
	"http//www.youtube.com/?v=0Bmhjf0rKe8",
	"http//www.youtube.com/v/0Bmhjf0rKe8",
	"http//www.youtube.com/e/0Bmhjf0rKe8",
	"http//www.youtube.com/user/username#p/u/11/0Bmhjf0rKe8",
	"http//www.youtube.com/sandalsResorts#p/c/54B8C800269D7C1B/0/0Bmhjf0rKe8BLAHHHHH",
	"http//www.youtube.com/watch?feature=player_embedded&v=0Bmhjf0rKe8",
	"http//www.youtube.com/?feature=player_embedded&v=0Bmhjf0rKe8");
foreach ($urls as $i => $value) {
    getYoutubeID($value);
    echo "<br/>";
}


/** 
 * ID is then used to interact with the Youtube API to grab the video's metadata. 
 *	
 * http://gdata.youtube.com/feeds/api/videos/--> ID HERE <--?v=2&prettyprint=true&alt=jsonc
 **/