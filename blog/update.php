<?php
require_once 'classes.php';

$rawPostList = scandir("posts");
unset($rawPostList[0]);
unset($rawPostList[1]);
$postList = reindex_numeric($rawPostList);
//print_r($postList);
$loadedPosts = array();

foreach ($postList as $postFileName) {
	$post = new BlogPost($postFileName, NULL, "", "", FALSE);
	array_push($loadedPosts, $post);
}

$rawTagList = array();
$postTitleList = array();
foreach ($loadedPosts as $post) {
	array_push($postTitleList, $post->title);
	foreach ($post->tags as $tag) {
		array_push($rawTagList, $tag);
	}
}
$cleanTagList = array_unique($rawTagList, SORT_REGULAR); //for some reason this doesn't work

sort($cleanTagList);

$taglistHandle = fopen("TagList", "w+");
foreach ($cleanTagList as $tag) {
	fwrite($taglistHandle, $tag . "\n");
}
fclose($taglistHandle);

$urlListHandle = fopen("postlist.html", "w+");
fwrite($urlListHandle, "<html><head><META NAME='ROBOTS' CONTENT='NOINDEX, FOLLOW'></head><body>\n");
foreach ($postTitleList as $title) {
	$modded_title = str_replace(" ", "_", $title);
	$url = "<a href='http://blog.agartner.com/title/" . $modded_title . "'>" . $title . "</a>\n";
	fwrite($urlListHandle, $url);
}
fwrite($urlListHandle, "</body></html>\n");
fclose($urlListHandle);
?>
