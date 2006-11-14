{use $number}
{cache_template}
[{$number}]
{if $number == 0}
	{return "Zero" as $x}
{elseif $number == 1}
	{return "One" as $x}
{/if}
