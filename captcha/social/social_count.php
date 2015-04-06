<?php
/**
 * Social count - Social Network Followers Counter
 *
 * @package    social count
 * @author     Amine Kacem <amine@webcodo.net>
 * @copyright  Copyright (c) 2013 - present Stephan Schmitz
 * @license    MIT License
 * @updated    2013/08/25
 */


/*$facebook_page = '';
$youtube_channel = '';
$dribbble_username = '';
$vimeo_username = '';

/* Twitter */
// to create a new app go to this link https://dev.twitter.com/apps/new
/*$twitter_username = '';
$oauth_access_token = "";
$oauth_access_token_secret = "";
$consumer_key = "";
$consumer_secret = "";

//instagram
$instagram_userID = '';
$instagram_accessToken = '';
*/
// Google plus
// To create a new app : https://code.google.com/apis/console/
$gplus_pageID = '118442472584046336092'; // This is must be a PAGE ID not a profile
$gplus_api_key = 'AIzaSyDksehOi4G_812ZPNYgqd2YNP53uLVEbg0';

// SoundCloud
// To create a new app : http://soundcloud.com/you/apps/new
/*$soundcloud_username = '';
$soundcloud_clientID = '';

*/
$cache = "cache/count.wcd";
$expire = 900; // valable 15 minutes


/*********************************************** */


