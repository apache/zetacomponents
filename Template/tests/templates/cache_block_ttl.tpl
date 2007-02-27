{use $username}
{cache_block ttl 1}
    [{$username}]
{/cache_block}
--
{cache_block}
    [{$username}]
{/cache_block}
