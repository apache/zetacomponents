{use $user}
{cache_template}
{var $a = 2}
[{$a}]
[{$user->name}]
{dynamic}
	[Nr {$a}]
	[{$user->name}]
{/dynamic}
{$a++}
{dynamic}
	[Nr {$a}]
	[{$a + $user->id}]
	[{$user->name}]
{/dynamic}
