{use $user}

{if true}
{cache_template keys $user}
{/if}

{$user->name}
