<?php

/**
* Template Name: Actor List
*
* @package WordPress
* @subpackage Twenty_Twenty_One
* @since Twenty Twenty-One 1.0
*/

get_header(); ?>

<?php if ( is_home() && ! is_front_page() && ! empty( single_post_title( '', false ) ) ) : ?>
	<header class="page-header alignwide">
		<h1 class="page-title"><?php single_post_title(); ?></h1>
	</header><!-- .page-header -->
<?php endif; ?>


<?php
$peopleList = [];
$curl = curl_init();


curl_setopt_array($curl, array(
	CURLOPT_URL => "https://api.themoviedb.org/3/discover/movie?api_key=1d956d7a1dc587e9626ed1d88b8a0c02&language=en-US",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {

	$movieList = json_decode($response);
	
}

curl_setopt_array($curl, array(
	CURLOPT_URL => "https://api.themoviedb.org/3/configuration?api_key=1d956d7a1dc587e9626ed1d88b8a0c02",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
	$config = json_decode($response);
	
}



curl_setopt_array($curl, array(
	CURLOPT_URL => "https://api.themoviedb.org/3/genre/movie/list?api_key=1d956d7a1dc587e9626ed1d88b8a0c02",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
	$genres = json_decode($response);
	$genres = ($genres->genres);
}


curl_setopt_array($curl, array(
	CURLOPT_URL => "https://api.themoviedb.org/3/person/popular?api_key=1d956d7a1dc587e9626ed1d88b8a0c02",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
	$popularPeople = json_decode($response);
	
}



for($i=1 ; $i<100; $i++){
curl_setopt_array($curl, array(
	CURLOPT_URL => "https://api.themoviedb.org/3/person/popular?api_key=1d956d7a1dc587e9626ed1d88b8a0c02&page=".$i,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
	$people = json_decode($response);
	$peopleList = array_merge($peopleList, $people->results); 
}
}

//print_r( array_values( $genres ));
function compare($a, $b)
{
   return ($a->name> $b->name);
}
usort($peopleList, "compare");

?>
<div class="container">
	<div class="row">
		<ul>
    <?php

        //print_r(($movies));
        foreach($peopleList as $p){?>
        	<li>
        	<a href="/wordpress/actor-detail?actorId=<?php echo($p->id);?>">
        		<?php echo($p->name);?>
        	</a>
        	</li>


        <?php }?>
	</ul>
	</div>
</div>






<?php


get_footer();
?>
