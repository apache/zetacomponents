<?php
/**
 * Builder interface for parameter matchers.
 */
interface ezcMockParametersMatchBuilder extends ezcMockMatchBuilder
{
    /**
     * Sets the parameters to match for, each parameter to this funtion will
     * be part of match. To perform specific matches or constraints create a
     * new ezcMockConstraint and use it for the parameter.
     * If the parameter value is not a constraint it will use the
     * ezcMockIsEqualConstraint for the value.
     *
     * Some examples:
     * <code>
     * // match first parameter with value 2
     * $b->with( 2 );
     * // match first parameter with value 'smock' and second identical to 42
     * $b->with( 'smock', new ezcMockIsIdenticalConstraint( 42 ) );
     * </code>
     *
     * @return ezcMockParametersMatchBuilder
     */
    public function with();

    /**
     * Sets a matcher which allows any kind of parameters.
     *
     * Some examples:
     * <code>
     * // match any number of parameters
     * $b->withAnyParamers();
     * </code>
     *
     * @return ezcMockAnyParametersMatchBuilder
     */
    public function withAnyParameters();
}
?>
