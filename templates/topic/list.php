{%extends 'base_nav.php'%}
{%block head%}ADMIN{%endblock%}
{% block activ1 %}class="active"{% endblock %}
{% block div1%}
<div style="font-weight: bold ;">
    <b style="font-size: 150%;">Список тем</b>
    <a  style="margin-left:20px;" href="?/topic/add">Добавить тему</a>
</div>
{% endblock %}
{% block table%}
<table  border="1"  class="table table-striped">
    <thead>
    <tr>
        <th rowspan="2">Тема</th>
        <th colspan="3">Вопросов в теме</th>
        <th rowspan="2">Удалить с вопросами</th>
        <th rowspan="2">Вопросы по теме</th>
    </tr>
    <tr>
        <th>Всего</th>
        <th>Опубликовано</th>
        <th>Без ответа</th>
    </tr>
    </thead>
    <tbody>
    {% for topic in topics %}
    <tr>
        <td>{{topic.name}}</td>
        <td>{{topic.qw_all}}</td>
        <td>{{topic.qw_pb}}</td>
        <td>{{topic.qq_wt}}</td>
        <td><a href="?/topic/delete/id/{{topic.id}}">Удалить</a></td>
        <td><a href="?/faq/list/id/{{topic.id}}">Просмотр</a></td>
    </tr>
    {% endfor %}
    </tbody>
</table>
{% endblock %}