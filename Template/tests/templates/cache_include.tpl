{use $a, $b}
{cache_template}

[{$a}]
[{$b}]

{include "tmp_included.tpl" 
	send 
		  $a, 
		  $b,
		 "Hello" as $p, 
		 "World" as $q

	receive $number, $t
}

[{$number}]
[{$t}]
