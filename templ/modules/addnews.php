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
  $news_date = $_POST['news_date'];
  if($news_title != '' || $news_description != '' || $news_url != ''){
    mysqli_query($connection,"INSERT INTO `fedor2ce_smm`.`news` (`title`,`description`,`img_url`,`date`) VALUES ('$news_title','$news_description','$news_url','$news_date')");
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" media="all" href="//fonts.googleapis.com/css?family=Raleway:400,300,600" />
  <link rel="stylesheet" media="all" href="../assets/landing-4e73cd2d2d78093ca8e316521eecccb5b5d9788ffb45621fbe43aaaa2d1674b0.css" />
  <title><?php echo $title ?></title>
  <style media="screen">
    html{
      background: #0ca3d2;
    }
    form{
      margin-top: 100px;
    }
    input{
      border: 5px solid #efefef;
      border-radius: 3px;
      width: 370px;
      height: 40px;
      padding: 5px 20px;
      color:#333;
      box-sizing: border-box;
    }
    .text{
      height: 120px!important;
      overflow-y: scroll!important;
      width: 370px!important;
    }
  </style>
</head>
<body>
  <div class="main-wrapper">
    <div class="addnews" style="width: 350px;
      display: flex;
      margin: auto;">
      <form class="simple_form form_sign-up" method="post" action="">
        <div class="pure-control-group email optional user_email">
          <label class="email optional" for="user_email">Заголовок</label>
          <input class=" optional form__input" name="news-title" required  />
        </div>
        <div class="pure-control-group email optional user_email">
          <label class="email optional" for="user_email" >Текст статьи</label>
          <textarea class="  optional form__input text" name="news-description" required  /></textarea>
        </div>
        <div class="pure-control-group email optional user_email">
          <label class="email optional" for="user_email">Ссылка на картинку</label>
          <input class="  optional form__input" name="news-url" required  />
        </div>
        <div class="pure-control-group email optional user_email">
          <label class="email optional" for="user_email">Дата</label>
          <input class="optional form__input" name="news_date" required  />
        </div>
        <div class="form__actions">
          <input type="submit" name="commit" value="добавить" class="button-primary sendBtn" />
        </div>
      </form>
    </div>
    <div class="allnews">

      <div class="allnews__cont-first">
        <p class="news-title-first">
          <b>
            Название статьи
          </b>
        </p>
        <p class="news-descriptions-first">
          <b>
            Текст статьи
          </b>
        </p>
        <p class="news-title-first">
          <b>Картинка</b>
        </p>
      </div>

      <?php

        while(($art = mysqli_fetch_assoc($data))){
            echo('<div class="allnews__cont">
                    <p class="news-title">' . $art['title'] . '</p>
                    <p class="news-descriptions">' . $art['description'] .'</p>
                    <img src="' . $art['img_url'] .'" alt="" class="news-img">
                  </div>'
                );
          }
        ?>


    </div>
  </div>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script>
$(".sendBtn").click(function() {
     event.preventDefault();
        $.ajax({
          type: "POST",
          url: "addnews.php",
          data: $(".simple_form").serialize()
        }).done(function() {
          $(this).find("input").val("");
          alert("Новость добавлена!");
          location.reload();
          $(".form").trigger("reset");
          console.log("1");
        });
        return false;
      });
</script>
</body>

</html>
