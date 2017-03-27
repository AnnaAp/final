{%extends 'base_signin.php'%}
{%block head%}Добавить ответ{%endblock%}
{% block form %}
<form class="form-signin" method="post" action="?/faq/answer/id/{{data['id']}}/">
    <h4 class="form-signin-heading">Добавить ответ на вопрос</h4>
    <div>
        <p>{{data['description']}}</p>
    </div>
    <label for="inputAns">Ответ</label>
    <input type="text" id="inputAns" class="form-control" placeholder="Ответ" name="content" required>
    <div class="radio">
        <label><input type="radio" checked name="status" value="1"> Опубликовать</label>
        <label><input type="radio" name="status" value="2"> Скрыть</label>
    </div>
    <input type="hidden" name="HTTP_REFERER" value={{HTTP_REFERER}}>

    <button class="btn btn-lg btn-success btn-block" type="submit">Сохранить</button>
</form>
{% endblock %}
{% block return %}
<div style="text-align:  center;">
    <p><a href="{{HTTP_REFERER}}"> < Назад</a></p>
</div>
{% endblock %}
