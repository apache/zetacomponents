{use $user}
Before: [{$user->name}]

{cache_block}
    Cache block 0: [{$user->name}]
{/cache_block}

Between cb 0 and 1: [{$user->name}]

{cache_block}
    Cache block 1: [{$user->name}]
{/cache_block}

After: [{$user->name}]
