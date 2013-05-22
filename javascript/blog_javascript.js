function setupPost(post) {
	$(post).click(function () {
		if (!$(this).children(".postBody").is(":visible")) {
			$(this).css('cursor', 'default');
			$(this).children(".postBody").slideToggle('slow', function () {
				$(this).parent().children(".boxclose").fadeIn();
			});
		} else {
		}

	});
	$(post).children(".boxclose").click(function () {
		$(this).fadeOut();
		$(this).parent().children(".postBody").slideToggle('slow');
		$(this).parent().css('cursor', 'pointer');
	});
}

function updateSettings() {
	var selection = $('input[name=theme]:checked').val();
	var body = $('body');
	body.removeClass("background-weave background-carbon");
	var themeVal = $('input[name=theme]:checked').val()
	body.addClass(themeVal);
	localStorage.setItem("theme", themeVal);
}

function fitPostHeader() {
	$(".post-header>h1").each(function () {
		var availableWidth = $(this).parent().width() - $(this).parent().children(".post-date").width() - 30;
		while ($(this).width() > availableWidth) {
			var fontSize = $(this).css("font-size").replace('px', '');
			--fontSize;
			fontSize += "px";
			$(this).css("font-size", fontSize);
		}
		while ($(this).width() < availableWidth) {
			var fontSize = $(this).css("font-size").replace('px', '');
			if (fontSize < 50) {
				++fontSize;
				fontSize += "px";
				$(this).css("font-size", fontSize);
			}
			else {
				break;
			}
		}
	});
}

$(document).ready(function () {
	fitPostHeader();
	$(window).resize(function () {
		fitPostHeader();
	});
	var currentPostsString = "";
	if (urlParams.hasOwnProperty("PostsPerPage")) {
		currentPostsString = "&PostsPerPage=" + urlParams["PostsPerPage"];
	}
	var currentTagString = "";
	if (urlParams.hasOwnProperty("tag")) {
		currentTagString = "&tag=" + urlParams["tag"];
	}
	setupPost($(".post"));
	$(".tagButton").click(function () {
		window.location = "http://blog.agartner.com/?tag=" + encodeURIComponent($(this).text()) + currentPostsString;
	})
	$("#tagsearch").click(function () {
		$('.overlay').fadeIn(1000);
		$("#tagPopup").animate({'top': '50%'}, 1000, function () {
			$(this).children(".boxclose").fadeIn();
		});
	})
	$("#tagPopup").children(".boxclose").click(function () {
		$('.overlay').fadeOut(1000);

		$(this).fadeOut(function () {
			$(this).parent().animate({'top': '-500px'}, 1000);

		});
	});
	$("#settingsButton").click(function () {
		$('.overlay').fadeIn(1000);
		$("#settingsPopup").animate({'top': '50%'}, 1000, function () {
			$(this).children(".boxclose").fadeIn();
		});
	})
	$("#settingsPopup").children(".boxclose").click(function () {
		$('.overlay').fadeOut(1000);

		$(this).fadeOut(function () {
			$(this).parent().animate({'top': '-500px'}, 1000);

		});
	});
	$("#load_posts_ajax").click(function () {
		var postsPerPage = 5;
		if ("PostsPerPage" in urlParams) {
			postsPerPage = urlParams["PostsPerPage"];
		}
		var lastPostIndex = $("#post_container>.post:last").attr("id");
		var firstPostIndex = lastPostIndex - postsPerPage;

		--lastPostIndex;

		if (firstPostIndex < 0) {
			postsPerPage = postsPerPage - (0 - firstPostIndex);
			if (postsPerPage <= 0 | totalPosts == visiblePosts) {
				alert("No More Posts!");
				return;
			}
			firstPostIndex = 0;
		}
		function showPost() {
			$("#" + id).fadeIn(function () {
				$("#postCounter").text("Showing " + ++visiblePosts + " of " + totalPosts + " posts.");
				setupPost($(this));
				id--;
				if (id >= firstPostIndex) {
					showPost();
				}
			})
		}

		var id = lastPostIndex;
		console.log(lastPostIndex);
		var ajaxresponse = jQuery.post("http://blog.agartner.com/GetPosts.php?ajax&PostsPerPage=" + postsPerPage + "&PostIndex=" + lastPostIndex + currentTagString, function () {
			if (ajaxresponse.status == "200") {
				$("#post_container").append(ajaxresponse.responseText);
				showPost();
			}
			else {
				console.log("Request Failed. Recieved: " + ajaxresponse.status + " error.");
				return;
			}
		});

	});
});