{use $user}
[{$user->name}]

{cache_block}
    1. {$user->name}
    {dynamic}
    dyn: {$user->name}
    {/dynamic}
{/cache_block}

[{$user->name}]

{cache_block}
    2. {$user->name}
    {dynamic}
    dyn: {$user->name}
    {/dynamic}
{/cache_block}

[{$user->name}]
