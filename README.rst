Simphplist
==============================================================================

Simphplist is a mini-framework with anti-framework features. A
collection of losely coupled components, that helps you with shortcuts
and clean API's for writing the most common idioms when developing web
applications in PHP (MySQL handling, object mapper, authentication,
validation, typechecking).

You can use it as a minimalistic base for writing custom (frameworks
for) applications. Simphplist is carefully designed to allow using it
alongside any other (custom) framework.

Features / Components
------------------------------------------------------------------------------

Simphplist is in the initial stages of development. Some components may
be actually useful already though.

Checkout the API documentation here: http://simphplist.org/annotated.html

DB\\MysqlHandler
  MySQL handler with table prefix support
  [25% done of which 50% documented]

DB\\Model
  Simplistic MySQL Object Mapper
  [20% done of which 0% documented]

Debug
  Static methods for dumping vars to a file or screen (html or text)
  [100% done of which 100% documented]

Json
  Shortcuts for common idioms in JSON interaction
  [50% done of which 0% documented]

Request
  Static methods for secure user input handling via REQUEST superglobal(s):
  (GET, POST, COOKIE)
  [30% done of which 0% documented]

Route
  Minimalistic, flexible and extensible routing
  [50% done of which 80% documented]

String
  Static methods for common string manipulation / parsing tasks
  [60% done of which 20% documented]

Validate
  Clean static API for type checking and validation
  [10% done of which 100% documented]


Overview
------------------------------------------------------------------------------

Routing
#######

index.php:

.. raw:: html

   <code><span style="color: #000000"><span style="color: #0000BB">&lt;?php<br /></span><span style="color: #FF8000">//&nbsp;--&nbsp;Include&nbsp;composer&nbsp;for&nbsp;autoloading&nbsp;Simphplist<br /><br /></span>
   <span style="color: #007700">(new&nbsp;\</span><span style="color: #0000BB">Babab</span><span style="color: #007700">\</span><span style="color: #0000BB">Simphplist</span><span style="color: #007700">\</span><span style="color: #0000BB">Route</span><span style="color: #007700">)<br /><br /></span><span style="color: #FF8000">//&nbsp;Set&nbsp;a&nbsp;prefix&nbsp;to&nbsp;test&nbsp;in&nbsp;PHP's&nbsp;built&nbsp;in&nbsp;webserver<br /></span>
   <span style="color: #007700">-&gt;</span><span style="color: #0000BB">setPrefix</span><span style="color: #007700">(</span><span style="color: #DD0000">'/index.php'</span><span style="color: #007700">)<br /><br />-&gt;</span><span style="color: #0000BB">when</span><span style="color: #007700">(</span><span style="color: #DD0000">'/articles/archive/{year}/{month}/'</span><span style="color: #007700">,&nbsp;function(</span><span style="color: #0000BB">$args</span><span style="color: #007700">)&nbsp;{<br /><br />&nbsp;&nbsp;&nbsp;echo&nbsp;</span><span style="color: #DD0000">'&lt;h1&gt;Archives:&nbsp;year&nbsp;"'&nbsp;</span>
   <span style="color: #007700">.&nbsp;</span><span style="color: #0000BB">$args</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">year&nbsp;</span><span style="color: #007700">.&nbsp;</span><span style="color: #DD0000">'"&lt;/h1&gt;'</span><span style="color: #007700">;<br />&nbsp;&nbsp;&nbsp;echo&nbsp;</span><span style="color: #DD0000">'&lt;h2&gt;Month&nbsp;"'&nbsp;</span><span style="color: #007700">.&nbsp;</span><span style="color: #0000BB">$args</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">month&nbsp;</span><span style="color: #007700">.&nbsp;</span><span style="color: #DD0000">'"&lt;/h2&gt;'</span><span style="color: #007700">;<br /><br />})<br />-&gt;</span><span style="color: #0000BB">when</span><span style="color: #007700">(</span><span style="color: #DD0000">'/articles/{id}/'</span><span style="color: #007700">,&nbsp;function(</span><span style="color: #0000BB">$args</span><span style="color: #007700">)&nbsp;{<br /><br />&nbsp;&nbsp;&nbsp;echo&nbsp;</span><span style="color: #DD0000">'&lt;h1&gt;Welcome&nbsp;to&nbsp;article&nbsp;"'&nbsp;</span><span style="color: #007700">.&nbsp;</span><span style="color: #0000BB">$args</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">id&nbsp;</span><span style="color: #007700">.&nbsp;</span><span style="color: #DD0000">'"&lt;/h1&gt;'</span><span style="color: #007700">;<br /><br />})<br />-&gt;</span><span style="color: #0000BB">when</span><span style="color: #007700">(</span><span style="color: #DD0000">'/articles/'</span><span style="color: #007700">,&nbsp;function(</span><span style="color: #0000BB">$args</span><span style="color: #007700">)&nbsp;{<br /><br />&nbsp;&nbsp;&nbsp;echo&nbsp;</span><span style="color: #DD0000">'&lt;h1&gt;Welcome&nbsp;to&nbsp;the&nbsp;article&nbsp;list&lt;/h1&gt;'</span><span style="color: #007700">;<br /><br />})<br />-&gt;</span><span style="color: #0000BB">other</span><span style="color: #007700">(function()&nbsp;{<br /><br />&nbsp;&nbsp;&nbsp;echo&nbsp;</span><span style="color: #DD0000">'&lt;h1&gt;No&nbsp;other&nbsp;matches&nbsp;found,&nbsp;this&nbsp;could&nbsp;be&nbsp;a&nbsp;404&nbsp;page&lt;/h1&gt;'</span><span style="color: #007700">;<br />&nbsp;&nbsp;&nbsp;</span><span style="color: #FF8000">//&nbsp;or&nbsp;a&nbsp;redirect<br />&nbsp;&nbsp;&nbsp;//&nbsp;\Babab\Simphplist\Route::redirect('/index.php/articles/');<br /><br /></span><span style="color: #007700">});<br /></span></span></code>


License
------------------------------------------------------------------------------

Copyright (c) 2014  Benjamin Althues <benjamin@babab.nl>

Permission to use, copy, modify, and distribute this software for any
purpose with or without fee is hereby granted, provided that the above
copyright notice and this permission notice appear in all copies.

THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES
WITH REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF
MERCHANTABILITY AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR
ANY SPECIAL, DIRECT, INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES
WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER IN AN
ACTION OF CONTRACT, NEGLIGENCE OR OTHER TORTIOUS ACTION, ARISING OUT OF
OR IN CONNECTION WITH THE USE OR PERFORMANCE OF THIS SOFTWARE.
