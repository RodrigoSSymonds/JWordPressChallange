<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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

https://api.themoviedb.org/3/configuration?api_key=<<api_key>>

curl_setopt_array($curl, array(
	CURLOPT_URL => "https://api.themoviedb.org/3/movie/upcoming?api_key=1d956d7a1dc587e9626ed1d88b8a0c02&language=en-US&&sort_by=primary_release_date.asc",
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

//print_r( array_values( $genres ));


?>
<div class="container">
	<div class="row">
		<div class="col-12 mb-5">
			<h2 class="text-center">Top 10 Upcoming Movies</h2>
		</div>
    <?php
    	$imgBaseUrl = $config->images->base_url;
    	$posterSize= $config->images->poster_sizes[3];
    	//print_r($config);
    	$movies = $movieList->results;

    	$mOR= substr($movies[0]->release_date,0,7);
        //print_r(($movies));
        for($i = 0; $i < 10; $i++){
        	if($i==0||$mOR= substr($movies[0]->release_date,0,7)!=substr($movies[$i]->release_date,0,7)){
        		echo("<div class='col-12'>".substr($movies[$i]->release_date,0,7)."</div>");
        	?>
        	<div class='col-12'>
        	<div class='row'>

        	<div class='col-6'>
        	
        	
        	<?php echo("<img src='".$imgBaseUrl.$posterSize.$movies[$i]->poster_path."'>");?>
        	</div>

        	<div class='col-6'>
			<div class="movieInfoBox">

			<p class='movieTitle'>
				<a href="/wordpress/movie-detail/?movieId=<?php echo($movies[$i]->id);?>">
			<?php echo($movies[$i]->original_title);?>
				</a>
			</p>

			<p class='movieRelDate'>
			<?php echo($movies[$i]->release_date);?>
			</p>

			<p class='movieGenres'>


			<?php 
			foreach($movies[$i]->genre_ids as $gID){
				foreach($genres as $g){
					//echo($g->id);
					//echo($gID);
					if($g->id==$gID){
						echo($g->name);
						echo(", ");

					}
				}

			
			}?>

			</p>
			</div>
        	</div>
        	</div>
        	<?php
        }}    ?>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-12 mb-5 mt-5">
			<h2 class="text-center">Top 10 Most Popular actors/actresses</h2>
		</div>
    <?php
    	$imgBaseUrl = $config->images->base_url;
    	$profileSize= $config->images->profile_sizes[1];
    	$actors = $popularPeople->results;
        //print_r(($movies));
        for($i = 0; $i < 10; $i++){
        	?>
        	

        	<div class='col-6 text-center mb-3'>
        		
        	
        	<img src="<?php echo $imgBaseUrl.$profileSize.$actors[$i]->profile_path;?>">
        	<br>
        	<a href="/wordpress/actor-detail/?actorId=<?php echo($actors[$i]->id);?>">
        			<?php echo($actors[$i]->name);?> 
        		</a>
        	<br>
        	</div>

        <?php
    }
    ?>
	</div>
</div>




<?php


get_footer();
?>