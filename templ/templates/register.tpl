{% extends 'common.tpl' %}

{% block content %}
	{% if info %}
		<p>{{ info }}</p>
	{% else %}
		<div class="row">
			<div class="col-xs-12 col-sm-6">
				<form role="form" action="" method="post" onsubmit="return checkForm(this);">
					<div class="form-group">
						<label for="email">E-mail</label>
						<input type="email" name="email" value="{{ email }}" id="email" class="form-control" placeholder="Введите электронный адрес" required="">
					</div>
					<div class="form-group">
						<label for="password">Пароль</label>
						<input type="password" name="password" id="password" class="form-control" placeholder="Придумайте пароль" required="">
					</div>
					<div class="form-group">
						<label for="password_confirm">Подтверждение пароля</label>
						<input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="Повторите пароль" required="">
					</div>
					<div class="form-group">
						<label for="promo">Промокод (необязательно)</label>
						<input type="text" name="promo" id="promo" class="form-control" placeholder="Промокод">
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
	{% endif %}
{% endblock %}
