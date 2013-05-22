<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">

	<link href="http://fonts.googleapis.com/css?family=Goudy+Bookletter+1911" rel="stylesheet"
		  type="text/css">
	<link href="http://fonts.googleapis.com/css?family=Raleway:100" rel="stylesheet"
		  type="text/css">
	<link rel="stylesheet" href="http://agartner.com/css/main_styles.css">
	<link rel="stylesheet" href="http://agartner.com/css/blog_styles.css">
	<link rel="stylesheet" href="http://agartner.com/css/prism.css">

	<!--Jquery-->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

	<!--Depends on Jquery-->
	<script type="text/javascript" src="http://agartner.com/javascript/jquery.json-2.4.min.js"></script>
	<script type="text/javascript" src="http://agartner.com/javascript/prism.js"></script>
	<script type="text/javascript" src="http://agartner.com/javascript/jquery.fittext.js"></script>
	<script type="text/javascript">
		var urlParams = <?php echo json_encode($_GET);?>;
	</script>
	<script type="text/javascript" src="http://agartner.com/javascript/blog_javascript.js"></script>
	<script type="text/javascript" src="http://agartner.com/javascript/menu_javascript.js"></script>

	<?php require 'GetPosts.php'; ?>
	<title><?php if ($title) echo $title; else echo "Blog"; ?></title>
</head>
<body>
<?php
print $highlightedPost;
?>
<div class="overlay"></div>
<div class="popup" id="tagPopup">
	<div class="boxclose"></div>
	<div style="margin: 15px"><?php require 'PrintAllTags.php'; ?></div>
</div>
<div class="popup" id="settingsPopup">
	<div class="boxclose"></div>
	<div style="margin: 15px">
		<form name="settingsform" action="javascript:void(0);" onsubmit="updateSettings()">
			<h3>Theme</h3>
			<input type="radio" name="theme" value="background-weave">Weave<br>
			<input type="radio" name="theme" value="background-carbon">Carbon<br>
			<input type="radio" name="theme" value="" checked>None<br>
			<br>
			<input type="submit" value="Save"></form>
	</div>
</div>
<div id="content" style="width:800px">
	<div id="post_container">
		<?php
		print $allCurrentPosts;
		?>
	</div>
	<div class="col_1_1" id="blog_nav" style="text-align: center">
		<a class="button large black" id="load_posts_ajax"><span>Load more posts through ajax</span></a>

		<p id="postCounter" style="display: inline-block"></p>
		<a class="button large black" id="load_posts_newpage"><span>Load more posts on new page</span></a>
	</div>
</div>
<div id="wrapper-wrapper" class="col_5_5">
	<div id="wrapper">
		<ul class="menu">
			<li class="item1">
				<a href="#" id="profile_menu">Profile</a>
			</li>
			<li class="item2">
				<a href="#" id="blog_menu">Blog</a>
				<ul>
					<li>
						<a>Set Posts Per Page</a>
					</li>
					<li>
						<a id="tagsearch">Search by Tag</a>
					</li>
					<li>
						<a>Goto Index</a>
					</li>
					<li>
						<a id="settingsButton">Settings</a>
					</li>
				</ul>
			</li>
			<li class="item3">
				<a href="#" id="projects_menu">Projects</a>

			</li>
			<li class="item4">
				<a href="#" id="files_menu">Files</a>

			</li>
			<li class="item5">
				<a href="#">Blank</a>

			</li>
		</ul>
		<div id="socialmedia">
			<a href="https://www.facebook.com/gartner3">
				<img src="http://agartner.com/images/facebook.png"/>
			</a>
			<a href="https://plus.google.com/112069127009481171643/about">
				<img src="http://agartner.com/images/google.png"/>
			</a>
			<img src="http://agartner.com/images/skype.png"/>
			<img src="http://agartner.com/images/steam.png"/>
			<img src="http://agartner.com/images/youtube.png"/>
			<img src="http://agartner.com/images/linkedin.png"/>

		</div>

	</div>
</div>

</body>
<script type='text/javascript'>
	//$(".post h1").fitText({maxFontSize: '50px' }); //dosen't work
	var totalPosts = <?php echo $tagMatches;?>;
	var visiblePosts = $("#post_container .post").length;
	$("#postCounter").text("Showing " + visiblePosts + " of " + totalPosts + " posts.");

	$("input[value=" + localStorage.getItem("theme") + "]").prop("checked", true)
	$("body").addClass(localStorage.getItem("theme"));

	<?php
	print "$(document).ready(function(){";
	if ($PostsPerPage == 1) {
		print "	$('.post:nth-of-type(1)').children('.postBody').css('display','block');
				$('.post:nth-of-type(1)').children('.boxClose').show();
				";
	};
	if ($highlightedPost){
		print "
				$('.overlay').show();
				$('body').css('overflow', 'hidden');
				$('#highlightedPost .boxclose').show();
				$('#highlightedPost .boxclose').click(function(){
					$(this).fadeOut();
					$('#highlightedPost').fadeOut();
					$('.overlay').fadeOut();
					$('#post_container').css('overflow', 'auto');
					window.history.pushState('','', 'http://blog.agartner.com');
					document.title = 'Blog';
					activate(menu_a, menu_ul, blog_menu);
				});";
	}
	print "});";
	?>
</script>
</html>