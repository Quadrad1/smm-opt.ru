<?php
 $connection = mysqli_connect("localhost","fedor2ce_smm","38*mX1BGwb*l8a&4","fedor2ce_smm");
	if($connection == true){
		$title = "connect";
	}else{
		echo "Dont't Connected!!!!.</br></br></br>";
		$tittle = "Error";
		exit();
	}

	/*= mysqli_query($connection,"SELECT * FROM  ``");
	= mysqli_fetch_assoc();*/

	$data = mysqli_query($connection,"SELECT * FROM `news` ORDER BY `id` DESC");


		?>

<!DOCTYPE html>

<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="description" content="Увеличьте количество подписчиков, лайков и просмотров всего в несколько кликов. Станьте узнаваемым и увеличьте вашу выручку в кратчайшие сроки.
">
  <meta name="keywords" content="smm, social network, promotion, followers, likes, views, facebook, twitter, instagram, youtube, periscope, vimeo, vine, vk, vkontakte, google plus смм, социальная сеть, продвижение, подписчики, фолловеры, лайки, просмотры, фейсбук, твиттер, инстаграм, ютуб, перископ, вимео, вайн, вк, вконтакте, гугл плюс
">

  <meta name="csrf-param" content="authenticity_token" />
<meta name="csrf-token" content="Mk9hncYT92p7hHZtTHhufrH4jkKjAFIDhVT44vV9RPo7cnqqZQSn39JOfobi//Fehtu7SNw6rdR/2xQsE/uPHg==" />
  <link rel="shortcut icon" href="assets\landing\favicon.ico">
  <link rel="stylesheet" media="all" href="//fonts.googleapis.com/css?family=Raleway:400,300,600" />
  <link rel="stylesheet" media="all" href="assets/landing-4e73cd2d2d78093ca8e316521eecccb5b5d9788ffb45621fbe43aaaa2d1674b0.css" />
  <link rel="stylesheet" href="assets/css/font-awesome.min.css">
  <script src="assets/landing-4c9263e45cdd505b81078e09ab76fc3ad39035257e2ad0ed86b462549cacb798.js"></script>

  <title>
    Новости
  </title>
  <!-- Продвигайтесь в социальных медиа автоматически и увеличьте прибыль на 67% за один день -->
</head>
<body>

<div class="container u-full-width u-max-full-width menu">
  <div class="row menu__row">
    <div class="column u-pull-left menu__item">
      <a class="menu__logo" href="/"><img src="assets\landing\smm.png" style="height: 150%;" alt=""></a>
    </div>

    <div class="column u-pull-right menu__item">
      <a class="button menu__item__button" target="_blank" href="//smm-opt.ru/index.php">Вернуться</a>
    </div>

    <!-- <div class="column u-pull-right menu__item">
      <a class="menu__item__link" href="contacts.html">Контакты</a>
    </div>

    <div class="column u-pull-right menu__item">
      <a class="menu__item__link" href="news.html">Новости</a>
    </div>

    <div class="column u-pull-right menu__item">
      <a class="menu__item__link" href="index.html">Главная</a>
    </div> -->
  </div>
</div>

<section class="section_darkened section_hero" id="hero" style="height: 150px;min-height:150px;">
  <div class="container section_hero__container">
    <!-- <h1 class="section_hero__heading">
      Продвигайтесь в социальных медиа автоматически и увеличьте прибыль на 67% за один день
    </h1>

    <h5 class="section_hero__description">
      Увеличьте количество подписчиков, лайков и просмотров всего в несколько кликов. Станьте узнаваемым и увеличьте вашу выручку в кратчайшие сроки.

    </h5>

    <a class="button button-primary section_hero__button " href="//smm-opt.ru/index.php?mod=register">Зарегистрируйтесь сейчас</a>

    <div class="section_hero__sign-in">
      <p class="section_hero__sign-in__label">
        или
      </p>

      <a class="button " href="https://smm-opt.ru/index.php?mod=auth">Войдите</a>
    </div> -->
  </div>
</section>





<section class="section" id="reviews">
  <div class="container">
    <h2 class="section__title">
      Наши новости
    </h2>
