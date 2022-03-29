<?php

/**
* Template Name: Actor Detail
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

$curl = curl_init();


curl_setopt_array($curl, array(
	CURLOPT_URL => "https://api.themoviedb.org/3/person/".$_GET['actorId']."?api_key=1d956d7a1dc587e9626ed1d88b8a0c02&language=en-US",
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

	$actorDetail = json_decode($response);
	
}


curl_setopt_array($curl, array(
	CURLOPT_URL => "https://api.themoviedb.org/3/person/".$_GET['actorId']."/images?api_key=1d956d7a1dc587e9626ed1d88b8a0c02&language=en-US",
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

	$actorImages = json_decode($response);
	$actorImages = $actorImages->profiles;
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
	$posterSize= $config->images->poster_sizes[2];
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
	CURLOPT_URL => "https://api.themoviedb.org/3/person/".$_GET['actorId']."/movie_credits?api_key=1d956d7a1dc587e9626ed1d88b8a0c02",
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
	$movieCredits = json_decode($response);
	$movieCredits = $movieCredits->cast;
}



$imgBaseUrl = $config->images->base_url;
$profileSize= $config->images->profile_sizes[2];
$gallerySize= $config->images->profile_sizes[1];

?>

<pre>
<?php

//print_r($movieCredits);
?>

</pre>
<div class="container">
	<div class="row">
		
		
		<div class="col-6">
			<h2 id="actor<?php echo($actorDetail->id);?>"><?php echo($actorDetail->name);?></h2>
			<p>Bio: <?php echo($actorDetail->biography);?></p>
			<p>Place of Birth: <?php echo($actorDetail->place_of_birth);?></p>
			<p>Birthday: <?php echo($actorDetail->birthday);?></p>
			<?php if($actorDetail->homepage!=""){
				?>
			<p>Website: <a href="<?php echo($actorDetail->homepage);?>"><?php echo($actorDetail->homepage);?></a>
			<?php
			}?>
			<?php if($actorDetail->deathday!=""){
				?>
				<p>Deathday: <?php echo($actorDetail->deathday);?></p>
				<?php
			}?>
	
		
		</div>
		<div class="col-6 text-center">
			<img src="<?php echo $imgBaseUrl.$profileSize.$actorDetail->profile_path;?>">
		</div>
		<div class="col-12 text-center">
			<h2>Gallery</h2>
		</div>
		<?php for($i =0; $i<count($actorImages)&& $i<10;$i++){
			?>
		
		<div class="col-3">
			<img src="<?php echo $imgBaseUrl.$gallerySize.$actorImages[$i]->file_path;?>">
		</div>
  		<?php } ?>

		<div class="col-12 text-center">
				<h2>Filmography</h2>
			</div>
			<?php foreach($movieCredits as $m){
				?>
			
			<div class="col-3">
				<img src="<?php echo $imgBaseUrl.$posterSize.$m->poster_path;?>">
			</div>
			<div class="col-3">
				<p><a href="/wordpress/movie-detail/?movieId=<?php echo($m->id);?>"><?php echo($m->original_title);?></a></p>
				<p><?php echo($m->character);?></p>
				
				<p><?php echo($m->release_date);?></p>
			</div>
	  		<?php } ?>

		</div>




</div>








<?php


get_footer();
?>
