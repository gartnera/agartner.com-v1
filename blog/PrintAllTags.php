<?php
include_once 'classes.php';

$tags = get_all_tags();
foreach ($tags as $tag) {
	print "<a class='tagButton'>" . $tag . "</a>";
}
?>