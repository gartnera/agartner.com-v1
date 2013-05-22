<?php
require_once 'classes.php';
$PostsPerPage = 5;
$PostIndex = -1;
$TagQuery = '';
$ajax = FALSE;
$title = "";

foreach ($_GET as $variable => $value) {
	$cleanVal = htmlspecialchars($value);
	$cleanVar = htmlspecialchars($variable);
	if ($cleanVar == "PostsPerPage") {
		$PostsPerPage = $cleanVal;
	} else if ($cleanVar == "PostIndex") {
		$PostIndex = $cleanVal;
	} else if ($cleanVar == "tag") {
		$TagQuery = $cleanVal;
	} else if ($cleanVar == "ajax") {
		$ajax = TRUE;
	} else if ($cleanVar == "contentonly") {
		$contentonly = TRUE;
	} else if ($cleanVar == "title") {
		$title = str_replace("_", " ", $cleanVal);
	}
}

$rawPostList = scandir("posts");
unset($rawPostList[0]);
unset($rawPostList[1]);
$postList = reindex_numeric($rawPostList);

if ($PostIndex == -1) {
	$PostIndex = count($postList) - 1;
}

$totalPosts = count($postList);

$loadedPosts = array();
/*
 * TODO:Add the following code if title variable matches a post title. can't be added in this file, as the scope would be wrong.
 * think about setting it as a variable then echo'ing it right before </body>. Move styles to blog_styles.css and add javascript
 * to blog_javascript. Post inside #highlightedPost is going to need a lot of formatting work (use jqueryScrollPane for overflow), need to be careful to use
 * #highlighedPost > ... selector so we don't select the post if it's on the main page
 */
//<div id="highlighedPost" style="
//    border: solid;
//    position: fixed;
//    left: 20px;
//    right: 20px;
//    top: 20px;
//    bottom: 20px;
//    background: white;
//    z-index: 101;
//    border-radius: 10px;
//">
//
//</div>
$postsLoaded = 0;
for ($i = $PostIndex; $i >= 0 /*&& $postsLoaded < $PostsPerPage*/; $i--) { //removed so we can load all posts and check their title and tags
	$post = NULL;
	if ($postsLoaded < $PostsPerPage) {
		$post = new BlogPost($postList[$i], $i, $TagQuery, $title, TRUE);
	} else {
		$post = new BlogPost($postList[$i], $i, $TagQuery, $title, FALSE);
	}
	if ($post->queryMatch == TRUE) {
		$postsLoaded++;
	}
	array_push($loadedPosts, $post);
}

//$postsLoaded = 0;
//for ($i = $PostIndex; $postsLoaded < $PostsPerPage && $i<count($postList); $i++) {
//	$post = new BlogPost($postList[$i], $i, $TagQuery);
//	if ($post -> queryMatch == TRUE) {
//		array_push($loadedPosts, $post);
//		$postsLoaded++;
//	} else {
//		unset($post);
//		//not really needed because of GC
//	}
//}

$allCurrentPosts = "";

//TODO: Commented out until there's a good way to show when themed
/*if (!$ajax) {
	if ($TagQuery == '') {
	} else if (empty($loadedPosts)) {
		$allCurrentPosts .="<h1 style='text-align:center'>No Matches for tag &quot;" . $TagQuery . "&quot;</h1>";
	} else {
		$allCurrentPosts .="<h1 style='text-align:center'>Results for tag &quot;" . $TagQuery . "&quot;</h1>";

	}
}*/

$tagMatches = 0;
foreach ($loadedPosts as $post) {
	if ($post->queryMatch) {
		$tagMatches++;
	}
}

$postsPrinted = 0;
$highlightedPost = "";

foreach ($loadedPosts as $post) {
	if ($title != "" && $post->titleMatch) {
		$highlightedPost = "<div id='highlightedPost'>" . format_post($post, TRUE, $ajax) . "</div>";
	}
	if ($post->queryMatch == TRUE && $postsPrinted < $PostsPerPage) {
		$postsPrinted++;
		if ($ajax) {
			print format_post($post, FALSE, $ajax) . "\n";
		} else {
			$allCurrentPosts .= format_post($post, FALSE, $ajax) . "\n";
		}
	}
}
?>