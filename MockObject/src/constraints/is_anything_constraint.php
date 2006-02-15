<?php
/**
 * Constraint which accepts any input value.
 *
 */
class ezcMockIsAnythingConstraint implements ezcMockConstraint
{
    /**
     * Initialise constraint.
     */
    public function __construct()
    {
    }

    public function generateDescription()
    {
        return "can be anything";
    }

    public function evaluate( $other )
    {
        return true;
    }

    public function fail( $other, $description )
    {
        // this can never fail, will not be called
    }
}
?>
