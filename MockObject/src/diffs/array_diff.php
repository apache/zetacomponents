<?php
/**
 * Describes the difference between two arrays by comparing the values of the array keys.
 *
 * The diff output will display all keys which has a different value than the
 * expected array, it will also display keys which only appears in expected
 * array and those only in the actual array.
 */
class ezcMockArrayDiff extends ezcMockDiff
{
    /**
     * Initialises with the expected array and the actual array.
     *
     * @param string $expected Expected array retrieved.
     * @param string $actual Actual array retrieved.
     * @param string $prefix A string which is prefixed on all returned lines
     *                       in the difference output.
     */
    public function __construct( $expected, $actual, $prefix = false )
    {
        parent::__construct( $expected, $actual, $prefix );
    }

    /**
     * Returns a string describing the difference between the expected and the
     * actual array.
     *
     * @note Diffing is only done for one level.
     */
    public function generateDifference()
    {
        $expectedOnly = array();
        $actualOnly = array();
        $diff = '';
        foreach( $this->expected as $expectedKey => $expectedValue )
        {
            if ( !array_key_exists( $expectedKey, $this->actual ) )
            {
                $expectedOnly[] = $expectedKey;
                continue;
            }
            if ( $expectedValue === $this->actual[$expectedKey] )
                continue;
            $diffObject = ezcMockDiff::diffIdentical( $expectedValue, $this->actual[$expectedKey],
                                                      $this->prefix . "array key <{$expectedKey}>: " );
            $diff .= $diffObject->generateDifference() . "\n";
        }

        foreach( $this->actual as $actualKey => $actualValue )
        {
            if ( !array_key_exists( $actualKey, $this->expected ) )
            {
                $actualOnly[] = $actualKey;
                continue;
            }
        }

        foreach( $expectedOnly as $expectedKey )
        {
            $expectedValue = $this->expected[$expectedKey];
            $diff .= "array key <{$expectedKey}>: only in expected <{$expectedValue}>\n";
        }

        foreach( $actualOnly as $actualKey )
        {
            $actualValue = $this->actual[$actualKey];
            $diff .= "array key <{$actualKey}>: only in actual <{$actualValue}>\n";
        }

        return $diff;
    }
}
?>
