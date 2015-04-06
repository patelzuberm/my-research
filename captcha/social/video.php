<?php
$json_output = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=statistics&id=vGHpYOasRec&key=AIzaSyDksehOi4G_812ZPNYgqd2YNP53uLVEbg0");
echo $json_output;
exit;
$json = json_decode($json_output, true);

//This gives you the video description
$video_description = $json['entry']['media$group']['media$description']['$t'];

//This gives you the video views count
$view_count = $json['entry']['yt$statistics']['viewCount'];

//This gives you the video title
$video_title = $json['entry']['title']['$t'];
?>