<?php
/**
 * File containing the ezcFeedNode class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Class defining a node in a feed.
 *
 * @package Feed
 * @version //autogentag//
 */
abstract class ezcFeedNode
{
    /**
     * Holds the feed processor.
     *
     * @var ezcFeedProcessor
     * @ignore
     */
    public $feedProcessor;

    /**
     * Holds the meta data.
     *
     * @var array(string=>mixed)
     * @ignore
     */
    protected $metaData = array();

    /**
     * Constructs a new feed node object.
     *
     * @param ezcFeedProcessor $processor The processor used by the feed node
     */
    public function __construct( $processor )
    {
        $this->feedProcessor = $processor;
    }

    /**
     * Sets the meta data of node element $element to $value.
     *
     * @throws ezcFeedOnlyOneValueAllowedException
     *         If $value is an array.
     *
     * @param string $element The name of the node element
     * @param mixed $value The new value for $element
     */
    public function setMetaData( $element, $value )
    {
        if ( is_array( $value ) )
        {
            throw new ezcFeedOnlyOneValueAllowedException( $element );
        }
        $this->metaData[$element] = $value;
    }

    public function unsetMetaData( $element )
    {
        unset( $this->metaData[$element] );
    }

    /**
     * Adds $value to the array of meta data associated with the node element
     * name $element. If $value is an array it is assigned directly to the
     * meta data, clearing old values.
     *
     * @param string $element The node element name
     * @param mixed $value The new value for $element
     */
    public function setMetaArrayData( $element, $value )
    {
        if ( is_array( $value ) )
        {
            $this->metaData[$element] = $value;
        }
        else
        {
            if ( !isset( $this->metaData[$element] ) )
            {
                $this->metaData[$element] = array();
            }
            $this->metaData[$element][] = $value;
        }
    }

    public function getMetaData( $element )
    {
        if ( isset( $this->metaData[$element] ) )
        {
            return $this->metaData[$element];
        }
        return null;
    }
}
?>
