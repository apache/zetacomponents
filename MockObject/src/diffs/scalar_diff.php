<?php
/**
 * Describes the difference between two scalar values.
 *
 * The diff output will display the expected value and the actual value
 * and also the numerical difference for numerical values.
 */
class ezcMockScalarDiff extends ezcMockDiff
{
    /**
     * Initialises with the expected scalar value and the actual scalar value.
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
     * Returns a string describing the difference between the expected and the
     * actual scalar value.
     */
    public function generateDifference()
    {
        if ( is_bool( $this->expected ) )
        {
            return $this->prefix . "expected bool <" . var_export( $this->expected, true ) . ">\n" .
                   $this->prefix . "got bool      <" . var_export( $this->actual, true ) . ">";
        }
        elseif ( is_int( $this->expected ) or
                 is_float( $this->expected ) )
        {
            $type = gettype( $this->expected );
            $expectedString = var_export( $this->expected, true );
            $actualString = var_export( $this->actual, true );
            $differenceString = var_export( $this->actual - $this->expected, true );

            $expectedLen = strlen( $expectedString );
            $actualLen = strlen( $actualString );
            $differenceLen = strlen( $differenceString );
            $maxLen = max( $expectedLen, $actualLen, $differenceLen );

            $expectedString = str_pad( $expectedString, $maxLen, " ", STR_PAD_LEFT );
            $differenceString = str_pad( $differenceString, $maxLen, " ", STR_PAD_LEFT );
            $actualString = str_pad( $actualString, $maxLen, " ", STR_PAD_LEFT );

            return $this->prefix . "expected {$type} <{$expectedString}>\n" .
                   $this->prefix . "difference" . str_repeat( " ", strlen( $type ) ) . "<{$differenceString}>\n" .
                   $this->prefix . "got {$type}      <{$actualString}>";
        }
    }
}
?>
