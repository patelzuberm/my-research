<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Innovify :: G+ & YT Social Media Counts</title>

        <link type="text/css" rel="stylesheet" href="css/style.css">
        <link type="text/css" rel="stylesheet" href="css/example.css">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    </head>
 
    <body>
        
     <div class="webcodo-top" >
        <a href="http://www.webcodo.net/facebook-twitter-google-instagram-dribbble-followers-jquery-ajax">
            <div class="wcd wcd-tuto"> </div>
        </a>
        <a href="http://webcodo.com">
            <div class="wcd wcd-logo">Innovify Social Counters</div>
        </a>
        <div class="wcd"></div>
    </div>

    <script type="text/javascript">

    var count_url = 'social_count.php';
    var social_networks = [
            //'wcd_facebook',
            'wcd_youtube',
           // 'wcd_twitter',
           // 'wcd_dribbble',
           // 'wcd_vimeo',
           // 'wcd_soundcloud',
            'wcd_gplus',
            //	'wcd_instagram'
        ];
    $(function(){ 
        $.each(social_networks, function(key){
            $('.'+social_networks[key]).html('<img style="margin-left:50px;" src="img/ajax-loader.gif" />');
        });
    
        $.each(social_networks, function(key){
            $.ajax({
                type: "POST",
                url: count_url,
                data: 'act='+social_networks[key],
                error : 'error',
                success:function(html){
                    $('.'+social_networks[key]).html(html);
                }
            });
        });
    });
    
    </script>
	<?php
$json_output = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=statistics&id=vGHpYOasRec&key=AIzaSyDksehOi4G_812ZPNYgqd2YNP53uLVEbg0");
$youtubeDetail = json_decode($json_output,true);
$viewCounts = $youtubeDetail['items'][0]['statistics']['viewCount'];
	?>
    <div class="tuto-cnt">
<img src="https://lh3.googleusercontent.com/-TsFadOX_6es/AAAAAAAAAAI/AAAAAAAAA5k/shOIQr3M2PI/s120-c/photo.jpg"/>
        <div class="horizontal-cnt">

            
            <div class="soc-cnt">
                <div class="soc-img  gplus-icon"></div>
                <div class="soc-count wcd_gplus"></div>
                <div class="soc-lab">Followers</div>
            </div><!-- gplus container -->
			
			<div class="soc-cnt">
                <div class="soc-img  gplus-icon"></div>
                <div class="soc-count ">92,323</div>
                <div class="soc-lab">Page View</div>
            </div><!-- gplus container -->
			
			<div class="soc-cnt">
                <div class="soc-img  gplus-icon"></div>
                <div class="soc-count ">4,293</div>
                <div class="soc-lab">Circled</div>
            </div><!-- gplus container -->

			
            

        </div><!-- /horizontal-cnt {horizontal container} -->

			<div class="soc-cnt">
                <div class="soc-img  youtube-icon"></div>
                <div class="soc-count "><?php echo $viewCounts ?></div>
                <div class="soc-lab">viewCount</div>
            </div><!-- gplus container -->

        


    </div><!-- /tuto-cnt -->



     


</body>
</html>