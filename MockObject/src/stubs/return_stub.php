<?php
/**
 * Stubs a method by returning a user-defined value.
 */
class ezcMockReturnStub implements ezcMockStub
{
    private $value;

    /**
     * Initialises with the value to return from stubbed method.
     *
     * @param mixed $value The return value.
     */
    public function __construct( $value )
    {
        $this->value = $value;
    }

    /**
     * Returns the value specified in the constructor.
     */
    public function invoke( ezcMockInvocation $invocation )
    {
        return $this->value;
    }

    public function generateDescription()
    {
        return "return the user-specified value <" . var_export( $this->value ) . ">";
    }
}
?>
