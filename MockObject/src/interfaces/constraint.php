<?php
/**
 * Interface for constraints which are placed upon any value.
 *
 * The constraint can be used in method name matching and parameter value matching
 * to perform more advanced checking than simply matching two values with ==.
 *
 * A constraint must provides the following methods:
 * - evaluate() check if a given object meets the constraint, if it does
 *              not fail() can be called to create an exception.
 * - generateDescription() returns a description of the constraint.
 */
interface ezcMockConstraint extends ezcMockSelfDescribing
{
    /**
     * Evaluates the constraint for parameter $other. Returns true if the
     * constraint is met, false otherwise.
     *
     * @parameter mixed $other Value or object to evaluate.
     * @return bool
     */
    public function evaluate( $other );

    /**
     * Creates the appropriate exception for the constraint which can be caught
     * by the unit test system. This can be called if a call to evaluate() fails.
     *
     * @param mixed $other The value passed to evaluate() which failed the
     *                     constraint check.
     * @param string $description A string with extra description of what was
     *                            going on while the evaluation failed.
     * @throw ezcMockExpectationFailedException
     */
    public function fail( $other, $description );
}
?>
