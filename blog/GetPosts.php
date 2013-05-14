<?php
require 'classes.php';
$PostsPerPage = 5;
$PostIndex = 0;
$TagQuery = '';

foreach ($_GET as $variable => $value) {
	if ($variable == "PostsPerPage") {
		$PostsPerPage = $value;
	} else if ($variable == "PostIndex") {
		$PostIndex = $value;
	} else if ($variable == "tag") {
		$TagQuery = $value;
	}
}
//print $PostsPerPage;
//print $PostIndex;
$rawPostList = scandir("posts");
unset($rawPostList[0]);
unset($rawPostList[1]);
$postList = reindex_numeric($rawPostList);
//print_r($postList);
$loadedPosts = array();

$postsLoaded = 0;
for ($i = $PostIndex; $postsLoaded < $PostsPerPage && $i<count($postList); $i++) {
	$post = new BlogPost($postList[$i], $i, $TagQuery);
	if ($post -> queryMatch == TRUE) {
		array_push($loadedPosts, $post);
		$postsLoaded++;
	} else {
		unset($post);
		//not really needed because of GC
	}
}

if ($TagQuery == '') {

} else if (empty($loadedPosts)) {
	print "<h1 style='text-align:center'>No Matches for tag &quot;" . $TagQuery . "&quot;</h1>";
} else {
	print "<h1 style='text-align:center'>Results for tag &quot;" . $TagQuery . "&quot;</h1>";

}

while (!empty($loadedPosts)) {
	$post = array_pop($loadedPosts);
	print "<div class='post' id='".$post->postId."'><div class='boxclose'></div>";
	print "<div class='post-header'><div class='post-date'><p>" . $post -> date -> getMonth() . "-" . $post -> date -> getDay() . "</p>" . "<p>" . $post -> date -> getYear() . "</p></div>";
	print "<h1>" . $post -> title . "</h1></div>";
	print "<div class='postBody'>" . $post -> getRawFile();
	print "<h3 class=tags-title>Tags: </h3>";
	for ($i = 0; $i<count($post->tags);$i++)
	{
		print "<a class='tagButton'>".$post->tags[$i]."</a>";
	}
	print "</div></div>";
	/* TODO: add permalink
	 * :add tags
	 * :add searching, need to argument search terms and reload page or ajax (give option?)
	 * :add next page and load more posts buttons at bottom
	 */
	//unset($post);  //if php garbage collection is bad
};
?>