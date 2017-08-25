<?php
 $connection = mysqli_connect("localhost","fedor2ce_smm","38*mX1BGwb*l8a&4","fedor2ce_smm");
 if($connection == true){
 	$title = "connect";
 }else{
 	echo "Dont't Connected!!!!.</br></br></br>";
 	$tittle = "Error";
 	exit();
 }

	$data = mysqli_query($connection,"SELECT * FROM `news` ");


  $news_title = $_POST['news-title'];
  $news_description = $_POST['news-description'];
  $news_url = $_POST['news-url'];
    mysqli_query($connection,"INSERT INTO `fedor2ce_smm`.`news` (`title`,`description`,`img_url`) VALUES ('$news_title','$news_description','$news_url')");

?>
