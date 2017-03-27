{%extends 'base_signin.php'%}
{%block head%}ADMIN{%endblock%}
{% block form %}
<form action="?/admin/add" method="post" class="form-signin">
    <h2 class="form-signin-heading">Добавить администратора</h2>
    <label for="inputEmail" class="sr-only">Логин</label>
    <input type="text" id="inputEmail" class="form-control" placeholder="Логин" name="login" required autofocus>
    <label for="inputPassword" class="sr-only">Пароль</label>
    <input type="password" id="inputPassword" class="form-control" placeholder="Пароль" name="password" required>
    <button class="btn btn-lg btn-success btn-block" type="submit">Сохранить</button>
</form>
{% endblock %}
{% block return %}
<div style="text-align:  center;">
    <p><a href="?/admin/list"> < Назад</a></p>
</div>
{% endblock %}