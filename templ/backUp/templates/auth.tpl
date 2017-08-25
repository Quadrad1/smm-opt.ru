{% extends 'common.tpl' %}

{% block content %}
	{% if is_logged %}
		<p>Вы уже авторизованы на сайте.</p>
	{% else %}
		<div class="row">
			<div class="col-xs-12 col-sm-6">
				<form role="form" action="" method="post">
					<input type="hidden" name="action" value="sign_in">
					<div class="form-group">
						<label for="email">E-mail</label>
						<input type="email" name="email" id="email" class="form-control" placeholder="Введите электронный адрес" required="">
					</div>
					<div class="form-group">
						<label for="password">Пароль</label>
						<input type="password" name="password" id="password" class="form-control" placeholder="Введите пароль" required="">
					</div>
					<button type="submit" class="btn btn-success">Отправить</button>
					<a href="{{ SITE_URL }}/index.php?mod=password" class="btn btn-danger">Забыли пароль?</a>
				</form>
			</div>
		</div>
		{% if error %}
			<p class="error">{{ error }}</p>
		{% endif %}
	{% endif %}
{% endblock %}