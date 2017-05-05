<?php
$filenames = array_diff(scandir(__DIR__), array('..', '.'));

foreach ($filenames as $filename) {
	if($filename != "autoload.php"){
		include $filename;
	}
}
