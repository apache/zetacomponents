<?php
/**
 * Describes the difference between two object by comparing the properties.
 *
 * The diff output will display all properties which has a different value than the
 * expected property.
 */
class ezcMockObjectDiff extends ezcMockDiff
{
    /**
     * Initialises with the expected object and the actual object.
     *
     * @param string $expected Expected object retrieved.
     * @param string $actual Actual object retrieved.
     * @param string $prefix A string which is prefixed on all returned lines
     *                       in the difference output.
     */
    public function __construct( $expected, $actual, $prefix = false )
    {
        parent::__construct( $expected, $actual, $prefix );
    }

    /**
     * Returns a string describing the difference between the expected and the
     * actual object.
     *
     * @note Diffing is only done for one level.
     */
    public function generateDifference()
    {
        $expectedClass = get_class( $this->expected );
        $actualClass = get_class( $this->actual );

        if ( $expectedClass !== $actualClass )
        {
            return $this->prefix . "Expected class <{$expectedClass}>\n" .
                   $this->prefix . "Got class      <{$actualClass}>";
        }
        else
        {
            $diff = "In object of class <{$expectedClass}>:\n";

            $expectedReflection = new ReflectionClass( $expectedClass );
            $actualReflection = new ReflectionClass( $actualClass );
            $i = 0;
            foreach( $expectedReflection->getProperties() as $expectedProperty )
            {
                // We cannot diff private and protected
                if ( $expectedProperty->isPrivate() or
                     $expectedProperty->isProtected() )
                    continue;

                $actualProperty = $actualReflection->getProperty( $expectedProperty->getName() );
                $expectedValue = $expectedProperty->getValue( $this->expected );
                $actualValue = $actualProperty->getValue( $this->actual );

                if ( $expectedValue !== $actualValue )
                {
                    if ( $i > 0 )
                        $diff .= "\n";
                    ++$i;

                    $expectedType = gettype( $expectedValue );
                    $actualType = gettype( $actualValue );
                    if ( $expectedType !== $actualType )
                    {
                        $diffObject = new ezcMockTypeDiff( $expectedValue, $actualValue, $this->prefix . 'property <' . $expectedProperty->getName() . '>: ' );
                        $diff .= $diffObject->generateDifference();
                    }
                    elseif ( is_object( $expectedValue ) )
                    {
                        if ( get_class( $expectedValue ) !== get_class( $actualValue ) )
                        {
                            $diffObject = new ezcMockTypeDiff( $expectedValue, $actualValue, $this->prefix . 'property <' . $expectedProperty->getName() . '>: ' );
                            $diff .= $diffObject->generateDifference();
                        }
                        else
                        {
                            $diff .= "property <" . $expectedProperty->getName() . "> contains object <" . get_class( $expectedValue ) . "> with different properties";
                        }
                    }
                    else
                    {
                        $diffObject = ezcMockDiff::diffIdentical( $expectedValue, $actualValue, $this->prefix . 'property <' . $expectedProperty->getName() . '>: ' );
                        $diff .= $diffObject->generateDifference();
                    }
                }
            }
            return $diff;
        }
    }
}
?>
