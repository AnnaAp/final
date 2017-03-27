{%extends 'base_signin.php'%}
{%block head%}Добавить вопрос{%endblock%}
{% block form %}
<form class="form-signin" method="post" action="?/faq/add">
    <h2 class="form-signin-heading">Задайте вопрос:</h2>
    <label for="inputName" class="sr-only">Ваше имя</label>
    <input type="text" id="inputName" class="form-control" placeholder="Ваше имя" name="author" required autofocus>
    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="email" id="inputEmail" class="form-control" placeholder="Ваш Email" name="email" required>
    <label for="inputProblem" class="sr-only">Вопрос</label>
    <input type="text" id="inputProblem" class="form-control" placeholder="Вопрос" name="description" required>
    <div>
        <label for="topic_id" ">Выбор темы:</label>
        <select class="form-control" name="topic_id" title="Выбор темы" required>
            <option></option>
            {% for topic in topics %}
            <option value={{topic['id']}}>{{topic['name']}}</option>
            {% endfor %}
        </select>
    </div>
    </br>
    <button class="btn btn-lg btn-success btn-block" type="submit">Сохранить</button>
</form>
{% endblock %}
{% block return %}
<div style="text-align:  center;">
    <p><a href="?/faq/index"> < Назад</a></p>
</div>
{% endblock %}