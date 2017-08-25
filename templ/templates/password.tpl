{% extends 'common.tpl' %}

{% block content %}
	{% if info %}
		<p>{{ info }}</p>
	{% elseif action == 'recovery' or action == 'set_new_password' %}
		<div class="row">
			<div class="col-xs-12 col-sm-6">
				<form role="form" action="{{ SITE_URL }}/index.php?mod=password" method="post" onsubmit="return checkForm(this);">
					<input type="hidden" name="action" value="set_new_password">
					<input type="hidden" name="email" value="{{ email }}">
					<input type="hidden" name="token" value="{{ token }}">
					<div class="form-group">
						<label for="password">Новый пароль</label>
						<input type="password" name="password" id="password" class="form-control" placeholder="Придумайте новый пароль" required="">
					</div>
					<div class="form-group">
						<label for="password_confirm">Подтверждение пароля</label>
						<input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="Повторите новый пароль" required="">
					</div>
					<button type="submit" class="btn btn-success">Отправить</button>
				</form>
				<script>
					function checkForm(form) {
						if (form.password.value != form.password_confirm.value) {
							alert('Пароли не совпадают.');
							return false;
						}
					}
				</script>
			</div>
		</div>
		{% if error %}
			<p class="error">{{ error }}</p>
		{% endif %}
	{% else %}
		<div class="row">
			<div class="col-xs-12 col-sm-6">
				<form role="form" action="" method="post">
					<input type="hidden" name="action" value="send_mail">
					<div class="form-group">
						<label for="email">E-mail указанный при регистрации</label>
						<input type="email" name="email" value="{{ email }}" id="email" class="form-control" placeholder="Введите электронный адрес" required="">
					</div>
					<button type="submit" class="btn btn-success">Отправить</button>
				</form>
			</div>
		</div>
		{% if error %}
			<p class="error">{{ error }}</p>
		{% endif %}
	{% endif %}
{% endblock %}