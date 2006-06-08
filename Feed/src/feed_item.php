<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Feed
 */
/**
 * @package Translation
 * @version //autogentag//
 */
class ezcFeedItem
{
    public $feedProcessor;
    private $metaData = array();
    public $moduleMetaData = array();

    public function __construct( $processor )
    {
        $this->feedProcessor = $processor;

        $modules = $this->feedProcessor->getModules();
        foreach ( $modules as $moduleName => $moduleObj )
        {
            $this->$moduleName = $this->feedProcessor->addItemModule( $moduleName, ezcFeed::getModule( $moduleName, $this->feedType ), $this );
        }
    }
    
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
                break;

            default:
                return false;
        }
    }

    /**
     * Returns new item for this feed
     *
     * @return ezcFeedItem
     */
    public function newItem()
    {
        $item = new ezcFeedItem();
        $this->items[] = $item;
        return $item;
    }

    public function setMetaData( $element, $value )
    {
        $this->metaData[$element] = $value;
    }

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

    public function setModuleMetaData( $moduleName, $moduleObj, $element, $value )
    {
        $value = $moduleObj->prepareMetaData( $element, $value );
        $this->moduleMetaData[$moduleName][$element] = $value;
    }

    public function getModuleMetaData( $module )
    {
        if ( isset( $this->moduleMetaData[$module] ) )
        {
            return $this->moduleMetaData[$module];
        }
        return array();
    }

    public function getMetaData( $element )
    {
        if ( isset( $this->metaData[$element] ) )
        {
            return $this->metaData[$element];
        }
        return NULL;
    }
}
?>
