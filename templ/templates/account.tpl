{% extends 'common.tpl' %}

{% block content %}
	{% if info %}
		<p>{{ info }}</p>
	{% elseif action == 'change_password' %}
		<div class="row">
			<div class="col-xs-12 col-sm-6">
				<form role="form" action="" method="post" onsubmit="return checkForm(this);">
					<div class="form-group">
						<label for="current_password">Действующий пароль</label>
						<input type="password" name="current_password" id="current_password" class="form-control" placeholder="Введите действующий пароль" required="">
					</div>
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
						if (form.current_password.value == form.password.value) {
							alert('Действующий и новый пароли не могут быть одинаковыми.');
							return false;
						} else if (form.password.value != form.password_confirm.value) {
							alert('Новые пароли не совпадают.');
							return false;
						}
					}
				</script>
				<script type='text/javascript'>
				(function(){ var widget_id = 'gi1l4G9PmA';var d=document;var w=window;function l(){
				var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})(); </script>
			</div>
		</div>
		{% if error %}
			<p class="error">{{ error }}</p>
		{% endif %}
	{% elseif action == 'payment' %}
		{% if result == 'success' %}
			<p>Ваш баланс успешно пополнен.</p>
            <p><a href="//smm-opt.ru/index.php" class="btn btn-success">Перейти к созданию заказа</a></p>
		{% elseif result == 'fail' %}
			<p>В процессе оплаты произошла ошибка. Средства не были зачислены на ваш счёт.</p>
		{% elseif robokassa %}
			<form role="form" action="https://merchant.roboxchange.com/Index.aspx" method="post">
				{% for key,value in robokassa %}
					<input type="hidden" name="{{ key }}" value="{{ value }}">
				{% endfor %}
				<p>Для пополнения баланса на сумму <b>{{ robokassa.OutSum }} руб.</b> Вам необходимо перейти на сайт робокассы и произвести оплату.</p>
				<button type="submit" class="btn btn-success">Перейти к оплате</button>
			</form>
		{% else %}
			<div class="row">
				<div class="col-xs-12 col-sm-6">
					<form role="form" action="" method="post">
						<div class="form-group">
							<label for="payment_sum">Сумма пополнения в рублях</label>
							<input type="text" name="payment_sum" id="payment_sum" class="form-control" placeholder="100.00" pattern="[0-9]+(\.[0-9]{1,2})?" required="">
						</div>
						<button type="submit" class="btn btn-success">Продолжить</button>
					</form>
				</div>
			</div>
		{% endif %}
	{% else %}
		<div class="account_infoblock">
			<p><b>E-mail:</b> {{ user.email }}</p>
			<p><b>Баланс:</b> {{ user.balance }} руб.</p>
			<a href="{{ SITE_URL }}/index.php?mod=account&amp;action=change_password" class="btn btn-primary">Изменить пароль</a>
			<a href="{{ SITE_URL }}/index.php?mod=account&amp;action=payment" class="btn btn-success">Пополнить баланс</a>
		</div>

		<h4>Последние транзакции</h4>
		{% if not transaction_list %}
			<div class="account_infoblock">
				Список транзакций пуст.
			</div>
		{% else %}
			<table class="table">
				<thead>
					<tr>
						<th>Дата</th>
						<th>Сумма</th>
						<th>Комментарий</th>
					</tr>
				</thead>
				<tbody>
					{% for transaction in transaction_list %}
						<tr>
							<td>{{ transaction.datetime }}</td>
							{% if transaction.sum > 0 %}
								<td style="color: green; font-weight: bold;">+{{ transaction.sum }} руб.</td>
							{% elseif transaction.sum < 0 %}
								<td style="color: red; font-weight: bold;">{{ transaction.sum }} руб.</td>
							{% else %}
								<td>{{ transaction.sum }} руб.</td>
							{% endif%}
							<td>{{ transaction.comment }}</td>
						</tr>
					{% endfor %}
				</tbody>
			</table>
		{% endif %}

		<h4>Последние заказы</h4>
		{% if not order_list %}
			<div class="account_infoblock">
				Список заказов пуст.
			</div>
		{% else %}
			<table class="table">
				<thead>
					<tr>
						<th>Дата</th>
						<th>Название услуги</th>
						<th>Сумма заказа</th>
					</tr>
				</thead>
				<tbody>
					{% for order in order_list %}
						<tr>
							<td>{{ order.datetime }}</td>
							<td>{{ order.service_name }}</td>
							<td>{{ order.price }} руб.</td>
						</tr>
					{% endfor %}
				</tbody>
			</table>
		{% endif %}
	{% endif %}
{% endblock %}
