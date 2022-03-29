<?php

/**
* Template Name: Movie List
*
* @package WordPress
* @subpackage Twenty_Twenty_One
* @since Twenty Twenty-One 1.0
*/

get_header(); ?>

	<header class="page-header alignwide">
		<h1 class="page-title"><?php single_post_title(); ?></h1>
	</header><!-- .page-header -->
	<div class="filters container">
		<span class="mb-5">Search movie by...</span>
			<div class="inputs">
					<div class="row">
						<div class="inputBox col text-center">
							<label for="genre">Genre</label>
							<br>
							<input name="genre" id="genre" type="text"/>
						</div>
						<div class="inputBox col text-center">
							<label for="year">Year</label>
							<br>
							<input name="year" id="year" type="text"/>
						</div>
						<div class="inputBox col text-center">
							<button class="search" id="filterMovies">Find</button>
						</div>
						<div class="inputBox col text-center">
							<button class="search" id="cleanFilters">Clean</button>
						</div>
					</div>
			</div>
	</div>


<?php
$movieList=[];
$curl = curl_init();



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

for($i=1 ; $i<100; $i++){
curl_setopt_array($curl, array(
	CURLOPT_URL => "https://api.themoviedb.org/3/discover/movie?api_key=1d956d7a1dc587e9626ed1d88b8a0c02&page=".$i,
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
	$movies = json_decode($response);
	$movieList = array_merge($movieList, $movies->results); 
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


}
function compare($a, $b)
{
   return ($a->original_title> $b->original_title);
}
usort($movieList, "compare");
?>

<div class="container">
	<div class="row">
		<div class='col-12'>
			<ul>
    <?php
    
        //print_r(($movies));
        foreach($movieList as $m){
        	$genList="";
                	?>

                	<?php 
					foreach($m->genre_ids as $gID){
						foreach($genres as $g){
							if($g->id==$gID){
								$genList= $genList." ".strtolower($g->name);
							}
						}

					
					}?>
        	

        		<li class="movli" year="<?php echo(substr($m->release_date,0,4));?>" genres="<?php echo($genList)?>">
        		<a class="movieTtl" href="/wordpress/movie-detail/?movieId=<?php echo($m->id);?>">
     				<?php echo($m->original_title);?> 
        		</a>
        			( <?php echo(substr($m->release_date,0,4));?> ,
        			<?php echo($genList)?>)
        		</li>
        	
        <?php
    }
    ?>
    </div>

	</div>
</div>
<script>
$( "#filterMovies" ).click(function() {
	$(".movli").hide();
	if($("#year").val()!=""){
		var yFilter = 'li[year="'+$("#year").val().ToLowerCase()+'"]';
		$(yFilter).show();
	}
	if($("#genre").val()!=""){
		var gFilter = 'li[genres~="'+$("#genre").val()+'"]';
		$(gFilter).show();
	}
	if($("#title").val()!=""){

		var element = $( "a:contains('SearchingText')" );
		$(gFilter).show();
	}


});
$( "#cleanFilters" ).click(function() {
	$("#title").val("");
	$("#year").val("");
	$("#genre").val("");
	$(".movli").show();
});

</script>
<?php
	get_footer();
?>
