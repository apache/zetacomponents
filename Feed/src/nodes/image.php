<?php
/**
 * File containing the ezcFeedItem class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Class defining an image node in a feed.
 *
 * @package Feed
 * @version //autogentag//
 */
class ezcFeedImage extends ezcFeedNode
{
    /**
     * Constructs a new feed image object.
     *
     * @param ezcFeedProcessor $processor The processor used by the feed image
     */
    public function __construct( $processor )
    {
        parent::__construct( $processor );
    }

    /**
     * Sets the property $property to $value.
     *
     * @param string $property The property name
     * @param mixed $value The property value
     * @ignore
     */
    public function __set( $property, $value )
    {
        switch ( $property )
        {
            case 'title': // required in RSS2
            case 'link': // required in RSS2
            case 'url': // required in RSS2
            case 'description':
            case 'width':
            case 'height':
                $this->feedProcessor->setFeedImageElement( $property, $value );
                break;
        }
    }

    /**
     * Returns the value of property $property.
     *
     * @throws ezcBasePropertyNotFoundException
     *         If the property $property does not exist.
     *
     * @param string $property The property name
     * @return mixed
     * @ignore
     */
    public function __get( $property )
    {
        switch ( $property )
        {
            case 'title': // required in RSS2
            case 'link': // required in RSS2
            case 'url': // required in RSS2
            case 'description':
            case 'width':
            case 'height':
                return $this->feedProcessor->getFeedImageElement( $property );

            default:
                throw new ezcBasePropertyNotFoundException( $property );
        }
    }
}
?>
