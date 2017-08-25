{% extends 'common.tpl' %}

{% block content %}
	{% if info %}
		<p>{{ info }}</p>
	{% else %}
		<div id="result">
			<p><b>Соцсеть:</b> {{ service.network }}</p>
			<p><b>Название:</b> {{ service.name }}</p>
			<p><b>Стоимость:</b> {{ service.price }} руб. за {{ service.quantity.per }} ед.</p>
			<form role="form" action="" method="post" onsubmit="checkout(); return false;">
				<input type="hidden" name="action" value="sign_in">
				<div class="form-group">
					<label for="target_page">Целевая страница соцсети</label>
					<input type="text" name="target_page" id="target_page" class="form-control" placeholder="{{ target_page_placeholder }}" required="">
				</div>
				<div class="form-group">
					<label for="quantity">Количество единиц</label>
					<input type="number" name="quantity" id="quantity" class="form-control" placeholder="Минимум: {{ service.quantity.min }}, Максимум: {{ service.quantity.max }}" min="{{ service.quantity.min }}" max="{{ service.quantity.max }}" data-price="{{ service.price }}" data-price-per="{{ service.quantity.per }}" required="">
				</div>
                {% if service.epsmm_id == 234 %}
                    <div class="form-group">
    					<label for="comments">Текст комментариев</label>
    					<input type="text" name="comments" id="comments" class="form-control" placeholder="новый комментарий через точку" required="">
    				</div>
                {% endif %}
				<p><b>Итого:</b> <span id="total_price">0.00</span> руб.</p>
				<button type="submit" id="submit_btn" class="btn btn-success" data-loading-text="Выполняется...">Оформить заказ</button>
			</form>
			<p class="error"></p>
		</div>
		<script>
			$('input[name="quantity"]').on('change', function() {
				var quantity = parseInt($(this).val());
				var total_price = (Number($(this).data('price')) / Number($(this).data('price-per'))) * quantity;
				if (isNaN(total_price) || total_price < 0) {
					total_price = 0;
				}
				
				$('#total_price').text(total_price.toFixed(2));
			});
			
			function checkout() {
				var target_page = $('input[name="target_page"]').val();
				var quantity = parseInt($('input[name="quantity"]').val());
				if (isNaN(quantity) || quantity < 0) {
					quantity = 0;
				}
				
				$.ajax({
					url: '{{ SITE_URL }}/index.php?mod=order',
					type: 'post',
					data: {
						'action': 'checkout',
						'service_id': '{{ service.id }}',
						'target_page': target_page,
						'quantity': quantity
					},
					dataType: 'json',
					beforeSend: function() {
						$('p.error').text('');
						$('#submit_btn').button('loading');
					},
					complete: function() {
						$('#submit_btn').button('reset');
					},
					success: function(result) {
						if (result.error) {
						    $('p.error').html(result.error);
						} else {
							$('#result').html('<p>Ваш заказ принят к реализации и вскоре будет выполнен нами.</p>');
							$('#result').append('<p><a href="{{ SITE_URL }}/" class="btn btn-success">Создать новый заказ</a></p>');
						}
					},
					error: function() {
						alert('Request error. Please, try later.');
					}
				});
			}
		</script>
	{% endif %}
{% endblock %}