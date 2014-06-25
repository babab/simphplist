{% extends "_base.tpl" %}

{% block head %}
  <link rel="stylesheet" href="main.css" />
  <script src="main.js"></script>
{% endblock %}

{% block content %}

  <h2 class="pull-right">Input</h2>
  <div class="clearfix"></div>

  <div class="row">
    <div class="col-lg-3">

      <h3>
        Request::post()
        <br />
        <small>
        Sanitize POST input
        </small>
      </h3>

      <br />

      <p>
        You can also fill the textarea with
        <input type="number" id="paras" value="3" min="1" />
        paragraphs using the
        <a id="bacon" href="http://baconipsum.com/api/" target="_blank">
          Bacon Ipsum
        </a> API
      </p>

    </div>
    <div class="col-lg-9">

      <form method="POST">
        <textarea id="text" name="text"
                  placeholder="Start typing...">{{ text }}</textarea>
        <input class="btn btn-success" type="submit" value="Check" />
      </form>

    </div><!-- .row -->
  </div><!-- .col-lg-12 -->

  <hr />
  <h2 class="pull-right">Output</h2>
  <div class="clearfix"></div>

  {% if info %}

    <h3>
      String::count()
      <small>
        Count and differentiate paragraphs, lines, words and chars
      </small>
    </h3>

    <div class="row">
      <div class="col-lg-4">

        <p><strong>totals</strong></p>

        <table class="table table-striped table-condensed">
          {% for item, value in info %}
            {% if item not in keys_to_skip %}
              <tr>
                <th>{{ item }}</th>
                <td class="col-lg-1">{{ value }}</td>
              </tr>
            {% endif %}
          {% endfor %}
        </table>

      </div><!-- .col-lg-4 -->
      <div class="col-lg-4">

        <p><strong>most used words</strong></p>
        <table class="table table-striped table-condensed">

          {% for word, count in info.words_list %}
            {% if loop.index > 7 %}
              <tr class="words-hidden">
            {% else %}
              <tr>
            {% endif %}
                <td>{{ word }}</td>
                <td class="col-lg-1">{{ count.0 }}</td>
                <td class="col-lg-1">{{ count.1[0:6] }}%</td>
              </tr>
          {% endfor %}

          {% if info.words_list|length > 7 %}
            <tr class="words-show">
              <td colspan="3">
                <a class="pull-right" href="javascript:;">
                  Show remaining {{ info.words_list|length - 7 }} words
                </a>
              </td>
            </tr>
          {% endif %}

        </table>

      </div><!-- .col-lg-4 -->
      <div class="col-lg-4">

        <p><strong>most used chars</strong></p>
        <table class="table table-striped table-condensed">

          {% for char, count in info.chars_list %}
            {% if loop.index > 7 %}
              <tr class="chars-hidden">
            {% else %}
              <tr>
            {% endif %}
                <td>{{ char }}</td>
                <td class="col-lg-1">{{ count.0 }}</td>
                <td class="col-lg-1">{{ count.1[0:6] }}%</td>
              </tr>
          {% endfor %}

          {% if info.chars_list|length > 7 %}
            <tr class="chars-show">
              <td colspan="3">
                <a class="pull-right" href="javascript:;">
                  Show remaining {{ info.chars_list|length - 7 }} chars
                </a>
              </td>
            </tr>
          {% endif %}

        </table>

      </div><!-- .col-lg-4 -->
    </div><!-- .row -->

    <div class="row">
      <div class="col-lg-12">

        <a class="text-toggle" href="javascript:;">Show/hide full text input</a>
        <pre class="text-hidden">{{ text }}</pre>

      </div><!-- .col-lg-12 -->
    </div><!-- .row -->

  {% else %}
    <p>
      Enter some text in the textarea and post the form
    </p>
  {% endif %}
{% endblock %}
{# vim: set ft=htmldjango: #}
