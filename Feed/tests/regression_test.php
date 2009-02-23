<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Feed
 * @subpackage Tests
 */

/**
 * @package Feed
 * @subpackage Tests
 */
class ezcFeedRegressionTest extends ezcTestRegressionTest
{
    protected function createFeed( $type, $data )
    {
        $feed = new ezcFeed( $type );
        $supportedModules = ezcFeed::getSupportedModules();
        if ( is_array( $data ) )
        {
            foreach ( $data as $property => $value )
            {
                if ( is_array( $value ) )
                {
                    foreach ( $value as $val )
                    {
                        if ( isset( $supportedModules[$property] ) )
                        {
                            $element = $feed->addModule( $property );
                        }
                        else
                        {
                            $element = $feed->add( $property );
                        }
                        if ( is_array( $val ) )
                        {
                            foreach ( $val as $subKey => $subValue )
                            {
                                if ( $subKey === '#' )
                                {
                                    $element->set( $subValue );
                                }
                                else if ( $subKey === 'MULTI' )
                                {
                                    $values = array();
                                    foreach ( $subValue as $multi )
                                    {
                                        foreach ( $multi as $subSubKey => $subSubValue )
                                        {
                                            if ( isset( $supportedModules[$subSubKey] ) )
                                            {
                                                $subElement = $element->addModule( $subSubKey );
                                            }
                                            else
                                            {
                                                if ( $property === 'skipDays' )
                                                {
                                                    $values[] = $subSubValue;
                                                    $element->days = $values;
                                                }
                                                else if ( $property === 'skipHours' )
                                                {
                                                    $values[] = $subSubValue;
                                                    $element->hours = $values;
                                                }
                                                else
                                                {
                                                    $subElement = $element->add( $subSubKey );
                                                }
                                            }

                                            if ( $property !== 'skipDays'
                                                 && $property !== 'skipHours' )
                                            {
                                                $subElement->set( $subSubValue );
                                            }
                                        }
                                    }
                                }
                                else
                                {
                                    if ( is_array( $subValue ) )
                                    {
                                        if ( count( $subValue ) === 0 || !isset( $subValue[0] ) )
                                        {
                                            if ( isset( $supportedModules[$subKey] ) )
                                            {
                                                $subElement = $element->addModule( $subKey );
                                            }
                                            else
                                            {
                                                $subElement = $element->add( $subKey );
                                            }
                                        }

                                        foreach ( $subValue as $subSubKey => $subSubValue )
                                        {
                                            if ( $subSubKey === '#' )
                                            {
                                                $subElement->set( $subSubValue );
                                            }
                                            else
                                            {
                                                if ( is_array( $subSubValue ) )
                                                {
                                                    if ( isset( $supportedModules[$subKey] ) )
                                                    {
                                                        $subElement = $element->addModule( $subKey );
                                                    }
                                                    else
                                                    {
                                                        $subElement = $element->add( $subKey );
                                                    }
                                                    foreach ( $subSubValue as $subSubSubKey => $subSubSubValue )
                                                    {
                                                        if ( $subSubSubKey === '#' )
                                                        {
                                                            $subElement->set( $subSubSubValue );
                                                        }
                                                        else
                                                        {
                                                            if ( is_array( $subSubSubValue ) )
                                                            {
                                                                foreach ( $subSubSubValue as $subSubSubSubKey => $subSubSubSubValue )
                                                                {
                                                                    $subSubElement = $subElement->add( $subSubSubKey );
                                                                    foreach ( $subSubSubSubValue as $subSubSubSubSubKey => $subSubSubSubSubValue )
                                                                    {
                                                                        if ( $subSubSubSubSubKey === '#' )
                                                                        {
                                                                            $subSubElement->set( $subSubSubSubSubValue );
                                                                        }
                                                                        else
                                                                        {
                                                                            $subSubElement->$subSubSubSubSubKey = $subSubSubSubSubValue;
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            else
                                                            {
                                                                $subElement->$subSubSubKey = $subSubSubValue;
                                                            }
                                                        }
                                                    }
                                                }
                                                else
                                                {
                                                    $subElement->$subSubKey = $subSubValue;
                                                }
                                            }
                                        }
                                    }
                                    else
                                    {
                                        $element->$subKey = $subValue;
                                    }
                                }
                            }
                        }
                        else
                        {
                            $element->set( $val );
                        }
                    }
                }
                else
                {
                    $feed->$property = $value;
                }
            }
        }

        return $feed;
    }
}
?>
