{use $user}

{cache_block keys $user}
[{$user->name}]
{/cache_block}
