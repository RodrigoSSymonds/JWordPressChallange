<?php

/**
* Template Name: Movie Detail
*
* @package WordPress
* @subpackage Twenty_Twenty_One
* @since Twenty Twenty-One 1.0
*/

get_header(); ?>


	<header class="page-header alignwide">
		<h1 class="page-title"><?php the_title(); ?></h1>
	</header><!-- .page-header -->



<?php
if($_GET['movieId']){
	$curl = curl_init();


curl_setopt_array($curl, array(
	CURLOPT_URL => "https://api.themoviedb.org/3/movie/".$_GET['movieId']."?api_key=1d956d7a1dc587e9626ed1d88b8a0c02&language=en-US",
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

	$movieDetail = json_decode($response);
}
curl_setopt_array($curl, array(
	CURLOPT_URL => "https://api.themoviedb.org/3/movie/".$_GET['movieId']."/videos?api_key=1d956d7a1dc587e9626ed1d88b8a0c02&language=en-US",
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

	$movieVideos = json_decode($response);
	$movieVideos = $movieVideos->results;
}

curl_setopt_array($curl, array(
	CURLOPT_URL => "https://api.themoviedb.org/3/review/".$_GET['movieId']."?api_key=1d956d7a1dc587e9626ed1d88b8a0c02&language=en-US",
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

	$movieReviews = json_decode($response);
	//print_r($movieReviews);
}

curl_setopt_array($curl, array(
	CURLOPT_URL => "https://api.themoviedb.org/3/movie/".$_GET['movieId']."/similar?api_key=1d956d7a1dc587e9626ed1d88b8a0c02&language=en-US&page=1S",
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

	$similarMovies = json_decode($response);
	$similarMovies = $similarMovies->results;
	//print_r($similarMovies);
}


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
	CURLOPT_URL => "https://api.themoviedb.org/3/movie/".$_GET['movieId']."/credits?api_key=1d956d7a1dc587e9626ed1d88b8a0c02",
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
	$credits = json_decode($response);
	$cast=$credits->cast;

	
}



$imgBaseUrl = $config->images->base_url;
$posterSize= $config->images->poster_sizes[3];


?>


<pre>
<?php
/*print_r($movieVideos);
print_r($movieReviews);
print_r($cast);*/
?>
</pre>




<div class="container">
	<div class="row">
		<div class="col-6">
			<img src="<?php echo($imgBaseUrl.$posterSize.$movieDetail->poster_path);?>">

		</div>
		<div class="col-6">
			<h2><?php echo($movieDetail->original_title);?></h2>
			<p>Overview: <?php echo($movieDetail->overview);?></p>
			<p> Genres: 
			<?php 
				for($i=0; $i<count($movieDetail->genres); $i++){
					echo($movieDetail->genres[$i]->name);
					if($i<count($movieDetail->genres)-1){
						echo(", ");
					}else{
						echo(".");
					}
				}

			
			?>
			</p>
			<p>Produced by: 
				<?php 
				for($i=0; $i<count($movieDetail->production_companies); $i++){
					echo($movieDetail->production_companies[$i]->name);
					if($i<count($movieDetail->production_companies)-1){
						echo(", ");
					}else{
						echo(".");
					}
				}

			
			?>

			</p>
			<p>Original Language: <?php echo($movieDetail->original_language);?></p>
			<p>Release Date: <?php echo($movieDetail->release_date);?></p>
			<p>Popularity: <?php echo($movieDetail->popularity);?></p>
		</div>

	<div class="w-100 mt-3"></div>
	<div class="col-12">
		<h3 class="text-center mb-5">Trailers</h3>
	</div>
	
		<?php foreach($movieVideos as $v){?>
		<div class="col-6 text-center">
			<iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo($v->key);?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
			</iframe>

			
		</div>
	<?php }?>
	

	<div class="w-100 mt-3"></div>
	<div class="col-6">
		<h3 class="text-center mb-5">Cast</h3>

		<ul>
			<?php foreach($cast as $c){?>
			<li>
				<a href="/wordpress/actor-detail/?actorId=<?php echo($c->id);?>"><?php echo($c->name);?> as <?php echo($c->character);?></a>
			</li>
			

			
	<?php }?>
		
		</ul>	
	</div>
	<div class="col-6">
		<h3 class="text-center mb-5">Similar Movies</h3>
	
		<ul>
		<?php foreach($similarMovies as $s){?>
			<li>
				<a href="/wordpress/movie-detail/?movieId=<?php echo($s->id);?>"><?php echo($s->original_title);?></a>
			</li>
			

			
	<?php }?>
		</ul>	
	</div>

	</div>







<?php
get_footer();
?>