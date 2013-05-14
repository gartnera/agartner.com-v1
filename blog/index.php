<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">

		<title>Blog</title>
		<link href="http://fonts.googleapis.com/css?family=Goudy+Bookletter+1911" rel="stylesheet" type="text/css">
		<link href="http://fonts.googleapis.com/css?family=Raleway:100" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="http://agartner.com/css/main_styles.css">
		<link rel="stylesheet" href="http://agartner.com/css/blog_styles.css">
		<link rel="stylesheet" href="http://agartner.com/css/prism.css">

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script type="text/javascript" src="http://agartner.com/javascript/blog_javascript.js"></script>
		<script type="text/javascript" src="http://agartner.com/javascript/menu_javascript.js"></script>
		<script type="text/javascript" src="http://agartner.com/javascript/prism.js"></script>

	</head>
	<body>

		<div id="wrapper-wrapper" class="col_5_5">
			<div id="wrapper">
				<ul class="menu">
					<li class="item1">
						<a href="#" id ="profile_menu">Profile</a>

					</li>
					<li class="item2">
						<a href="#" id="blog_menu">Blog</a>
						<ul>
							<li class="subitem1">
								<a href="#">Set Posts Per Page</a>
							</li>
							<li class="subitem2">
								<a href="#">Search by Tag</a>
							</li>
							<li class="subitem3">
								<a href="#">Goto Index</a>
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
					<a href="https://www.facebook.com/gartner3"><img src="http://agartner.com/images/facebook.png"/></a><a href="https://plus.google.com/112069127009481171643/about"><img src="http://agartner.com/images/google.png" /></a><img src="http://agartner.com/images/skype.png" /><img src="http://agartner.com/images/steam.png" /><img src="http://agartner.com/images/youtube.png" /><img src="http://agartner.com/images/linkedin.png" />

				</div>

			</div>
		</div>
		<div class="col_1-4_5" id="post_container">
			<?php
			require 'GetPosts.php';
			?>
			<div class= "col_1_1"id="blog_nav" style="text-align: center">
				<a class="button large black" id="load_posts_ajax" ><span>Load more posts through ajax</span></a>
				<a class="button large black" id="load_posts_newpage" ><span>Load more posts on new page</span></a>

			</div>
		</div>

	</body>
	<script type='text/javascript'><?php
if ($PostsPerPage == 1) {
	print "	$(document).ready(function(){
$('.post:nth-of-type(1)').children('.postBody').css('display','block');
});";
};
?></script>
</html>