<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

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
    echo "<br/>".$i;
}

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
		echo 'no';
		return false;
		}
	else {
		$url = "http://gdata.youtube.com/feeds/api/videos/".$youtubeId;
		$check = get_headers($url, 0);
		if (!preg_match('/200/',(string)$check[0])===false){
			echo $youtubeId;
			return $youtubeId;
		}
		else 
			checkYoutubeID(substr($youtubeId, 0, -1));
	}
	
}