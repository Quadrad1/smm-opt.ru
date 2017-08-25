{% if is_logged %}
	<b>Баланс: {{ user.balance }} руб.</b>
	<a href="{{ SITE_URL }}/index.php?mod=account" class="btn btn-success">Личный кабинет</a>
	<a href="{{ SITE_URL }}/index.php?mod=auth&amp;action=sign_out" class="btn btn-danger">Выйти</a>
{% else %}
	<a href="{{ SITE_URL }}/index.php?mod=auth" class="btn btn-success">Вход</a>
	<a href="{{ SITE_URL }}/index.php?mod=register" class="btn btn-primary">Регистрация</a>
{% endif %}