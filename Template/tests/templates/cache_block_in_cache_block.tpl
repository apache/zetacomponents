{use $user, $flushInner = false}

Outside: {$user->name}

{cache_block keys $user}
    Outer: {$user->name}
    {cache_block keys $flushInner}
        Inner: {$user->name}
    {/cache_block}
{/cache_block}
