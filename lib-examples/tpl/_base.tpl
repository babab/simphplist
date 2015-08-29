<!doctype html>
<html>
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet"
          href="//netdna.bootstrapcdn.com/bootswatch/3.1.1/cerulean/bootstrap.min.css">
    <script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js">
    </script>
    {% block head %}
    {% endblock %}
    <title>{{ subtitle }} - Simphplist lib-examples</title>
  </head>
  <body>
    <div class="container">
      <h1>
        Simphplist lib-examples <small>{{ subtitle }}</small>
      </h1>
      <ul class="nav nav-tabs">
        <li><a href="javascript:;">home</a></li>
        <li><a href="javascript:;">documentation</a></li>
        <li><a href="javascript:;">download</a></li>

        <li{% if section == "index" %} class="active"{% endif %}>
          <a href="/">lib-examples index</a>
        </li>

        <li class="dropdown{% if section != "index" %} active{% endif %}">
          <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;">
            lib-examples list <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li{% if section == "text-1" %} class="active"{% endif %}>
              <a href="/text-1/">Text example 1</a>
            </li>
          </ul>
        </li>

        <li class="pull-right"><a href="javascript:;">Bitbucket</a></li>
        <li class="pull-right"><a href="javascript:;">Github</a></li>
      </ul>
      {% block content %}
      {% endblock %}
    </div>
  </body>
</html>
{# vim: set ft=htmldjango: #}
