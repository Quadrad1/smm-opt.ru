{% if is_logged %}

	<b>Баланс: {{ user.balance }} руб.</b>
	<a href="{{ SITE_URL }}/index.php?mod=account" class="first_btn btn btn-success h_button">Кабинет</a>
	<a href="//smm-opt.ru/index.php" class="btn btn-success h_button">Заказать</a>
	<a href="{{ SITE_URL }}/news.php" class="btn btn-success h_button">Новости</a>
	<a href="//smm-opt.ru/contacts.html" class="btn btn-success h_button">Контакты</a>
	<a href="{{ SITE_URL }}/index.php?mod=auth&amp;action=sign_out" class="btn btn-danger h_button">Выйти</a>
{% else %}
	<a href="{{ SITE_URL }}/index.php?mod=auth" class="btn btn-success h_button first_btn">Вход</a>
	<a href="{{ SITE_URL }}/index.php?mod=register" class="btn btn-primary h_button">Регистрация</a>
{% endif %}
