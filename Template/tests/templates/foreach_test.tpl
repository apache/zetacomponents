test 1
{foreach array(1,2,3) as $item }
  {$item}
  {if $item > 3}
    {continue}
  {else}
    the show is going on!
  {/if}
{/foreach}

test 2
{var $a = array(1)}
{foreach $a as $i}
{skip}
{/foreach}

test 3
{foreach $a as $k => $v}
{delimiter}::{/delimiter}
{/foreach}

