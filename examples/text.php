<?php

require "vendor/autoload.php";

use \Babab\Paulos\Text;

$inptext = Text::post('text');
$text = Text::count($inptext);

?><!doctype html>
<html>
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet"
    href="//netdna.bootstrapcdn.com/bootswatch/3.1.1/journal/bootstrap.min.css">
    <script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
    <style>
      .row {
          margin-top: 25%;
      }
      textarea, input {
          width: 100%;
      }
    </style>
    <title>Test page</title>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-lg-6">

          <form method="POST">
            <textarea id="text" name="text" rows="16"><?= $inptext ?></textarea>
          </form>
          <hr />

        </div>
        <div class="col-lg-6">

            <pre><?php print_r($text) ?></pre>

        </div>
      </div>
    </div>
  </body>
</html>
