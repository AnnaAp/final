<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <!--    <link rel="icon" href="../../favicon.ico">-->
    <title>{% block title %}{% endblock %}</title>

    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/navbar-static-top.css" rel="stylesheet">

</head>

<body>

<!-- Static navbar -->
<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="?/faq/index">FAQ</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li {% block activ1 %}{% endblock %}><a href="?/topic/list">Темы</a></li>
                <li {% block activ2 %}{% endblock %}><a href="?/faq/waiting">Вопросы без ответов</a></li>
                <li {% block activ4 %}{% endblock %}><a href="?/faq/list/id/0">Вопросы по теме</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li {% block activ3 %}{% endblock %}><a href="?/admin/list">Администраторы</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">{{session.login}}<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="?/admin/logout">Выход</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <!-- Main component for a primary marketing message or call to action -->
    {% block form%}
    {% endblock %}
    {% block div1%}
    {% endblock %}
    <div class="table-responsive">
        {% block table%}
        {% endblock %}
    </div>
</div> <!-- /container -->
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!--<script>window.jQuery || document.write('<script src="dist/assets/js/vendor/jquery.min.js"><\/script>')</script>-->
<script src="dist/js/bootstrap.min.js"></script>
</body>
</html>
