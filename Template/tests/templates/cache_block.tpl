{use $user}
[{$user->name}]
{var $a}

{cache_block}
	{$a = 2}
	[{$user->name}]
{/cache_block}
