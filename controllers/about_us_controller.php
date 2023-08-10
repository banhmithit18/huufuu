<?php 

$PATH = '../ultis/';
$_SESSION['content'] = "";
$file = fopen($PATH . "about_us.txt", "r");
$content = fread($file, filesize($PATH . "about_us.txt"));
fclose($file);
$_SESSION['content']  = $content;

?>