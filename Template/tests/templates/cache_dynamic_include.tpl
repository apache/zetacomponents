{use $a, $b}
{cache_template}

[{$a}]
[{$b}]

{include "tmp_included.tpl" 
	send "Hello" as $a, 
		 "World" as $b
	receive $number
}

[{$number}]
