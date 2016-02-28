Dump component
==============

Overview
--------

Static methods for dumping vars to a file or screen (html or text).

The Simphplist debug class is just some fancy wrappers around
``var_dump`` and ``print_r``, but provides a straight-forward way of dumping
values to either the screen or a file.

   "The most effective debugging tool is still careful thought, coupled
   with judiciously placed print statements." -- Brian Kernighan

.. note::

   You need to explicitly set the value of ``Dump::$debug``

   Simphplist Dump adds protection (for production environments) and
   flexibility by using a trigger setting ``Dump::$debug`` that needs to be
   explicitly set to true-ish before it will output anything. Leaving or
   setting it at a value that evaluates as false will make sure leftover
   debug calls will not do anything.

You can set the ``$debug`` value to ``text``, ``html`` or ``file`` to
override the dump method used, no mather what method is actually called
in the code.

Example
-------

somefile.php:

.. code-block:: php

   <?php
   use \Simphplist\Lib\Dump;

   $someMapping = [];
   for ($i = 0; $i < 20; $i++) {
       $someMapping[$i] = $i * 2;
   }

   Dump::$debug = true;
   Dump::$file = '/var/www/dump.log';
   Dump::file($someMapping, $_SERVER);
   ?>

Class reference
---------------

.. php:namespace:: Simphplist\Lib

.. php:class:: Dump

   Static methods for dumping vars to a file or screen (html or text).

   .. php:attr:: $debug = false

      Debug value, can be a boolean or a string with the method used for
      overriding Dump method calls.

      Example:

      .. code-block:: php

         <?php
         use \Simphplist\Lib\Dump;

         // Override all debug calls to html()
         Dump::$debug = 'html';

         // Because of the override, this will actually be dumped as html
         Dump::text($_SERVER);
         ?>

   .. php:attr:: $file = '/tmp/simphplist-debug.log'

      String with the complete path to the dumpfile used in Dump::file
      method calls. Default is ``/tmp/simphplist-debug.log``

   .. php:attr:: $tags = ['<pre>', '</pre>']

      A 2-item array with the start and end tags to use when dumping
      variables with the ``html`` method.

      Example:

      .. code-block:: php

         <?php
         use \Simphplist\Lib\Dump;

         Dump::$debug = true;

         // Echo in a textarea instead of a <pre> block
         Dump::$tags = ['<textarea rows="24" style="width: 100%">', '</textarea>'];
         Dump::html($_SERVER);
         ?>

.. php:method:: text(..., ...)

   Echo variable as a simple text string.

   :param mixed ...: one or more variables to dump
   :returns: (void | string) Error string when there are errors, else void

   .. code-block:: php

      <?php
      use \Simphplist\Lib\Dump;

      Dump::$debug = true;
      Dump::text($_SERVER);
      ?>

.. php:method:: html(..., ...)

   Echo variable dumps in an html formatted text string

   :param mixed ...: one or more variables to dump
   :returns: (void | string) Error string when there are errors, else void

   .. code-block:: php

      <?php
      use \Simphplist\Lib\Dump;

      Dump::$debug = true;
      Dump::html($_SERVER);
      ?>
