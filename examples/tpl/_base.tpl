<!doctype html>
<html>
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet"
    href="//netdna.bootstrapcdn.com/bootswatch/3.1.1/cerulean/bootstrap.min.css">
    <script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
    {% block head %}
    {% endblock %}
    <title>{{ subtitle }} - Simphplist</title>
  </head>
  <body>
    <div class="container">
      <h1>
        Simphplist <small>{{ subtitle }}</small>
      </h1>
      {% block content %}
      {% endblock %}
    </div>
  </body>
</html>
{# vim: set ft=htmldjango: #}
