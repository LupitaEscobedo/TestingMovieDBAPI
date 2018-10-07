
function generaQuery(){
  $(document).ready(function() {
    var url = 'https://api.themoviedb.org/3/search/movie?api_key=cbc2ca6ea3dba94b419d4be845290625&query=',
        movieName;

    $('button').click(function() {
        var input = $('text').val(),
            movieName = encodeURI(input);
        $.ajax({
            type: 'GET',
            url: url + movieName,
            async: false,
            jsonpCallback: 'testing',
            contentType: 'application/json',
            dataType: 'jsonp',
            success: function(json) {
                console.dir(json);
            },
            error: function(e) {
                console.log(e.message);
            }
        });
    });
});​
}


$.ajax({
	            type: 'GET',
	            url: url + movieName,
	            async: false,
	            jsonpCallback: 'testing',
	            contentType: 'application/json',
	            dataType: 'jsonp',
	            success: function(json) {
	                console.dir(json);
	            },
	            error: function(e) {
	                console.log(e.message);
	            }
	        });