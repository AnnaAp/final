{%extends 'base_signin.php'%}
{%block head%}Добавить тему{%endblock%}
{% block form %}
<form class="form-signin" method="post" action="?/topic/add">
    <h2 class="form-signin-heading">Введите новую тему:</h2>
    <label for="inputName" class="sr-only">Название темы</label>
    <input type="text" id="inputName" class="form-control" placeholder="Название темы" name="name" required
           autofocus>

    <button class="btn btn-lg btn-success btn-block" type="submit">Сохранить</button>
</form>
{% endblock %}
{% block return %}
<div style="text-align:  center;">
    <p><a href="?/topic/list"> < Назад</a></p>
</div>
{% endblock %}
