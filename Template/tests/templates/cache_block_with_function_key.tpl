{use $user}

{cache_block keys str_len($user->name)}
[{$user->name}]
{/cache_block}

