{%extends 'base_signin.php'%}
{%block head%}ADMIN{%endblock%}
{% block form %}
<form action="?/admin/update/id/{{data['id']}}/" method="post" class="form-signin">
    <h2 class="form-signin-heading">Изменить пароль для {{data['login']}}</h2>
    <input type="hidden" name="HTTP_REFERER" value={{HTTP_REFERER}}>
    <input type="hidden" name="login" value={{data['login']}}>
    <label for="inputPassword" class="sr-only">Пароль</label>
    <input type="password" id="inputPassword" class="form-control" placeholder="Новый пароль" name="password" required
           autofocus>
    <button class="btn btn-lg tn-success btn-block" type="submit">Сохранить</button>

</form>
{% endblock %}
{% block return %}
<div style="text-align:  center;">
    <p><a href="{{HTTP_REFERER}}"> < Назад</a></p>
</div>
{% endblock %}
