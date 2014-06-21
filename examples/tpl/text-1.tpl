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
        height: 200px;
        resize: none;
    }
    .namespace {
        opacity: 0.2;
    }
    #paras {
        width: 50px;
    }

    .words-hidden {
        display: none;
    }
  </style>
  <script>
    $(document).ready(function() {
        // Show hidden divs
        $('.words-toggle').click(function (){
            $(this).hide('slow');
            $('.words-hidden').show('slow');
        });

        // Bacon Ipsum API call
        $("#paras").change(function() {
            var paras = parseInt($('#paras').val());

            if (paras >= 1 && paras <= 100) {
                $.getJSON(
                    'http://baconipsum.com/api/?callback=?',
                    {'type':'meat-and-filler', 'paras': paras},
                    function(bacon) {
                        console.log(bacon);
                        var text = '';
                        if (bacon && bacon.length > 0) {
                            for (var i = 0; i < bacon.length; i++)
                                text += bacon[i] + "\n\n";
                            $('#text').val(text);
                        }
                });
            }
        });
    });
  </script>
{% endblock %}

{% block content %}

  <hr />

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
        <a id="bacon" href="http://baconipsum.com/api/">Bacon Ipsum</a> API
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
            <tr class="words-toggle">
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
        <table class="table table-hover table-striped table-condensed">

          {% for char, perc in info.chars_list_perc|slice(0, 5) %}
            <tr><td>{{ char }}</td><td class="col-lg-1">{{ perc }}</td></tr>
          {% endfor %}

        </table>

      </div><!-- .col-lg-4 -->
    </div><!-- .row -->

  {% else %}
    <p>
      Enter some text in the textarea and post the form
    </p>
  {% endif %}
{% endblock %}
{# vim: set ft=htmldjango: #}
