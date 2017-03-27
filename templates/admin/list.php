{%extends 'base_nav.php'%}
{%block head%}ADMIN{%endblock%}
{% block activ3 %}class="active"{% endblock %}
{% block div1%}
<div style="font-weight: bold ;">
    <b style="font-size: 150%;">Список администраторов</b>
    <a style="margin-left:20px;" href="?/admin/add">Добавить администратора</a>
</div>
{% endblock %}
{% block table%}
<table border="1" class="table table-striped">
    <thead>
    <tr>
        <th>Логин</th>
        <th></th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    {% for item in data %}
    <tr>
        <td>{{item.login}}</td>
        <td><a href="?/admin/delete/id/{{item.id}}">Удалить</a></td>
        <td><a href="?/admin/update/id/{{item.id}}">Изменить пароль</a></td>
    </tr>
    {% endfor %}
    </tbody>
</table>
{% endblock %}