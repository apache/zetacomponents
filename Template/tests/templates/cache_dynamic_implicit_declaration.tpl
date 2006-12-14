{use $number}
{cache_template}
{foreach 1..5 as $a}
{/foreach}
{dynamic}
{$number}
{$a}
{/dynamic}
{foreach 1..6 as $b}
{/foreach}
{dynamic}
{$b}
{/dynamic}

{include "tmp_included.tpl" 
	send 1 as $a, 2 as $b, 3 as $p, 4 as $q
	receive $number}

{$number}
{dynamic}
{$number}
{/dynamic}
