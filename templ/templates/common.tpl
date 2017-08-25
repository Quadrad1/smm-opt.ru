<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
			<link rel="shortcut icon" href="assets\landing\favicon.ico">

		<title>{{ meta_title }}</title>

		<link href="{{ TEMPLATE_URL }}/css/bootstrap.min.css" rel="stylesheet">
		<link href="{{ TEMPLATE_URL }}/css/common.css" rel="stylesheet">

		<script src="{{ TEMPLATE_URL }}/js/jquery-3.2.1.min.js"></script>
		<script src="{{ TEMPLATE_URL }}/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container">
			<header class="clearfix">
				<h3 class="center">
					<a href="//smm-opt.ru/index.php" ></a>
				</h3>
				<div class="header__buttons" style="margin: 0 10px;">
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
	<script type='text/javascript'>
	(function(){ var widget_id = 'gi1l4G9PmA';var d=document;var w=window;function l(){
	var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})(); </script>
</html>
