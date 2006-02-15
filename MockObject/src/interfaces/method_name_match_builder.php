<?php
/**
 * Builder interface for matcher of method names.
 */
interface ezcMockMethodNameMatchBuilder extends ezcMockParametersMatchBuilder
{
    /**
     * Adds a new method name match and returns the parameter match object for
     * further matching possibilities.
     *
     * @param ezcMockConstraint $name Constraint for matching method, if a
     *                                string is passed it will use the
     *                                ezcMockIsEqualConstraint.
     * @return ezcMockParametersMatchBuilder
     */
    public function method( $name );

}
?>
