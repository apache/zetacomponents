<?php
/**
 * Describes the difference between two string values.
 *
 * The diff output will display the expected string and the actual string and
 * will highlight the characters which are different.
 */
class ezcMockStringDiff extends ezcMockDiff
{
    /**
     * Initialises with the expected string and the actual string.
     *
     * @param string $expected Expected string retrieved.
     * @param string $actual Actual string retrieved.
     * @param string $prefix A string which is prefixed on all returned lines
     *                       in the difference output.
     */
    public function __construct( $expected, $actual, $prefix = false )
    {
        parent::__construct( $expected, $actual, $prefix );
    }

    /**
     * Returns a string describing the difference between the expected and the
     * actual string value.
     */
    public function generateDifference()
    {
        $expected = (string)$this->expected;
        $actual = (string)$this->actual;

        $expectedLen = strlen( $expected );
        $actualLen = strlen( $actual );
        $minLen = min( $expectedLen, $actualLen );
        $maxLen = max( $expectedLen, $actualLen );

        for ( $i = 0; $i < $minLen; ++$i )
        {
            if ( $expected[$i] != $actual[$i] )
                break;
        }
        $startPos = $i;

        $endPos = $minLen;
        if ( $minLen > 0 )
        {
            for ( $i = $minLen - 1; $i > $startPos; --$i )
            {
                if ( $expected[$i] != $actual[$i] )
                    break;
            }
            $endPos = $i + 1;
        }

        return $this->prefix . "expected string <" . $expected . ">\n" .
               $this->prefix . "difference      <" . str_repeat( " ", $startPos ) . str_repeat( "x", $endPos - $startPos ) . str_repeat( "?", $maxLen - $minLen ) . ">\n" .
               $this->prefix . "got string      <" . $actual . ">";

    }
}
?>
