Simphplist
==========

**Simplistic PHP library and framework with a clean API**

Simphplist is in early development right now and may have many
backwards-incompatible changes between minor versions (0.X.0) until
version 1.0 is released.

Visit http://simphplist.org/ for full documentation and examples of all
(past) versions of Simphplist.


Simphplist Lib
--------------

Simphplist Lib helps you with shortcuts and clean API's for writing the
most common idioms when developing web applications in PHP (routing,
debugging, validation and ``$_GET``/``$_POST`` filtering).

You can use it as a minimalistic base for writing custom (frameworks
for) applications. Simphplist Lib is carefully designed to allow using
it alongside any other (custom) framework.


Simphplist Framework
--------------------

Simphplist Framework is a minimalistic MTV / MVC framework for PHP based
upon a small set of components. The main goal is to give developers a
simplistic framework that focuses on fast development of webapps while
still giving much freedom in the way you want to put the ends together.

It relies on the following components:

- M - Model: The model layer is not yet implemented.
- V/T - View/Template: Twig is used for templating and outputing views
  by default.
- C/V - Controller/View: Controllers are methods of a View class.


License
=======

Simphplist is released under an ISC license, which is functionally
equivalent to the simplified BSD and MIT/Expat licenses, with language
that was deemed unnecessary by the Berne convention removed.

------------------------------------------------------------------------------

Copyright (c) 2014-2016  Benjamin Althues <benjamin@babab.nl>

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
