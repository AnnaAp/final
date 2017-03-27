{%extends 'base_signin.php'%}
{%block head%}Авторизация{%endblock%}
{% block error %}
<div class="container">
    <!--    {{ dump() }}-->
    <ul>
        {% for error in errors %}
        <li style="color:red">{{error}}</li>
        {% endfor %}

    </ul>
</div>
{% endblock %}
{% block form %}
<form action="?/admin/signin" method="post" class="form-signin">
    <h2 class="form-signin-heading">Авторизуйтесь</h2>
    <label for="inputEmail" class="sr-only">Логин</label>
    <input type="text" id="inputEmail" class="form-control" placeholder="Логин" name="login" required autofocus>
    <label for="inputPassword" class="sr-only">Пароль</label>
    <input type="password" id="inputPassword" class="form-control" placeholder="Пароль" name="password" required>
    <button class="btn btn-lg btn-default btn-block" type="submit">Вход</button>
</form>
{% endblock %}
