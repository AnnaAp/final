{%extends 'base_signin.php'%}
{%block head%}Изменить вопрос{%endblock%}
{% block form %}
<form class="form-signin" method="post" action="?/faq/update/id/{{data['id']}}/">
    <h2 class="form-signin-heading">Редактировать</h2>
    <label for="inputName">Автор</label>
    <input type="text" id="inputName" class="form-control" placeholder="Автор"
           name="author" value="{{data['author']}}" required autofocus>
    <label for="inputEmail">Email address</label>
    <input type="email" id="inputEmail" class="form-control" placeholder="Email"
           name="email" value="{{data['email']}}" required>
    <label for="inputProblem">Вопрос</label>
    <input type="text" id="inputProblem" class="form-control" placeholder="Вопрос"
           name="description" value="{{data['description']}}" required>
    <input type="hidden" name="HTTP_REFERER" value={{HTTP_REFERER}}>
    {% if data.status > 0 %}
    <label for="inputAns">Ответ</label>
    <input type="text" id="inputAns" class="form-control" placeholder="Ответ"
           name="content" value="{{data['content']}}" required>
    {% endif %}
    </br>
    <button class="btn btn-lg btn-success btn-block" type="submit">Сохранить</button>
</form>
{% endblock %}
{% block return %}
<div style="text-align:  center;">
    <p><a href="{{HTTP_REFERER}}"> < Назад</a></p>
</div>
{% endblock %}
