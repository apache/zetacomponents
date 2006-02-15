<?php
/**
 * Constraint which checks if a value is of a specified type.
 *
 * The expected value is passed in the constructor.
 */
class ezcMockIsTypeConstraint implements ezcMockConstraint
{
    /**
     * The expected type.
     * @var string
     */
    private $type;

    /**
     * Initialise constraint with type to check for.
     */
    public function __construct( $type )
    {
        $this->type = $type;
        switch ( $type )
        {
            case 'integer':
            case 'int':
            case 'float':
            case 'string':
            case 'boolean':
            case 'bool':
            case 'null':
            case 'array':
            case 'object':
                break;
            default:
                throw new Exception( "Type specified for ezcMockIsTypeConstraint <{$this->type}> is not a valid type." );
        }
    }

    public function generateDescription()
    {
        return "is type <{$this->type}>";
    }

    /**
     * @todo Use specific exception.
     */
    public function evaluate( $other )
    {
        switch ( $this->type )
        {
            case 'integer':
            case 'int':
                return is_integer( $other );
            case 'float':
                return is_float( $other );
            case 'string':
                return is_string( $other );
            case 'boolean':
            case 'bool':
                return is_bool( $other );
            case 'null':
                return is_null( $other );
            case 'array':
                return is_array( $other );
            case 'object':
                return is_object( $other );
            default:
                throw new Exception( "Unknown type in ezcMockIsTypeConstraint, happened because of type <{$this->type}>" );
        }
    }

    public function fail( $other, $description )
    {
        switch ( $this->type )
        {
            case 'integer':
            case 'int':
                $expected = 1;
                break;
            case 'float':
                $expected = 1.1;
                break;
            case 'string':
                $expected = 'str';
                break;
            case 'boolean':
            case 'bool':
                $expected = true;
                break;
            case 'null':
                $expected = null;
                break;
            case 'array':
                $expected = array( 1 );
                break;
            case 'object':
                $expected = new Exception();
                break;
            default:
                throw new Exception( "Unknown type in ezcMockIsTypeConstraint, happened because of type <{$this->type}>" );
        }
        throw new ezcMockExpectationFailedException( $description,
                                                     new ezcMockTypeDiff( $expected, $other, false, false ) );
    }
}
?>
