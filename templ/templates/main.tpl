{% extends 'common.tpl' %}

{% block content %}
	{% if info %}
		<p>{{ info }}</p>
	{% else %}
    	<table class="table table-bordered table-striped service_list">
    		<thead>
    			<tr>
    				<th>Название</th>
    				<th>Стоимость</th>
    				<th class="text-right">Опции</th>
    			</tr>
    		</thead>
    		<tbody>
    			{% for network,services in service_list %}
                        <form action="" method="get">
                            <input type="hidden" name="mod" value="order">
                            <tr>
                                <td colspan="3">{{ network }}</td>
                            </tr>
                            <tr>
            					<td>
                                    <select name="service_id" class="form-control" required="">
                                        {% set price = '0.00' %}

                                        {% for key,service in services %}
                                            {% if key == 0 %}
                                                {% set price = service.price %}
                                            {% endif %}
                        					<option value="{{ service.id }}" data-price="{{ service.price }}">{{ service.name }}</option>
                    				    {% endfor %}
                                    </select>
                                </td>
            					<td>
                                    <span>{{ price }}</span> руб.
                                </td>
            					<td class="text-right">
            						<button type="submit" class="btn btn-primary btn-sm">Заказать</button>
            					</td>
            				</tr>
                        </form>
    			{% endfor %}
    		</tbody>
    	</table>
        <script>
            $('select[name="service_id"]').on('change', function() {
                var price = $(this).children('option:selected').data('price');
                $(this).parent().next().children('span').text(price);
            });
        </script>

				<script type='text/javascript'>
				(function(){ var widget_id = 'gi1l4G9PmA';var d=document;var w=window;function l(){
				var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})(); </script>
	{% endif %}
{% endblock %}
