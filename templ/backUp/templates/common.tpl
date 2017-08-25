<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>{{ meta_title }}</title>
		
		<link href="{{ TEMPLATE_URL }}/css/bootstrap.min.css" rel="stylesheet">
		<link href="{{ TEMPLATE_URL }}/css/common.css" rel="stylesheet">
		
		<script src="{{ TEMPLATE_URL }}/js/jquery-3.2.1.min.js"></script>
		<script src="{{ TEMPLATE_URL }}/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container">
			<header class="clearfix">
				<h3 class="pull-left">
					<a href="{{ SITE_URL }}/">smm-opt.ru</a>
				</h3>
				<div class="pull-right">
					{% include 'login.tpl' %}
				</div>
			</header>
			
			<div class="content">
				{% block content_header %}
					<h3>{{ content_header }}</h3>
				{% endblock %}
				{% block content %}{% endblock %}
			</div>
		</div>
	</body>
</html>