<?php

class DebugTestFormatterClass
{
    public function fooBar()
    {
        $test = 23;
        $this->fooBaz(
            $test,
            array(
                23.0,
                fopen( __FILE__, 'r' ),
                1,
                2,
                array(
                    'a',
                    'b',
                    true,
                    new DebugTestFormatterContainerClass()
                ),
                array(
                    23.42,
                    false,
                    null,
                    'test',
                    array(
                        'deep',
                        'deeper',
                        'deepest'
                    )
                )
            )
        );
    }

    private function fooBaz( $a, $b, $c = true )
    {
        self::testStatic();
    }

    protected static function testStatic()
    {
        file_put_contents( 'php_stacktrace.php', var_export( debug_backtrace(), true ) );
        // file_put_contents( 'xdebug_stacktrace.php', var_export( xdebug_get_function_stack(), true ) );
    }

    public static function __set_state( array $state )
    {
        return new DebugTestFormatterClass();
    }
}

class DebugTestFormatterContainerClass extends stdClass
{
    public static function __set_state( array $state )
    {
        $obj = new DebugTestFormatterContainerClass();
        foreach ( $state as $key => $val )
        {
            $obj->$key = $val;
        }
        return $obj;
    }
}

function testDebugFormatter( $bar )
{
    $foo = new DebugTestFormatterClass();
    $foo->fooBar();
}

// testDebugFormatter( 'test' );

?>
