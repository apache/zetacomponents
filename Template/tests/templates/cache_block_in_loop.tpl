{use $username}

{foreach 1..5 as $i}
    {cache_block}
        {$i}
    {/cache_block}
{/foreach}

{foreach 1..5 as $i}
    {cache_block keys $i}
        {$i}
    {/cache_block}
{/foreach}