//create the cache file if dont exist
if(!file_exists($cache) or (filemtime($cache) > $expire)){
	file_put_contents($cache, '{}');
}
	function update_cache($cache_url, $cache_data){
		//update the cache file
		$fh = fopen($cache_url, 'w')or die("Error opening output file");
		fwrite($fh, json_encode($cache_data,JSON_UNESCAPED_UNICODE));
		fclose($fh);
	}
	
	function nbr_format($nbr){
		if(is_numeric($nbr)){
			return number_format($nbr);
		}else{ return null;}
	}

	function instagram_followers($userID, $access_token, $cache, $expire){
		if(strlen($userID) > 1){
			$instaLink = 'https://api.instagram.com/v1/users/'.$userID.'?access_token='.$access_token;
			$expire = time()-$expire;
			$cache_data = FetchData($cache);
			if((filemtime($cache) < $expire) or (!isset($cache_data->instagram))){
				$insta_followers = $cache_data->instagram = FetchData($instaLink)->data->counts->followed_by;
				update_cache($cache, $cache_data);
			}else{
				$insta_followers = $cache_data->instagram;
			}
			return nbr_format($insta_followers);
		}else{ return null; }
	}

	function gplus_cercles($gplus_id, $gplus_key, $cache, $expire){
		if(strlen($gplus_id) > 1){
			$gplusLink = 'https://www.googleapis.com/plus/v1/people/'.$gplus_id.'?key='.$gplus_key;
			$expire = time()-$expire;
			$cache_data = FetchData($cache);
			if((filemtime($cache) < $expire) or (!isset($cache_data->gplus))){
				$gplus_followers = $cache_data->gplus = FetchData($gplusLink)->circledByCount;
				update_cache($cache, $cache_data);
			}else{
				$gplus_followers = $cache_data->gplus;
			}
			return nbr_format($gplus_followers);
		}else{ return null;}
	}

	function facebook_fans($fb_page, $cache, $expire){
			$expire = time()-$expire;
			$facebookUrl = 'http://graph.facebook.com/'.$fb_page;
			$cache_data = FetchData($cache);
			if((filemtime($cache) < $expire)  or (!isset($cache_data->facebook))){
				$fb_fans =  $cache_data->facebook = FetchData($facebookUrl)->likes;
				update_cache($cache, $cache_data);
			}else{
				$fb_fans = $cache_data->facebook;
			}
			return nbr_format($fb_fans);
	}

	function youtube_subscribers($yt_channel, $cache, $expire){
			$expire = time()-$expire;
			$cache_data = FetchData($cache);
			$ytUrl = 'http://gdata.youtube.com/feeds/api/users/'.$yt_channel.'?alt=json';
			if((filemtime($cache) < $expire) or (!isset($cache_data->youtube))){
				$yt_subscribers =$cache_data->youtube = FetchData($ytUrl)->entry->{'yt$statistics'}->subscriberCount;
				update_cache($cache, $cache_data);
			}else{
				$yt_subscribers = $cache_data->youtube;
			}
			return nbr_format($yt_subscribers);
	}


	function twitter_followers($username, $consumer_key, $consumer_secret, $oauth_access_token, $oauth_access_token_secret, $cache, $expire){
		$expire = time()-$expire;
		$cache_data = FetchData($cache);
		if((filemtime($cache) < $expire) or (!isset($cache_data->twitter))){
			include ('twitteroauth/twitteroauth.php');
			$twitterConnection = new TwitterOAuth($consumer_key, $consumer_secret, $oauth_access_token, $oauth_access_token_secret);
			// Send the API request
			$twitterData = $twitterConnection->get('users/show', array('screen_name' => $username));
			// Extract the follower and tweet counts
			$twt_followers = $cache_data->twitter = $twitterData->followers_count;
			update_cache($cache, $cache_data);
		}else{
			$twt_followers = $cache_data->twitter;
		}
		return nbr_format($twt_followers);
	} 


	function dribbble_followers($drbl_un, $cache, $expire){
			$drbl = 'http://api.dribbble.com/players/'.$drbl_un;
			$expire = time()-$expire;
			$cache_data = FetchData($cache);
			if((filemtime($cache) < $expire) or (!isset($cache_data->dribbble))){
				$drb_followers = $cache_data->dribbble = FetchData($drbl)->followers_count;
				update_cache($cache, $cache_data);
			}else{
				$drb_followers = $cache_data->dribbble;
			}
			return nbr_format($drb_followers);
	}

	function vimeo_followers($vimeo_un, $cache, $expire){
		if(strlen($vimeo_un) > 1){
			$vimlink = 'http://vimeo.com/api/v2/'.$vimeo_un.'/info.json';
			$expire = time()-$expire;
			$cache_data = FetchData($cache);
			if((filemtime($cache) < $expire) or (!isset($cache_data->vimeo))){
				$vimeo_contacts = $cache_data->vimeo = FetchData($vimlink)->total_contacts;
				update_cache($cache, $cache_data);
			}else{
				$vimeo_contacts = $cache_data->vimeo;
			}
			return nbr_format($vimeo_contacts);
		}else{ return null;}
	}
	function soundcloud_followers($soundc_un, $soundc_id, $cache, $expire){
		if(strlen($soundc_un) > 1){
			$scLink = 'http://api.soundcloud.com/users/'.$soundc_un.'.json?client_id='.$soundc_id;
			$expire = time()-$expire;
			$cache_data = FetchData($cache);
			if((filemtime($cache) < $expire) or (!isset($cache_data->soundcloud))){
				$sc_followers = $cache_data->soundcloud = FetchData($scLink)->followers_count;
				update_cache($cache, $cache_data);
			}else{
				$sc_followers = $cache_data->soundcloud;
			}
			return nbr_format($sc_followers);
		}else{ return null; }
	}

	function FetchData($json_url='',$use_curl=false){
	    if($use_curl){
	        $ch = curl_init();
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	        curl_setopt($ch, CURLOPT_URL, $json_url);
	        $json_data = curl_exec($ch);
	        curl_close($ch);
	        return json_decode($json_data);
	    }else{
	        $json_data = @file_get_contents($json_url);
	        if($json_data == true){
	        	return json_decode($json_data);
	    	}else{ return null;}
	    }
	}

	extract($_POST);
	switch ($act) {
		case 'wcd_facebook'		: 	echo facebook_fans($facebook_page, $cache, $expire);	break;
		case 'wcd_youtube'		:	echo youtube_subscribers($youtube_channel, $cache, $expire);	break;
		case 'wcd_twitter'		: 	echo twitter_followers($twitter_username, $consumer_key, $consumer_secret, $oauth_access_token, $oauth_access_token_secret, $cache, $expire);	break;
		case 'wcd_dribbble'		: 	echo dribbble_followers($dribbble_username, $cache, $expire);	break;
		case 'wcd_vimeo'		: 	echo vimeo_followers($vimeo_username, $cache, $expire);		break;
		case 'wcd_soundcloud'	: 	echo soundcloud_followers($soundcloud_username, $soundcloud_clientID, $cache, $expire);	break;
		case 'wcd_gplus'		: 	echo gplus_cercles($gplus_pageID, $gplus_api_key, $cache, $expire);	break;
		case 'wcd_instagram'	: 	echo instagram_followers($instagram_userID, $instagram_accessToken, $cache, $expire);	break;
		
		default: echo '...'; break;
	}





?>