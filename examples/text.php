<?php

/* require "vendor/autoload.php"; */
require "../src/Babab/Paulos/String.php";

use \Babab\Paulos\String;

$inptext = String::post('text');
$text = String::count($inptext) ?: array();

?><!doctype html>
<html>
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet"
    href="//netdna.bootstrapcdn.com/bootswatch/3.1.1/journal/bootstrap.min.css">
    <!--<script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>-->
    <style>
      .container {
          margin-top: 60px;
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
        <span class="namespace">\Babab\Paulos\</span>String
        <small>Parse and filter strings</small>
      </h1>
      <div class="row">
        <div class="col-lg-9">
          <form method="POST">
            <textarea id="text" name="text"><?= $inptext ?></textarea>
            <input class="btn btn-success" type="submit" value="Check" />
          </form>
          <br />
          <br />
        </div>
        <div class="col-lg-3">

            <table class="table table-hover table-striped">

              <?php foreach ($text as $k => $v): ?>
                <?php if ($k != 'chars_list'): ?>
                  <tr>
                    <th><?= $k ?></th>
                    <td><?= $v ?></td>
                  </tr>
                <?php endif; ?>
              <?php endforeach; ?>

            </table>

            <p><strong>most used chars</strong></p>
            <table class="table table-hover table-striped table-condensed">
            <?php
                $i = 0;
                foreach ($text['chars_list'] as $char => $count) {
                    $perc = (string) ($count / $text['chars']) * 100;
                    echo "<tr><td>`$char`</td><td>$count</td>";
                    echo "<td>" . substr($perc, 0, 6) . "%</td></tr>";
                    $i++;
                    if ($i == 12)
                        break;
                }
            ?>
            </table>

        </div>
      </div>
    </div>

    <pre><?php print_r($text); ?></pre>

  </body>
</html>
