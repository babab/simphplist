{% extends "_base.tpl" %}

{% block head %}
{% endblock %}

{% block content %}

<div class="row">
  <div class="col-lg-5">
    <h2>
      Text example 1 <br />
      <small>
        Visit <a href="/text-1/">/text-1/</a>
        for an example of the following library functions:
      </small>
    </h2>
  </div>
  <div class="col-lg-7">

    <h3>
      <span class="namespace">\Simphplistib\</span>Request
      <small>Filter REQUEST (GET/POST/COOKIE) vars</small>
    </h3>
    <ul class="list-unstyled">
      <li>
        Request::post() - Sanitize POST input
      </li>
    </ul>

    <h3>
      <span class="namespace">\Simphplist\Lib\</span>String
      <small>Parse and filter strings</small>
    </h3>
    <ul class="list-unstyled">
      <li>
        String::parse() - Count and differentiate paragraphs, lines,
        words and chars
      </li>
    </ul>

  </div>
</div>

<hr />
<div class="row">
  <div class="col-lg-5">
    <h2>
      Database Model example 1<br />
      <small>
        Visit <a href="/db-model-1/">/db-model-1/</a>
        for an example of the following library functions:
      </small>
    </h2>
  </div>
  <div class="col-lg-7">

    <h3>
      <span class="namespace">\Simphplist\Lib\</span>Dump
      <small>Static methods for dumping vars to a file or screen
        (html or text)</small>
    </h3>
    <h3>
      <span class="namespace">\Simphplist\Lib\</span>Model
      <small>Object Mapper – Abstract base class for writing Models that will
        be mapped to database tables</small>
    </h3>
    <h3>
      <span class="namespace">\Simphplist\Lib\</span>ModelTest
      <small>Test model used as code example</small>
    </h3>
    <h3>
      <span class="namespace">\Simphplist\Lib\</span>MysqlHandler
      <small>MySQL Handler with table prefix support</small>
    </h3>
    <ul class="list-unstyled">
      <li>
        Model::isValid() - Checks
        words and chars
      </li>
    </ul>

  </div>
</div>


<hr />

{% endblock %}
{# vim: set ft=htmldjango: #}