<?php

  while(($art = mysqli_fetch_assoc($data))){
      echo('<div class="news-block">
              <img src="' . $art['img_url'] . '"  alt="" >
              <div class="news-info">
                <h2 class="title-news">' . $art['title'] . '</h2>
                <p>' . $art['description'] . '</p>
              </div>
              <p class="read-more">
                  '. $art['date'] .'
              </p>
            </div>');
    }
  ?>
</div>
</section>

<!-- <section class="section section_contacts" id="contacts">
  <div class="container">
    <h2 class="section__title">
      Наши контакты
    </h2>

    <div class="row">
        <a class="section_contacts__link" href="#">
          live:721da6f0041f6f4b
        </a>
        <a class="section_contacts__link width" style="width:165px;" href="mailto: support@smm-opt.ru">
          support@smm-opt.ru
        </a>

    </div>
  </div>
</section> -->




<div class="modal modal_forgot-password" id="forgot_password_modal">
  <a href="javascript:void(0)" class="modal__close">
    &times;
  </a>

  <h5>
    Забыли ваш пароль?
  </h5>

  <!-- <form class="simple_form form_forgot-password" novalidate="novalidate" id="new_user" action="/users/password" accept-charset="UTF-8" data-remote="true" method="post"><input name="utf8" type="hidden" value="&#x2713;" />
  <div class="pure-control-group email optional user_email"><label class="email optional" for="user_email">E-mail</label><input class="string email optional form__input u-full-width" type="email" value="" name="user[email]" id="user_email" /></div>

  <div class="form__actions">
    <input type="submit" name="commit" value="Отправьте мне инструкции по восстановлению пароля" class="button-primary" />
  </div>
</form> -->
</div>

<div class="modal modal_sign-in" id="sign_in_modal">
  <a href="javascript:void(0)" class="modal__close">
    &times;
  </a>

  <h5>
    Вход
  </h5>

  <!-- <form class="simple_form form_sign-in" novalidate="novalidate" id="new_user" action="/users/sign_in" accept-charset="UTF-8" data-remote="true" method="post"><input name="utf8" type="hidden" value="&#x2713;" />
  <div class="pure-control-group email optional user_email"><label class="email optional" for="user_email">E-mail</label><input class="string email optional form__input u-full-width" type="email" value="" name="user[email]" id="user_email" /></div>
  <div class="pure-control-group password optional user_password"><label class="password optional" for="user_password">Пароль</label><input class="password optional form__input u-full-width" type="password" name="user[password]" id="user_password" /></div>

  <div class="row">
    <div class="one-half column">
      <div class="pure-control-group boolean optional user_remember_me"><input value="0" type="hidden" name="user[remember_me]" /><label class="boolean optional pure-checkbox" for="user_remember_me"><input class="boolean optional form__input" type="checkbox" value="1" checked="checked" name="user[remember_me]" id="user_remember_me" /><span class="label-body">Запомнить меня</span></label></div>
    </div>

    <div class="one-half column form_sign-in__forgot-password">
      <a class="modal-trigger" href="#forgot_password_modal">Забыли ваш пароль?</a>
    </div>
  </div>

  <div class="form__actions">
    <input type="submit" name="commit" value="Войти" class="button-primary" />
  </div>
</form> -->
</div>

<div class="modal" id="sign_up_modal">
  <a href="javascript:void(0)" class="modal__close">
    &times;
  </a>

  <h5>
    Зарегистрироваться
  </h5>


<!-- <form class="simple_form form_sign-up" novalidate="novalidate" id="new_user" action="/users.js" accept-charset="UTF-8" data-remote="true" method="post"><input name="utf8" type="hidden" value="&#x2713;" />
  <input class="hidden form__input" type="hidden" name="user[referrer_token]" id="user_referrer_token" />

  <div class="pure-control-group email optional user_email"><label class="email optional" for="user_email">E-mail</label><input class="string email optional form__input u-full-width" type="email" value="" name="user[email]" id="user_email" /></div>

  <div class="row">
    <div class="one-half column">
      <div class="pure-control-group password optional user_password"><label class="password optional" for="user_password">Пароль</label><input class="password optional form__input u-full-width" type="password" name="user[password]" id="user_password" /></div>
    </div>

    <div class="one-half column">
      <div class="pure-control-group password optional user_password_confirmation"><label class="password optional" for="user_password_confirmation">Подтверждение пароля</label><input class="password optional form__input u-full-width" type="password" name="user[password_confirmation]" id="user_password_confirmation" /></div>
    </div>
  </div>


  <div class="form__actions">
    <input type="submit" name="commit" value="Зарегистрируйтесь и увеличьте прибыль!" class="button-primary" />
  </div>
</form> -->
</div>






</body>
</html>
