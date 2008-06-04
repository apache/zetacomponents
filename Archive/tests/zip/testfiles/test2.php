<?php
class bar {
	private $var;
	function setVar( $v )
	{
		$this->var = $v;
	}
}

$f = 42;
$o = new bar;
$o->setVar( $f );
$a = "\0bar\0var";
$o->{$a} = 44;
var_dump( $o );
?>
