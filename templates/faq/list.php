{%extends 'base_nav.php'%}
{%block head%}ADMIN{%endblock%}
{% block activ4 %}class="active"{% endblock %}
{% block form%}
<form class="form-horizontal" action="?/faq/list" method="post">
    <div class="row">
        <div class="form-group">
            <label class="control-label col-xs-4" for="topic_id">Тема:</label>
            <div class="col-xs-2">
                <select class="form-control" name="topic_id" id="topic_id" required onchange="this.form.submit()">
                    <option></option>
                    {% for topic in topics %}
                    <option value={{topic['id']}} {{ topic[
                    'id'] == params['id'] ? 'selected'}}>{{topic['name']}}</option>
                    {% endfor %}
                </select>
            </div>
        </div>
    </div>
</form>
{% endblock %}
{% block table%}
{% if params['id'] > 0 %}
<table border="1" class="table table-striped">
    <thead>
    <tr>
        <th>Время создания</th>
        <th>Вопрос</th>
        <th>Статус</th>
        <th>Изм.статус</th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    {% for item in data %}
    <tr>
        <td>{{item.time_create}}</td>
        <td>{{item.description}}</td>
        <td>{{item.status|my_st}}</td>
        <td><a {{ item.status== 0 ? 'hidden'}} href="?/faq/change/id/{{item.id}}">{{item.status|my_sti}}</a>
        </td>
        <td><a href="?/faq/delete/id/{{item.id}}">Удалить</a></td>
        <td><a href="?/faq/update/id/{{item.id}}">Изменить</a></td>
        <td><a {{ item.status !=0 ? 'hidden'}} href="?/faq/answer/id/{{item.id}}">Добавить ответ</a></td>
        <td><a href="?/faq/move/id/{{item.id}}/name/{{item.name}}">Переместить</a></td>
    </tr>
    {% endfor %}
    </tbody>
</table>
{% endif %}
{% endblock %}

