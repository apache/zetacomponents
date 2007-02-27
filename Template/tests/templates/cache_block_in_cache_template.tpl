{use $user}
{cache_template}

Hello
{cache_block}
    {$user->name}
{/cache_block}
