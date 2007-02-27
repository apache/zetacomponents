{use $user}

Hello
{dynamic}
	{cache_block}
		{$user->name}
	{/cache_block}
{/dynamic}
