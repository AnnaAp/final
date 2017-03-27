{%extends 'base_signin.php'%}
{%block head%}Переместить вопрос{%endblock%}
{% block form %}
<form class="form-signin" method="post" action="?/faq/move/id/{{data['id']}}">
    <div><b>Переместить вопрос:</b><i> {{data['description']}}</i></div>
    <div><b>из темы:{{params['name']}}<b></div>
    <b>в тему:</b>
    <div>
        <label for="topic_id" class="sr-only">Выбор темы:</label>
        <select class="form-control" name="topic_id" title="Выбор темы" required>
            <option></option>
            {% for topic in topics %}
            <option value={{topic['id']}}>{{topic['name']}}</option>
            {% endfor %}
        </select>
    </div>
    </br>
    <input type="hidden" name="HTTP_REFERER" value={{HTTP_REFERER}}>
    <input type="hidden" name="old_id" value="{{data['topic_id']}}">
    <button class="btn btn-lg btn-success btn-block" type="submit">Сохранить</button>
</form>
{% endblock %}
{% block return %}
<div style="text-align:  center;">
    <p><a href="{{HTTP_REFERER}}"> < Назад</a></p>
</div>
{% endblock %}