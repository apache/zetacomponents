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
 * Class defining an item in a feed.
 *
 * @package Feed
 * @version //autogentag//
 * @mainclass
 */
class ezcFeedItem extends ezcFeedNode
{
    /**
     * Holds the module meta data.
     *
     * @var array(string=>mixed)
     * @ignore
     */
    protected $moduleMetaData = array();

    /**
     * Constructs a new feed item object.
     *
     * @param ezcFeedProcessor $processor The processor used by the feed item
     */
    public function __construct( $processor )
    {
        parent::__construct( $processor );

        $modules = $this->feedProcessor->getModules();
        foreach ( $modules as $moduleName => $moduleObj )
        {
            $this->$moduleName = $this->feedProcessor->addItemModule( $moduleName, ezcFeed::getModule( $moduleName, $this->feedProcessor->getFeedType() ), $this );
        }
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
            case 'description': // required in RSS2
            case 'author':
            case 'category':
            case 'comments':
            case 'enclosure':
            case 'guid':
            case 'published': // pubDate in RSS2
            case 'source': // original rss source
                $this->feedProcessor->setFeedItemElement( $this, $property, $value );
                break;
        }

        $modules = $this->feedProcessor->getModules();
        foreach ( $modules as $moduleName => $moduleObj )
        {
            if ( $property == $moduleName )
            {
                $this->$moduleName = $value;
            }
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
            case 'description': // required in RSS2
            case 'author':
            case 'category':
            case 'comments':
            case 'enclosure':
            case 'guid':
            case 'published': // pubDate in RSS2
            case 'source': // original rss source
                return $this->feedProcessor->getFeedItemElement( $this, $property );

            default:
                throw new ezcBasePropertyNotFoundException( $property );
        }
    }

    public function setModuleMetaData( $moduleName, $moduleObj, $element, $value )
    {
        $value = $moduleObj->prepareMetaData( $element, $value );
        $this->moduleMetaData[$moduleName][$element] = $value;
    }

    public function getModuleMetaData( $module, $element )
    {
        if ( isset( $this->moduleMetaData[$module][$element] ) )
        {
            return $this->moduleMetaData[$module][$element];
        }
        return null;
    }

    public function getAllModuleMetaData( $module )
    {
        if ( isset( $this->moduleMetaData[$module] ) )
        {
            return $this->moduleMetaData[$module];
        }
        return array();
    }
}
?>
