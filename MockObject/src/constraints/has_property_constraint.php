<?php

require_once 'PHPUnit2/Util/Filter.php';
PHPUnit2_Util_Filter::addFileToFilter(__FILE__);

/**
 * Constraint which checks if a certain value is found in the input property.
 *
 * Uses in_property() to check if the value is found in the input property, if not
 * found the evaluaton fails.
 *
 * The property value is passed in the constructor and the optional constraint
 * check can be set with the that() method.
 */
class ezcMockHasPropertyConstraint implements ezcMockConstraint
{
    /**
     * The property value which should be found in among the input property.
     * @var string
     */
    private $property;

    /**
     * The value constraint to check the property value with, if set to null no
     * check is done. The constraint is set with the that() method.
     * @var ezcMockConstraint
     */
    private $valueConstraint;

    /**
     * Controls whether the value constraint failed its evalution or not.
     * @var bool
     */
    private $valueConstraintFailed;

    /**
     * The value of the property fetched in evaluate().
     * @var mixed
     */

    /**
     * Initialise constraint with property property to find in input property.
     */
    public function __construct( $property )
    {
        $this->property = $property;
        $this->valueConstraint = null;
        $this->valueConstraintFailed = false;
        $this->propertyValue = null;
    }

    /**
     * Sets the expected constraint on the property value.
     *
     * @param ezcMockConstraint $valueConstraint The constraint object to check
     *                                           the property value with.
     * @return ezcMockHasPropertyConstraint
     */
    public function that( ezcMockConstraint $valueConstraint )
    {
        $this->valueConstraint = $valueConstraint;
        $this->valueConstraintFailed = false;
        $this->propertyValue = null;
        return $this;
    }

    public function generateDescription()
    {
        $text = "contains property <" . var_export( $this->property, true ) . ">";
        if ( $this->valueConstraint !== null )
            $text .= " that " . $this->valueConstraint->generateDescription();
        return $text;
    }

    public function evaluate( $other )
    {
        if ( !is_object( $other ) )
            throw new Exception( __CLASS__ . " can only evaluate objects, not " . gettype( $other ) );

        $property = $this->property;
        if ( !isset( $other->$property ) )
            return false;

        // If we have a constraint we fetch the property value and check that
        // the constraint is met for it.
        if ( $this->valueConstraint !== null )
        {
            $this->propertyValue = $other->$property;
            $result = $this->valueConstraint->evaluate( $this->propertyValue );
            if ( !$result )
                $this->valueConstraintFailed = true;
            return $result;
        }

        return true;
    }

    public function fail( $other, $description )
    {
        if ( $this->valueConstraintFailed )
        {
            $this->valueConstraint->fail( $this->propertyValue,
                                          $description . "\n" .
                                          "expected property <" . var_export( $this->property, true ) . "> from object of class <" . get_class( $other ) . "> that " );
        }
        else
        {
            throw new ezcMockExpectationFailedException( $description . "\n" .
                                                         "expected property <" . var_export( $this->property, true ) . "> was not found in object of class <" . get_class( $other ) . ">" );
        }
    }
}
?>
