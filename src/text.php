<?php

function autoload($className)
{
    $className = ltrim($className, '\\');
    $fileName  = '';
    $namespace = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = (str_replace('\\', DIRECTORY_SEPARATOR, $namespace)
                      . DIRECTORY_SEPARATOR);
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

    require $fileName;
}

autoload('\Babab\Paulos\Text');

use \Babab\Paulos\Text;


$inptext = Text::post('text');
$text = Text::count($inptext);

?><!doctype html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>Test page</title>
  </head>
  <body>
    <form method="POST">
      <textarea id="text" name="text" cols="30"
                rows="10"><?= $inptext ?></textarea>
      <input type="submit" />
    </form>
    <pre><?php var_dump(Text::filter($inptext, 'cf')) ?></pre>
    <pre><?php print_r($text) ?></pre>
  </body>
</html>

