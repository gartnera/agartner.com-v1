$(document).ready(function() {
	$(".post").click(function() {
		if (!$(this).children(".postBody").is(":visible")) {
			$(this).children(".postBody").slideToggle('slow', function() {
				$(this).parent().children(".boxclose").fadeIn();
			});
		} else {
			console.log("no...");
		}

	});
	$(".boxclose").click(function() {
		$(this).fadeOut();
		$(this).parent().children(".postBody").slideToggle('slow');
		console.log("close clicked");
	});
	$(".tagButton").click(function(){
		window.location = "http://blog.agartner.com/?Query="+encodeURIComponent($(this).text());
	})
});