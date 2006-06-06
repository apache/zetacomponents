<?php
/**
 * File containing the ezcTemplateVariableWrongDirectionException class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception for problems with direction of template variables.
 * @package Template
 * @version //autogen//
 */
class ezcTemplateVariableWrongDirectionException extends Exception
{
    /**
     * Initialises the exception with the name, expected and actual direction
     * value. The error text is automatically generated.
     *
     * @param string $name The name of the variable which has the wrong direction.
     * @param int $actual The actual direction value.
     * @param int $expected The expected direction value.
     */
    public function __construct( $name, $expected, $actual )
    {
        $expectedText = self::directionName( $expected );
        $actualText = self::directionName( $actual );
        parent::__construct( "Wrong direction for variable: <{$name}>, expected: <${expectedText}(${expected})>, got: <${actualText}(${actual})>" );
    }

    public static function directionName( $dir )
    {
        if ( !is_int( $dir ) )
            return 'UNKNOWN';
        switch ( $dir )
        {
            case ezcTemplateVariable::DIR_IN:
                return 'DIR_IN';
            case ezcTemplateVariable::DIR_OUT:
                return 'DIR_OUT';
            case ezcTemplateVariable::DIR_NONE:
                return 'DIR_NONE';
            default:
                return 'UNKNOWN';
        }
    }

}
?>
