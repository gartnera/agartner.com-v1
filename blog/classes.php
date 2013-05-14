<?php
class Date {
	private $month;
	private $day;
	private $year;
	private $date;

	function __construct($arg_date) {
		$this -> date = $arg_date;
		$dateArray = explode("-", $arg_date);
		$this -> month = $dateArray[0];
		$this -> day = $dateArray[1];
		$this -> year = $dateArray[2];
	}

	public function getDate() {
		return $this -> date;
	}

	public function getMonth() {
		return $this -> month;
	}

	public function getDay() {
		return $this -> day;
	}

	public function getYear() {
		return $this -> year;
	}

}

class BlogPost {
	public $date;
	public $title = "Default title";
	public $author = "Default Author";
	public $tags = array();
	public $queryMatch = FALSE;
	private $rawFile = "<p>Default file</p>";
	public $postId;
	

	function __construct($fileName, $i = -1,$query = "") {
		$this -> postId =$i;
		$infoArray = preg_split('/[~.]/', $fileName);
		//print_r($infoArray);
		$this -> date = new Date($infoArray[0]);
		$this -> title = $infoArray[1];
		$this -> author = $infoArray[2];
		$this -> tags = (explode('|', $infoArray[3]));

		if ($query === '') {
			$this -> queryMatch = TRUE;

		} else {
			
			foreach ($this ->tags as $variable => $value) {
				if ($value === $query) {
					$this -> queryMatch = TRUE;
					break;
				}
			}
			
		}
		if ($this -> queryMatch) {
			chdir("posts"); //messy...
			$this -> rawFile = file_get_contents($fileName);
			chdir("..");
		}
	}

	public function getRawFile() {
		if ($this -> queryMatch) {
			return $this -> rawFile;
		} else {
			return "Post not match for query";
		}
	}

}

function reindex_numeric($arr) {
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
?>