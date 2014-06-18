{% extends "_base.tpl" %}

{% block head %}
  <style>
    .container {
        margin-top: 20px;
    }
    textarea, input {
        width: 100%;
    }
    textarea {
        height: 620px;
        resize: none;
    }
    .namespace {
        opacity: 0.2;
    }
  </style>
{% endblock %}

{% block content %}

<!--
  <h3>
    <span class="namespace">\Babab\Simphplist\</span>Request
    <small>Filter REQUEST (GET/POST/COOKIE) vars</small>
    <br />
    <span class="namespace">\Babab\Simphplist\</span>String
    <small>Parse and filter strings</small>
  </h3>
-->

  <div class="row">
    <div class="col-lg-6">
    </div>
    <div class="col-lg-6">
      <h3>
        String::count($input)
        <br />
        <small>
          Count and differentiate paragraphs, lines, words and chars
        </small>
      </h3>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-6">
      <form method="POST">
        <textarea id="text" name="text"
                  placeholder="Start typing..."><?= $inptext ?></textarea>
        <input class="btn btn-success" type="submit" value="Check" />
      </form>
      <br />
      <br />
    </div>

    {% if info %}
      <div class="col-lg-6">

        <table class="table table-hover table-striped table-condensed">

          {% for item, value in info %}
            {% if item != "chars_list" and item != "words_list" %}
              <tr>
                <th>{{ item }}</th>
                <td>{{ value }}</td>
              </tr>
            {% endif %}
          {% endfor %}

        </table>

        <p><strong>most used words</strong></p>
        <table class="table table-hover table-striped table-condensed">
        <?php
            $i = 0;
            foreach ($text['words_list'] as $word => $count) {
                $perc = ($count / $text['words']) * 100;
                echo "<tr><td>`$word`</td><td>$count</td>";
                echo "<td>" . String::truncate($perc, 6, '') . "%</td></tr>";
                if ($i++ == 5)
                    break;
            }
        ?>
        </table>

        <p><strong>most used chars</strong></p>
        <table class="table table-hover table-striped table-condensed">
        <?php
            $i = 0;
            foreach ($text['chars_list'] as $char => $count) {
                $perc = ($count / $text['chars']) * 100;
                echo "<tr><td>`$char`</td><td>$count</td>";
                echo "<td>" . String::truncate($perc, 6, '') . "%</td></tr>";
                if ($i++ == 5)
                    break;
            }
        ?>
        </table>

      </div>
    {% endif %}

  </div>
{% endblock %}
{# vim: set ft=htmldjango: #}
