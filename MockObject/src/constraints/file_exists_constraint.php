<?php
/**
 * Constraint which checks if a given file exists.
 *
 * The file path to check is passed as $other in evaluate().
 */
class ezcMockFileExistsConstraint implements PHPUnit2_Framework_Constraint
{
    /**
     * Initialise constraint with value to match.
     */
    public function __construct()
    {
    }

    public function toString()
    {
        return "file exists";
    }

    public function evaluate( $other )
    {
        return file_exists( $other );
    }

    public function fail( $other, $description )
    {
        throw new ezcMockExpectationFailedException( $description . "\n" .
                                                     "file <$other> does not exist" );
    }
}
?>
