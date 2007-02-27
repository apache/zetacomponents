{use $user}

Hello
{cache_block}
	{cache_block}
		{$user->name}
	{/cache_block}
{/cache_block}
