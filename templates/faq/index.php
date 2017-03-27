<!doctype html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="css/reset.css"> <!-- CSS reset -->
    <link rel="stylesheet" href="css/style.css"> <!-- Resource style -->
    <script src="js/modernizr.js"></script> <!-- Modernizr -->
    <title>FAQ</title>
</head>
<body>
<header>
    <h1>FAQ</h1>
</header>
<!--{{ dump() }}-->
<div style="padding-left: 120px;">
    <a style="color: black;font-size: 120%;font-weight: bold ;text-decoration: underline" href="?/faq/add">Добавить
        вопрос</a>
</div>
<section class="cd-faq">
    <ul class="cd-faq-categories">
        {% for topic in topics %}
        <li><a {% if loop.first== true %}class="selected" {% endif %} href="#{{topic.name}}">{{topic.name}}</a></li>
        {% endfor %}
    </ul> <!-- cd-faq-categories -->
    <div class="cd-faq-items">
        {% for topic,items in faq %}
        <ul id={{topic}} class="cd-faq-group">
            <li class="cd-faq-title"><h2>{{topic}}</h2></li>
            {% for item in items %}
            <li>
                <a class="cd-faq-trigger" href="#0">{{item.description}}</a>
                <div class="cd-faq-content">
                    <p>{{item.content}}</p>
                </div> <!-- cd-faq-content -->
            </li>
            {% endfor %}
        </ul> <!-- cd-faq-group -->
        {% endfor %}
    </div> <!-- cd-faq-items -->
    <a href="#0" class="cd-close-panel">Close</a>
</section> <!-- cd-faq -->
<script src="js/jquery-2.1.1.js"></script>
<script src="js/jquery.mobile.custom.min.js"></script>
<script src="js/main.js"></script> <!-- Resource jQuery -->
</body>
</html>