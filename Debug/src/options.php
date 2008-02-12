<?php
/**
 * This file contains the ezcDebugOptions class.
 *
 * @package Debug
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Options class for ezcDebug.
 *
 * @property bool $stackTrace
 *           Determines if a stack trace is stored and displayed with every
 *           debug message by default. Default is false.
 * @property int $stackTraceDepth
 *           The number of levels to store for the stack trace. 0 means no
 *           limit and a complete stack trace will always be stored. Not that
 *           this might consume a large amount of memory. Default is 5.
 * @package Debug
 * @version //autogen//
 */
class ezcDebugOptions extends ezcBaseOptions
{
    /**
     * Properties.
     * 
     * @var array(string=>mixed)
     */
    protected $properties = array(
        'stackTrace'      => false,
        'stackTraceDepth' => 5,
    );

    /**
     * Property write access.
     * 
     * @param string $propertyName Name of the property.
     * @param mixed $propertyValue The value for the property.
     *
     * @throws ezcBasePropertyPermissionException
     *         If the property you try to access is read-only.
     * @throws ezcBasePropertyNotFoundException 
     *         If the the desired property is not found.
     * @ignore
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case 'stackTrace':
                if ( !is_bool( $propertyValue ) )
                {
                    throw new ezcBaseValueException(
                        $propertyName,
                        $propertyValue,
                        'bool'
                    );
                }
                break;
            case 'stackTraceDepth':
                if ( !is_int( $propertyValue ) || $propertyValue < 0 )
                {
                    throw new ezcBaseValueException(
                        $propertyName,
                        $propertyValue,
                        'int >= 0'
                    );
                }
                break;
            default:
                ezcBasePropertyNotFoundException( $propertyName );
        }
        $this->properties[$propertyName] = $propertyValue;
    }
}

?>
