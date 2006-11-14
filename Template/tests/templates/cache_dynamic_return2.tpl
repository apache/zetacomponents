{use $number}
{cache_template}
[{$number}]

{dynamic}
{if $number == 1}
	{return "One" as $numberStr, $number * 2 as $calc, "You fight like a drairy farmer." as $quote}
{/if}
{/dynamic}

{return "Not one" as $numberStr, $number * 2 as $calc, "I am rubber, you are glue." as $quote}
