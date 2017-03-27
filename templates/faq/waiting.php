{%extends 'base_nav.php'%}
{%block head%}ADMIN{%endblock%}
{% block activ2 %}class="active"{% endblock %}
{% block div1%}
<div style="font-weight: bold ;">
    <b style="font-size: 150%;">Вопросы без ответов</b>
</div>
{% endblock %}
{% block table%}
<table border="1" class="table table-striped">
    <thead>
    <tr>
        <th>Тема</th>
        <th>Вопрос</th>
        <th>Автор</th>
        <th>Время создания</th>
        <th></th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    {% for item in faqs %}
    <tr>
        <td>{{item.name}}</td>
        <td>{{item.description}}</td>
        <td>{{item.author}}</td>
        <td>{{item.time_create}}</td>
        <td><a href="?/faq/update/id/{{item.id}}">Изменить</a></td>
        <td><a href="?/faq/delete/id/{{item.id}}">Удалить</a></td>
    </tr>
    {% endfor %}
    </tbody>
</table>
{% endblock %}
