<code><span style="color: #000000">
<span style="color: #0000BB">&lt;?php<br /></span><span style="color: #FF8000">/*<br />&nbsp;*&nbsp;Paulos&nbsp;Text<br />&nbsp;*<br />&nbsp;*&nbsp;Copyright&nbsp;(c)&nbsp;2014&nbsp;Benjamin&nbsp;Althues&nbsp;&lt;benjamin@babab.nl&gt;<br />&nbsp;*<br />&nbsp;*&nbsp;Permission&nbsp;to&nbsp;use,&nbsp;copy,&nbsp;modify,&nbsp;and&nbsp;distribute&nbsp;this&nbsp;software&nbsp;for&nbsp;any<br />&nbsp;*&nbsp;purpose&nbsp;with&nbsp;or&nbsp;without&nbsp;fee&nbsp;is&nbsp;hereby&nbsp;granted,&nbsp;provided&nbsp;that&nbsp;the&nbsp;above<br />&nbsp;*&nbsp;copyright&nbsp;notice&nbsp;and&nbsp;this&nbsp;permission&nbsp;notice&nbsp;appear&nbsp;in&nbsp;all&nbsp;copies.<br />&nbsp;*<br />&nbsp;*&nbsp;THE&nbsp;SOFTWARE&nbsp;IS&nbsp;PROVIDED&nbsp;"AS&nbsp;IS"&nbsp;AND&nbsp;THE&nbsp;AUTHOR&nbsp;DISCLAIMS&nbsp;ALL&nbsp;WARRANTIES<br />&nbsp;*&nbsp;WITH&nbsp;REGARD&nbsp;TO&nbsp;THIS&nbsp;SOFTWARE&nbsp;INCLUDING&nbsp;ALL&nbsp;IMPLIED&nbsp;WARRANTIES&nbsp;OF<br />&nbsp;*&nbsp;MERCHANTABILITY&nbsp;AND&nbsp;FITNESS.&nbsp;IN&nbsp;NO&nbsp;EVENT&nbsp;SHALL&nbsp;THE&nbsp;AUTHOR&nbsp;BE&nbsp;LIABLE&nbsp;FOR<br />&nbsp;*&nbsp;ANY&nbsp;SPECIAL,&nbsp;DIRECT,&nbsp;INDIRECT,&nbsp;OR&nbsp;CONSEQUENTIAL&nbsp;DAMAGES&nbsp;OR&nbsp;ANY&nbsp;DAMAGES<br />&nbsp;*&nbsp;WHATSOEVER&nbsp;RESULTING&nbsp;FROM&nbsp;LOSS&nbsp;OF&nbsp;USE,&nbsp;DATA&nbsp;OR&nbsp;PROFITS,&nbsp;WHETHER&nbsp;IN&nbsp;AN<br />&nbsp;*&nbsp;ACTION&nbsp;OF&nbsp;CONTRACT,&nbsp;NEGLIGENCE&nbsp;OR&nbsp;OTHER&nbsp;TORTIOUS&nbsp;ACTION,&nbsp;ARISING&nbsp;OUT&nbsp;OF<br />&nbsp;*&nbsp;OR&nbsp;IN&nbsp;CONNECTION&nbsp;WITH&nbsp;THE&nbsp;USE&nbsp;OR&nbsp;PERFORMANCE&nbsp;OF&nbsp;THIS&nbsp;SOFTWARE.<br />&nbsp;*/<br /><br /></span><span style="color: #007700">namespace&nbsp;</span><span style="color: #0000BB">Babab</span><span style="color: #007700">\</span><span style="color: #0000BB">Paulos</span><span style="color: #007700">;<br /><br />class&nbsp;</span><span style="color: #0000BB">Text<br /></span><span style="color: #007700">{<br />&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;static&nbsp;function&nbsp;</span><span style="color: #0000BB">get</span><span style="color: #007700">(</span><span style="color: #0000BB">$var</span><span style="color: #007700">,&nbsp;</span><span style="color: #0000BB">$defaultValue</span><span style="color: #007700">=</span><span style="color: #DD0000">''</span><span style="color: #007700">)<br />&nbsp;&nbsp;&nbsp;&nbsp;{<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #0000BB">$filtered&nbsp;</span><span style="color: #007700">=&nbsp;</span><span style="color: #0000BB">filter_input</span><span style="color: #007700">(</span><span style="color: #0000BB">INPUT_GET</span><span style="color: #007700">,&nbsp;</span><span style="color: #0000BB">$var</span><span style="color: #007700">,&nbsp;</span><span style="color: #0000BB">FILTER_SANITIZE_STRING</span><span style="color: #007700">);<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;return&nbsp;</span><span style="color: #0000BB">$filtered&nbsp;</span><span style="color: #007700">?:&nbsp;</span><span style="color: #0000BB">$defaultValue</span><span style="color: #007700">;<br />&nbsp;&nbsp;&nbsp;&nbsp;}<br /><br />&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;static&nbsp;function&nbsp;</span><span style="color: #0000BB">post</span><span style="color: #007700">(</span><span style="color: #0000BB">$var</span><span style="color: #007700">,&nbsp;</span><span style="color: #0000BB">$defaultValue</span><span style="color: #007700">=</span><span style="color: #DD0000">''</span><span style="color: #007700">)<br />&nbsp;&nbsp;&nbsp;&nbsp;{<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #0000BB">$filtered&nbsp;</span><span style="color: #007700">=&nbsp;</span><span style="color: #0000BB">filter_input</span><span style="color: #007700">(</span><span style="color: #0000BB">INPUT_POST</span><span style="color: #007700">,&nbsp;</span><span style="color: #0000BB">$var</span><span style="color: #007700">,&nbsp;</span><span style="color: #0000BB">FILTER_SANITIZE_STRING</span><span style="color: #007700">);<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;return&nbsp;</span><span style="color: #0000BB">$filtered&nbsp;</span><span style="color: #007700">?:&nbsp;</span><span style="color: #0000BB">$defaultValue</span><span style="color: #007700">;<br />&nbsp;&nbsp;&nbsp;&nbsp;}<br /><br />&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;static&nbsp;function&nbsp;</span><span style="color: #0000BB">count</span><span style="color: #007700">(</span><span style="color: #0000BB">$text</span><span style="color: #007700">)<br />&nbsp;&nbsp;&nbsp;&nbsp;{<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;if&nbsp;(</span><span style="color: #0000BB">trim</span><span style="color: #007700">(</span><span style="color: #0000BB">$text</span><span style="color: #007700">)&nbsp;===&nbsp;</span><span style="color: #DD0000">''</span><span style="color: #007700">)<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;return&nbsp;</span><span style="color: #0000BB">Null</span><span style="color: #007700">;<br /><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #FF8000">/*&nbsp;Count&nbsp;words&nbsp;*/<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #0000BB">$nWords&nbsp;</span><span style="color: #007700">=&nbsp;</span><span style="color: #0000BB">str_word_count</span><span style="color: #007700">(</span><span style="color: #0000BB">$text</span><span style="color: #007700">);<br /><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #FF8000">/*&nbsp;Count&nbsp;(blank)&nbsp;lines&nbsp;and&nbsp;paragraphs&nbsp;*/<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #0000BB">$lines&nbsp;</span><span style="color: #007700">=&nbsp;</span><span style="color: #0000BB">explode</span><span style="color: #007700">(</span><span style="color: #DD0000">"\n"</span><span style="color: #007700">,&nbsp;</span><span style="color: #0000BB">$text</span><span style="color: #007700">);<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #0000BB">$nLines&nbsp;</span><span style="color: #007700">=&nbsp;</span><span style="color: #0000BB">count</span><span style="color: #007700">(</span><span style="color: #0000BB">$lines</span><span style="color: #007700">);<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #0000BB">$blankLines&nbsp;</span><span style="color: #007700">=&nbsp;</span><span style="color: #0000BB">0</span><span style="color: #007700">;<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #0000BB">$paragraphs&nbsp;</span><span style="color: #007700">=&nbsp;</span><span style="color: #0000BB">0</span><span style="color: #007700">;<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #0000BB">$lastLineHasContent&nbsp;</span><span style="color: #007700">=&nbsp;</span><span style="color: #0000BB">False</span><span style="color: #007700">;<br /><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;foreach&nbsp;(</span><span style="color: #0000BB">$lines&nbsp;</span><span style="color: #007700">as&nbsp;</span><span style="color: #0000BB">$line</span><span style="color: #007700">)&nbsp;{<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;if&nbsp;(</span><span style="color: #0000BB">trim</span><span style="color: #007700">(</span><span style="color: #0000BB">$line</span><span style="color: #007700">)&nbsp;==&nbsp;</span><span style="color: #DD0000">''</span><span style="color: #007700">)&nbsp;{<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #0000BB">$blankLines</span><span style="color: #007700">++;<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;if&nbsp;(</span><span style="color: #0000BB">$lastLineHasContent</span><span style="color: #007700">)<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #0000BB">$paragraphs</span><span style="color: #007700">++;<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #0000BB">$lastLineHasContent&nbsp;</span><span style="color: #007700">=&nbsp;</span><span style="color: #0000BB">False</span><span style="color: #007700">;<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;else<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #0000BB">$lastLineHasContent&nbsp;</span><span style="color: #007700">=&nbsp;</span><span style="color: #0000BB">True</span><span style="color: #007700">;<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}<br /><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;if&nbsp;(</span><span style="color: #0000BB">trim</span><span style="color: #007700">(</span><span style="color: #0000BB">$lines</span><span style="color: #007700">[</span><span style="color: #0000BB">count</span><span style="color: #007700">(</span><span style="color: #0000BB">$lines</span><span style="color: #007700">)&nbsp;-&nbsp;</span><span style="color: #0000BB">1</span><span style="color: #007700">])&nbsp;!=&nbsp;</span><span style="color: #DD0000">''</span><span style="color: #007700">)<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #0000BB">$paragraphs</span><span style="color: #007700">++;<br /><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #FF8000">/*&nbsp;Count&nbsp;chars&nbsp;*/<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #0000BB">$chars&nbsp;</span><span style="color: #007700">=&nbsp;array();<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #0000BB">$nChars&nbsp;</span><span style="color: #007700">=&nbsp;</span><span style="color: #0000BB">0</span><span style="color: #007700">;<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;foreach&nbsp;(</span><span style="color: #0000BB">str_split</span><span style="color: #007700">(</span><span style="color: #0000BB">$text</span><span style="color: #007700">)&nbsp;as&nbsp;</span><span style="color: #0000BB">$char</span><span style="color: #007700">)&nbsp;{<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;if&nbsp;(!</span><span style="color: #0000BB">ctype_cntrl</span><span style="color: #007700">(</span><span style="color: #0000BB">$char</span><span style="color: #007700">))&nbsp;{<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;if&nbsp;(!isset(</span><span style="color: #0000BB">$chars</span><span style="color: #007700">[</span><span style="color: #0000BB">$char</span><span style="color: #007700">]))<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #0000BB">$chars</span><span style="color: #007700">[</span><span style="color: #0000BB">$char</span><span style="color: #007700">]&nbsp;=&nbsp;</span><span style="color: #0000BB">0</span><span style="color: #007700">;<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #0000BB">$chars</span><span style="color: #007700">[</span><span style="color: #0000BB">$char</span><span style="color: #007700">]++;<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #0000BB">$nChars</span><span style="color: #007700">++;<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}<br /><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #0000BB">arsort</span><span style="color: #007700">(</span><span style="color: #0000BB">$chars</span><span style="color: #007700">);<br /><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;return&nbsp;array(<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #DD0000">'paragraphs'&nbsp;</span><span style="color: #007700">=&gt;&nbsp;</span><span style="color: #0000BB">$paragraphs</span><span style="color: #007700">,<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #DD0000">'lines'&nbsp;</span><span style="color: #007700">=&gt;&nbsp;</span><span style="color: #0000BB">$nLines</span><span style="color: #007700">,<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #DD0000">'lines_blank'&nbsp;</span><span style="color: #007700">=&gt;&nbsp;</span><span style="color: #0000BB">$blankLines</span><span style="color: #007700">,<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #DD0000">'lines_content'&nbsp;</span><span style="color: #007700">=&gt;&nbsp;</span><span style="color: #0000BB">$nLines&nbsp;</span><span style="color: #007700">-&nbsp;</span><span style="color: #0000BB">$blankLines</span><span style="color: #007700">,<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #DD0000">'words'&nbsp;</span><span style="color: #007700">=&gt;&nbsp;</span><span style="color: #0000BB">$nWords</span><span style="color: #007700">,<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #DD0000">'chars'&nbsp;</span><span style="color: #007700">=&gt;&nbsp;</span><span style="color: #0000BB">$nChars</span><span style="color: #007700">,<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color: #DD0000">'chars_list'&nbsp;</span><span style="color: #007700">=&gt;&nbsp;</span><span style="color: #0000BB">$chars</span><span style="color: #007700">,<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;);<br />&nbsp;&nbsp;&nbsp;&nbsp;}<br />}<br /></span>
</span>
</code>