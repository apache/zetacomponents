<?php
/**
 * Describes the difference in type between two values.
 *
 * The diff output will display the type of the expected value and the actual
 * value.
 */
class ezcMockTypeDiff extends ezcMockDiff
{
    /**
     * Initialises with the expected object and the object value.
     *
     * @param string $expected Expected scalar value retrieved.
     * @param string $actual Actual scalar value retrieved.
     * @param string $prefix A string which is prefixed on all returned lines
     *                       in the difference output.
     */
    public function __construct( $expected, $actual, $prefix = false )
    {
        parent::__construct( $expected, $actual, $prefix );
    }

    /**
     * Returns a string describing the type difference between the expected
     * and the actual value.
     */
    public function generateDifference()
    {
        $expectedType = gettype( $this->expected );
        $actualType = gettype( $this->actual );

        $expectedDiffLen = strlen( $expectedType ) - strlen( $actualType );
        $actualDiffLen = -$expectedDiffLen;
        if ( $expectedDiffLen > 0 )
            $expectedType .= str_repeat( " ", $expectedDiffLen );
        if ( $actualDiffLen > 0 )
            $actualType .= str_repeat( " ", $actualDiffLen );

        $expectedValue = '';
        $actualValue = '';

        if ( is_string( $this->expected ) or
             is_bool( $this->expected ) or
             is_int( $this->expected ) or
             is_float( $this->expected ) )
            $expectedValue = '<' . var_export( $this->expected, true ) . '>';
        elseif ( is_object( $this->expected ) )
            $expectedValue = '<' . get_class( $this->expected ) . '>';

        if ( is_string( $this->actual ) or
             is_bool( $this->actual ) or
             is_int( $this->actual ) or
             is_float( $this->actual ) )
            $actualValue = '<' . var_export( $this->actual, true ) . '>';
        elseif ( is_object( $this->actual ) )
            $actualValue = '<' . get_class( $this->actual ) . '>';

        return $this->prefix . "expected {$expectedType} {$expectedValue}\n" .
            $this->prefix . "got {$actualType}      {$actualValue}";
    }
}
?>
