<?php
/**
 * File containing the ezcFeedItem class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Container for item data.
 *
 * @package Feed
 * @version //autogentag//
 */
class ezcFeedItem extends ezcFeedElement
{
    /**
     * Constructs a new ezcFeedElement object.
     *
     * @param array(string=>mixed) $schema The sub-schema that defines this element
     */
    public function __construct( array $schema )
    {
        $this->schema = $schema;
    }

    /**
     * Sets the property $name to $value.
     *
     * @param string $name The property name
     * @param mixed $value The property value
     * @ignore
     */
    public function __set( $name, $value )
    {
        parent::__set( $name, $value );
    }

    /**
     * Returns the value of property $name.
     *
     * @param string $name The property name
     * @return mixed
     * @ignore
     */
    public function __get( $name )
    {
        return parent::__get( $name );
    }

    /**
     * Returns if the property $name is set.
     *
     * @param string $name The property name
     * @return bool
     * @ignore
     */
    public function __isset( $name )
    {
        return parent::__isset( $name );
    }

    /**
     * Returns the text stored in the feed element.
     *
     * @return string
     * @ignore
     */
    public function __toString()
    {
        return parent::__toString();
    }
}
?>
