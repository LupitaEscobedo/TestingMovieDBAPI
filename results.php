<?php
	$text = $_POST["text"];
	$text = str_replace(' ','+',$text);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Página de resultados</title>
	<link rel="stylesheet" type="text/css" href="css/modal.css">
	<script src="js/jquery.js"></script>
    <script src="js/jquery2.js"></script>
</head>
<body>
	<form action="results.php" method="POST" >
		<input type="text" placeholder="Search movie..." id="text">
		<input type="submit" value="Search" id="button">
	</form> 

	<div id="videoModal" class="modal">

	  <div class="modal-content">
	    <span class="close">&times;</span>
	    <iframe src="" id="videoURL" width="1300" height="650" align="center" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen>></iframe>
	  </div>

	</div>
	

	<?php  
		$api_key = "cbc2ca6ea3dba94b419d4be845290625";
		
		$arrContextOptions = array(
			"ssl" => array(
				"verify_peer" => false,
				"verify_peer_name" => false,
			),
		);
		
		$url = 'https://api.themoviedb.org/3/search/movie?api_key='.$api_key.'&query='.$text;
		$response = json_decode(file_get_contents($url, false, stream_context_create($arrContextOptions)));

		foreach ($response->results as $movie) {
			$image = 'https://image.tmdb.org/t/p/w200'.$movie->poster_path;
			$titulo = $movie->title;
			$movieID = $movie->id;
			$overview = $movie->overview;
	?>
	<div class="rows" style="text-align: center; width: 70%; padding-left: 15%;">
		<h4> <?= $titulo ?> </h4>
		<img src="<?=$image?>" onclick="abrirVideo(<?=$movieID?>);">
		<p> <?= $overview ?> </p>
		<br>
	</div>
	
<?php  
	} ?>

	<script>
		function abrirVideo(movieID){
			var url = "https://api.themoviedb.org/3/movie/" + movieID + "/videos?api_key=cbc2ca6ea3dba94b419d4be845290625";
		  	$.ajax({
	            type: 'GET',
	            url: url,
	            async: false,
	            jsonpCallback: 'testing',
	            contentType: 'application/json',
	            dataType: 'jsonp',
	            success: function(json) {
	                console.dir(json);
	                if(json['results'].length < 1){
	                	alert("No hay videos disponibles");
	                }
	                else{
	                	var videoLink = "https://www.youtube.com/embed/" + json['results'][0]['key'];
		                var modal = document.getElementById('videoModal');
		                var video = document.getElementById('videoURL');
		                video.src = videoLink;
		                var span = document.getElementsByClassName("close")[0];
		                modal.style.display = "block";
		                span.onclick = function() {
					    	$('iframe').attr('src', $('iframe').attr('src'));
					    	modal.style.display = "none";
						}
						window.onclick = function(event) {
					    	if (event.target == modal) {
					        	modal.style.display = "none";
					    	}
						} 
					}
	            },
	            error: function(e) {
	                console.log(e.message);
	            }
        	});
		}

	</script>
</body>
</html>