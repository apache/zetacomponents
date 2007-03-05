{use $user, $flushCB1 = false, $flushCB2 = false}
{cache_template keys $user}
TC: {$user->name}

{cache_block keys $flushCB1}
    CB1: {$user->name}
    {cache_block keys $flushCB2}
        CB2: {$user->name}
    {/cache_block}
{/cache_block}
