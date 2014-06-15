<?php

/* require "vendor/autoload.php"; */
require "../src/Babab/Simphplist/Request.php";
require "../src/Babab/Simphplist/String.php";
require "../src/Babab/Simphplist/Validate.php";

use \Babab\Simphplist\Request;
use \Babab\Simphplist\String;
use \Babab\Simphplist\Validate;

$inptext = Request::post('text');
$text = String::count($inptext) ?: array();

$replaceArray = array(
    array('', ''),
);

?><!doctype html>
<html>
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet"
    href="//netdna.bootstrapcdn.com/bootswatch/3.1.1/journal/bootstrap.min.css">
    <!--<script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>-->
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
    <title>Test page</title>
  </head>
  <body>
    <div class="container">
      <h1>
        Simphplist mini-framework
        <small>demonstration</small>
      </h1>
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
            <textarea id="text" name="text"><?= $inptext ?></textarea>
            <input class="btn btn-success" type="submit" value="Check" />
          </form>
          <br />
          <br />
        </div>

<?php if ($text): ?>
        <div class="col-lg-6">


          <table class="table table-hover table-striped table-condensed">

            <?php foreach ($text as $k => $v): ?>
              <?php if ($k != 'chars_list' && $k != 'words_list'): ?>
                <tr>
                  <th><?= $k ?></th>
                  <td><?= $v ?></td>
                </tr>
              <?php endif; ?>
            <?php endforeach; ?>

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
<?php endif; ?>

      </div>
    </div>

    <pre><?php
            echo "Validate::isBool(\$input, false) ::: ";
            var_dump(Validate::isBool($inptext, false));

            echo "Validate::isTimeString(\$input) ::: ";
            var_dump(Validate::isTimeString($inptext));

            echo "String::truncate ::: ";
            var_dump(String::truncate($inptext, 15));
    ?></pre>

    <pre><?php /*print_r($text); */ ?></pre>

    <pre><?php echo wordwrap(String::replace($inptext, $replaceArray), 80); ?></pre>

  </body>
</html>
