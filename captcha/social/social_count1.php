<?php
/* 
* © WTFPL
* by necenzurat
* Updated: 19 May 2013
*/
 
 
//$id = @$_GET["id"];
$id = "118442472584046336092";//118442472584046336092
$link = "https://plus.google.com/u/0/$id/posts?hl=en";
$data = file_get_contents($link);

 //<span role="button" class="a-n S1xjN" tabindex="0">1.001 persoane</span>
function get_my_google_plus_profile($data)
	{
		
		// 'have X in circles' element
		preg_match('/<span role="button" class="a-n S1xjN" tabindex="0">(.*?)<\/span>/s', $data, $followers);
 
		if (isset($followers) && !empty($followers))
		{
			
			$count = $followers[1];
			$circles1 = preg_replace('/[^0-9_]/', '', $count);
		}
		if (empty($circles))
		{
			$circles = 0;
		}
 
		// 'in x circles' element
		preg_match('/<span role="button" class="a-n Cl7aRc" tabindex="0">(.*?)<\/span>/s', $data, $following);
 
		if (isset($following) && !empty($following))
		{
			$count = $following[1];
			$circles2 = preg_replace('/[^0-9_]/', '', $count);
		}
		if (empty($circles))
		{
			$circles = 0;
		}
 

		$return = array('followers' => @$circles1, 
				'following' => @$circles2
				);
		return $return;
	}
 
var_dump(get_my_google_plus_profile($data));
?>