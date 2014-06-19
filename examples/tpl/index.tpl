{% extends "_base.tpl" %}

{% block head %}
{% endblock %}

{% block content %}

<hr />

<div class="row">
  <div class="col-lg-5">
    <h2>
      Text example <br />
      <small>
        Visit <a href="text.php">text.php</a>
        for an example of the following libraries
      </small>
    </h2>
  </div>
  <div class="col-lg-7">

    <h3>
      <span class="namespace">\Babab\Simphplist\</span>Request
      <small>Filter REQUEST (GET/POST/COOKIE) vars</small>
    </h3>
    <ul class="list-unstyled">
      <li>
        Request::post() - Sanitize POST input
      </li>
    </ul>

    <h3>
      <span class="namespace">\Babab\Simphplist\</span>String
      <small>Parse and filter strings</small>
    </h3>
    <ul class="list-unstyled">
      <li>
        String::parse() - Count and differentiate paragraphs, lines,
        words and chars
      </li>
      <li>
        String::truncate() - Truncate a string if it exceeds a certain length
      </li>
    </ul>

  </div>
</div>



<hr />

{% endblock %}
{# vim: set ft=htmldjango: #}
