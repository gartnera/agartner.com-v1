<?php
require 'classes.php';

$rawPostList = scandir("posts");
unset($rawPostList[0]);
unset($rawPostList[1]);
$postList = reindex_numeric($rawPostList);
//print_r($postList);
$loadedPosts = array();

foreach ($postList as $postFileName) {
	$post = new BlogPost($postFileName);
	array_push($loadedPosts, $post);
}

$rawTagList = array();
foreach($loadedPosts as $post){
	foreach($post->tags as $tag){
		array_push($rawTagList,$tag);
	}
}
$cleanTagList = array_unique($rawTagList,SORT_REGULAR); //for some reason this doesn't work

sort($cleanTagList);


$handle = fopen("TagList", "w+");

foreach ($cleanTagList as $tag) {
	fwrite($handle, $tag."\n");	
}
?>
