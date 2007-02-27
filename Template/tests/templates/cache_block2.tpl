{use $user, $user2}
[{$user->name}][{$user2->name}]

{cache_block keys $user}
    1.[{$user->name}]
    1.[{$user2->name}]
{/cache_block}

[{$user->name}][{$user2->name}]

{cache_block keys $user2}
    2.[{$user->name}]
    2.[{$user2->name}]
{/cache_block}

[{$user->name}][{$user2->name}]
