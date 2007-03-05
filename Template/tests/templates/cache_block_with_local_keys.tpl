{use $user}

{var $id = $user->name}
{cycle $c = array(1,2)}

{cache_block keys $id, $c}
[{$user->name}]
{/cache_block}

