<?php
/**
 * Describes the difference between two values.
 *
 * One value is the expected and the other is the actual value which was retrieved.
 */
abstract class ezcMockDiff
{
    /**
     * Expected value of the retrieval which does not match $actual.
     * @var mixed
     */
    public $expected;
    /**
     * Actually retrieved value which does not match $expected.
     * @var mixed
     */
    public $actual;
    /**
     * Optional prefix which is placed in front of all lines returned in
     * generateDifference().
     * @var string
     */
    public $prefix;

    /**
     * Initialises with the expected value and the actual value.
     *
     * @param mixed $expected Expected value retrieved.
     * @param mixed $actual Actual value retrieved.
     * @param string $prefix A string which is prefixed on all returned lines
     *                       in the difference output.
     */
    public function __construct( $expected, $actual, $prefix = false )
    {
        $this->expected = $expected;
        $this->actual = $actual;
        $this->prefix = $prefix;
    }

    /**
     * Generates a string representing the difference between two
     * values which is meant to be read by a human being.
     *
     * @return string
     */
    public abstract function generateDifference();

    /**
     * Figures out which diff class to use for the input types then
     * instantiates that class and returns the object.
     * @note The diff is type sensitive, if the type differs only the types
     *       are shown.
     *
     * @param mixed $expected Expected value retrieved.
     * @param mixed $actual Actual value retrieved.
     * @param string $prefix A string which is prefixed on all returned lines
     *                       in the difference output.
     * @return ezcMockDiff
     */
    public static function diffIdentical( $expected, $actual, $prefix = false )
    {
        if ( gettype( $expected ) !== gettype( $actual ) )
        {
            return new ezcMockTypeDiff( $expected, $actual, $prefix );
        }
        elseif( is_string( $expected ) )
        {
            return new ezcMockStringDiff( $expected, $actual, $prefix );
        }
        elseif( is_bool( $expected ) or
                is_int( $expected ) or
                is_float( $expected ) )
        {
            return new ezcMockScalarDiff( $expected, $actual, $prefix );
        }
        elseif( is_array( $expected ) )
        {
            return new ezcMockArrayDiff( $expected, $actual, $prefix );
        }
        elseif( is_object( $expected ) )
        {
            return new ezcMockObjectDiff( $expected, $actual, $prefix );
        }
    }
    /**
     * Figures out which diff class to use for the input types then
     * instantiates that class and returns the object.
     * @note The diff is not type sensitive, if the type differs the $actual
     *       value will be converted to the same type as the $expected.
     *
     * @param mixed $expected Expected value retrieved.
     * @param mixed $actual Actual value retrieved.
     * @param string $prefix A string which is prefixed on all returned lines
     *                       in the difference output.
     * @return ezcMockDiff
     */
    public static function diffEqual( $expected, $actual, $prefix = false )
    {
        if ( gettype( $expected ) !== gettype( $actual ) )
        {
            $expected = (string)$expected;
            $actual = (string)$actual;
        }

        if ( is_string( $expected ) )
        {
            return new ezcMockStringDiff( $expected, $actual, $prefix );
        }
        elseif( is_bool( $expected ) or
                is_int( $expected ) or
                is_float( $expected ) )
        {
            return new ezcMockScalarDiff( $expected, $actual, $prefix );
        }
        elseif( is_array( $expected ) )
        {
            return new ezcMockArrayDiff( $expected, $actual, $prefix );
        }
        elseif( is_object( $expected ) )
        {
            return new ezcMockObjectDiff( $expected, $actual, $prefix );
        }
    }

    /**
     * Exports the value $value to a string but in a shortened form.
     *
     * @param mixed $value The value to export as string.
     * @return string
     */
    public static function shortenedExport( $value )
    {
        if ( is_string( $value ) )
        {
            return self::shortenedString( $value );
        }
        elseif ( is_array( $value ) )
        {
            if ( count( $value ) == 0 )
                return 'array()';
            $a1 = array_slice( $value, 0, 1, true );
            $k1 = key( $a1 );
            $v1 = $a1[$k1];
            if ( is_string( $v1 ) )
                $v1 = self::shortenedString( $v1 );
            elseif ( is_array( $v1 ) )
                $v1 = 'array(...)';
            else
                $v1 = var_export( $v1, true );

            $a2 = false;
            if ( count( $value ) > 1 )
            {
                $a2 = array_slice( $value, -1, 1, true );
                $k2 = key( $a2 );
                $v2 = $a2[$k2];
                if ( is_string( $v2 ) )
                    $v2 = self::shortenedString( $v2 );
                elseif ( is_array( $v2 ) )
                    $v2 = 'array(...)';
                else
                    $v2 = var_export( $v2, true );
            }

            $text = 'array( ' . var_export( $k1, true ) . ' => ' . $v1;
            if ( $a2 !== false )
                $text .= ', ..., ' . var_export( $k2, true ) . ' => ' . $v2 . ' )';
            else
                $text .= ' )';
            return $text;
        }
        elseif ( is_object( $value ) )
        {
            return 'class ' . get_class( $value ) . '(...)';
        }

        return var_export( $value, true );
    }

    /**
     * Shortens the string $string and returns it. If the string is already short
     * enough it is returned as it was.
     *
     * @param string $string The string value which must be shortened.
     * @return string
     */
    private static function shortenedString( $string )
    {
        $string = preg_replace( "#\n|\r\n|\r#", " ", $string );
        if ( strlen( $string ) > 14 )
            return var_export( substr( $string, 0, 7 ), true ) . "..." . var_export( substr( $string, -7 ), true );
        else
            return var_export( $string, true );
    }
}
?>
