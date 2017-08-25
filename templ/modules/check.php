<?php

$connection = mysqli_connect("localhost","fedor2ce_smm","38*mX1BGwb*l8a&4","fedor2ce_smm");
$data = mysqli_query($connection,"SELECT * FROM `admins` ");
$art = mysqli_fetch_assoc($data);
$login = $_POST['login'];
$password = $_POST['password'];
$redirect = "https://smm-opt.ru/modules/addnews.php";
  if($login == $art['name']){
    if($password == $art['password']){
      header('Location: ' . $redirect . $return_url);
    }else{
      echo ("password incorrect");
    }
  }else{
    echo ("Login incorrect");
  }



 ?>
