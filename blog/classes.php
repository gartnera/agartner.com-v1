<?php
class Date
{
	private $month;
	private $day;
	private $year;
	private $date;

	function __construct($arg_date)
	{
		$this->date = $arg_date;
		$dateArray = explode("-", $arg_date);
		$this->month = $dateArray[0];
		$this->day = $dateArray[1];
		$this->year = $dateArray[2];
	}

	public function getDate()
	{
		return $this->date;
	}

	public function getMonth()
	{
		return $this->month;
	}

	public function getDay()
	{
		return $this->day;
	}

	public function getYear()
	{
		return $this->year;
	}
}


class BlogPost
{
	public $date;
	public $title = "Default title";
	public $author = "Default Author";
	public $tags = array();
	public $queryMatch = FALSE;
	private $rawFile = "<p>Default file</p>";
	public $postId;
	public $titleMatch = FALSE;

	/**
	 * @param string $fileName Name of the post located in the ./post directory
	 * @param int    $i The number of the post
	 * @param string $query String to attempt to match with this post's tags
	 * @param string $title    The title retrieved from the url (eg blog.agartner.com/title/Test_Blog_Post -> Test_Blog_Post)
	 * @param bool   $loadBody Wether or not to load the body of the post
	 */
	function __construct($fileName, $i = -1, $query = "", $title, $loadBody)
	{
		$this->postId = $i;
		$infoArray = preg_split('/[~.]/', $fileName);
		//print_r($infoArray);
		$this->date = new Date($infoArray[0]);
		$this->title = $infoArray[1];

		if ($title == $this->title) {
			$this->titleMatch = TRUE;
		}
		$this->author = $infoArray[2];
		$this->tags = (explode('|', $infoArray[3]));

		if ($query === '') {
			$this->queryMatch = TRUE;
		} else {

			foreach ($this->tags as $variable => $value) {
				if ($value === $query) {
					$this->queryMatch = TRUE;
					break;
				}
			}
		}
		if ($this->queryMatch && $loadBody) {
			chdir("posts"); //messy...
			$this->rawFile = file_get_contents($fileName);
			chdir("..");
		}
	}

	public function getRawFile()
	{
		if ($this->queryMatch) {
			return $this->rawFile;
		} else {
			return "Post not match for query";
		}
	}
}

/**
 * @param $arr The array to be compacted
 * @return mixed The compacted array (where every entry starting at 0 is filled until the end)
 */
function reindex_numeric($arr)
{
	$i = 0;
	foreach ($arr as $key => $val) {
		if (ctype_digit((string)$key)) {
			$new_arr[$i++] = $val;
		} else {
			$new_arr[$key] = $val;
		}
	}
	return $new_arr;
}

/**
 * @param BlogPost $post Post object to operate on
 * @param bool     $contentonly Remove .post div surrounding the returned string?
 * @param bool     $ajax Makes it so posts are hidden until they are explicitly shown with javascript
 * @return string The post as a string
 */
function format_post($post, $contentonly, $ajax)
{
	$postStr = "";
	if (!$contentonly) {
		$postStr = "<div class='post' id='" . $post->postId . "'";
		if ($ajax) {
			$postStr .= " style='display:none !important;'";
		};
		$postStr .= ">";
	}
	$postStr .= "<div class='boxclose'></div>";
	$postStr .= "<div class='post-header'><div class='post-date'><p>" . $post->date->getMonth() . "-" . $post->date->getDay() . "</p>" . "<p>" . $post->date->getYear() . "</p></div>";
	$postStr .= "<h1>" . $post->title . "</h1></div>";
	$postStr .= "<div class='postBody'>" . $post->getRawFile();
	$postStr .= "<h3 class=tags-title>Tags: </h3>";
//	for ($i = 0; $i < count($post->tags); $i++) {
//		print "<a class='tagButton'>" . $post->tags[$i] . "</a>";
//	}
	foreach ($post->tags as $tag) {
		$postStr .= "<a class='tagButton'>" . $tag . "</a>";
	}
	$postStr .= "</div>";
	if (!$contentonly) {
		$postStr .= "</div>";
	}
	/* TODO: add permalink
	 * :add searching, need to argument search terms and reload page or ajax (give option?)
	 * :add next page and load more posts buttons at bottom AJAX DONE (STILL NEED HARD RELOAD STYLE)
	 */
	//unset($post);  //if php garbage collection is bad
	return $postStr;
}

function get_all_tags()
{
	$handle = fopen("TagList", "r");
	$data = fread($handle, filesize("TagList"));
	$array = explode("\n", $data);
	array_pop($array);
	return $array;
}

?>