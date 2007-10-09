<?php
/**
 * File containing the ezcFeedProcessor class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Base class for all feed processors.
 *
 * Currently implemented for these feed types:
 *  - RSS1 ({@link ezcFeedRss1})
 *  - RSS2 ({@link ezcFeedRss2})
 *  - ATOM ({@link ezcFeedAtom})
 *
 * @package Feed
 * @version //autogentag//
 */
abstract class ezcFeedProcessor
{
    /**
     * Holds the names of the supported modules by this processor. Child classes
     * must populate this array with the modules that they support.
     *
     * @var array(string)
     */
    protected $supportedModules = array();

    /**
     * Holds the feed type (eg. 'rss2').
     *
     * @var string
     * @ignore
     */
    protected $feedType;

    /**
     * A list of modules contained in this processor.
     *
     * @var array(string=>ezcFeedModuleData)
     * @ignore
     */
    protected $modules = array();

    /**
     * The meta data for the modules.
     *
     * The format of this array is:
     * <code>
     *   array( module_name => array( element_name => element_value ) );
     * </code>
     *
     * Example:
     * <code>
     *   array( 'DublinCore' => array( 'title' => 'News', 'format' = 'text/plain' ) );
     * </code>
     *
     * @var array(string=>array)
     * @ignore
     */
    protected $moduleMetaData = array();

    /**
     * Holds the XML document which is being generated.
     *
     * @var DOMDocument
     * @ignore
     */
    protected $xml;

    /**
     * Returns the type of this processor (eg. 'rss1').
     *
     * @return string
     */
    public function getFeedType()
    {
        return $this->feedType;
    }

    /**
     * Returns true if $moduleName is supported by this processor, false otherwise.
     *
     * @var string $moduleName The module name (eg. 'DublinCore')
     * @return bool
     */
    public function isModuleSupported( $moduleName )
    {
        return in_array( $moduleName, $this->supportedModules );
    }

    /**
     * Adds a new module to the feed processor.
     *
     * It is called by the {@link ezcFeed::addModule()} method.
     *
     * @throws ezcFeedUnsupportedModuleException
     *         If the module is not supported by this feed processor.
     *
     * @param string $moduleName The type of the module
     * @param ezcFeedModule $moduleObj The instance of the module
     * @return ezcFeedModuleData
     */
    public function addModule( $moduleName, ezcFeedModule $moduleObj )
    {
        if ( !$this->isModuleSupported( $moduleName ) )
        {
            throw new ezcFeedUnsupportedModuleException( $moduleName );
        }

        $this->modules[$moduleName] = new ezcFeedModuleData( $moduleName, $moduleObj, $this );
        return $this->modules[$moduleName];
    }

    /**
     * Adds a new module named $moduleName to the feed processor in $item.
     *
     * @throws ezcFeedUnsupportedModuleException
     *         If the module is not supported by this feed processor.
     *
     * @param string $moduleName The type of the module
     * @param ezcFeedModule $moduleObj The instance of the module
     * @param ezcFeedItem $item The instance of the feed item
     * @return ezcFeedItemModuleData
     */
    public function addItemModule( $moduleName, $moduleObj, $item )
    {
        if ( !$this->isModuleSupported( $moduleName ) )
        {
            throw new ezcFeedUnsupportedModuleException( $moduleName );
        }

        return new ezcFeedItemModuleData( $moduleName, $moduleObj, $item );
    }

    /**
     * Returns all the meta data for the module $moduleName.
     *
     * The format of the returned array is:
     * <code>
     *   array( element_name => element_value );
     * </code>
     *
     * Example:
     * <code>
     *   array( 'title' => 'News', 'format' = 'text/plain' );
     * </code>
     *
     * @param string $moduleName The type of the module
     * @return array(string=>mixed)
     */
    public function getAllModuleMetaData( $moduleName )
    {
        if ( isset( $this->moduleMetaData[$moduleName] ) )
        {
            return $this->moduleMetaData[$moduleName];
        }
        return array();
    }

    /**
     * Returns the meta data value of the element $element from the module
     * $moduleName.
     *
     * @param string $moduleName The type of the module
     * @param ezcFeedModule $moduleObj The module object
     * @param string $element The element in the module
     * @return mixed
     */
    public function getModuleMetaData( $moduleName, $moduleObj, $element )
    {
        if ( isset( $this->moduleMetaData[$moduleName][$element] ) )
        {
            return $this->moduleMetaData[$moduleName][$element];
        }
        return null;
    }

    /**
     * Returns the meta data value of the provided element in the module
     * $moduleName of the item $item.
     *
     * @param string $moduleName The type of the module
     * @param ezcFeedModule $moduleObj The module object
     * @param ezcFeedItem $item The feed item object
     * @param string $element The element in the module
     * @return mixed
     */
    public function getModuleItemData( $moduleName, $moduleObj, ezcFeedItem $item, $element )
    {
        return $item->getModuleMetaData( $moduleName, $element );
    }

    /**
     * Sets the meta data value for the element $element of the module
     * $moduleName to $value.
     *
     * @param string $moduleName The type of the module
     * @param ezcFeedModule $moduleObj The module object
     * @param ezcFeedItem $item The feed item object
     * @param string $element The element in the module
     * @return mixed
     */
    public function setModuleMetaData( $moduleName, $moduleObj, $element, $value )
    {
        $value = $moduleObj->prepareMetaData( $element, $value );
        $this->moduleMetaData[$moduleName][$element] = $value;
    }

    public function setModuleItemData( $moduleName, $moduleObj, $item, $element, $value )
    {
        $value = $moduleObj->prepareMetaData( $element, $value );
        $item->setModuleMetaData( $moduleName, $moduleObj, $element, $value );
    }

    /**
     * Returns the list of supported modules by this processor.
     *
     * @return array(string)
     */
    public function getSupportedModules()
    {
        return $this->supportedModules;
    }

    /**
     * Returns the modules contained in this processor.
     *
     * @return array(string=>ezcFeedModuleData)
     */
    public function getModules()
    {
        return $this->modules;
    }

    /**
     * Ensures the correct setting of element $element to $value for feed
     * processor $feed.
     *
     * This hook is called before calling setMetaData() with the $element and $value
     * arguments for the feed processor $feed.
     *
     * @param ezcFeedProcessor $feed The feed processor
     * @param string $element The name of the element to set
     * @param mixed $value The new value for $element
     */
    public function processModuleFeedSetHook( ezcFeedProcessor $feed, $element, $value )
    {
        foreach ( $this->modules as $moduleName => $moduleDescription )
        {
            $hookResult = $moduleDescription->moduleObj->feedMetaSetHook( $element, $value );
            if ( $hookResult === true )
            {
                $feed->setModuleMetaData( $moduleName, $element, $value );
            }
        }
    }

    /**
     * Ensures the correct generation of feed element $element with value
     * $value. Returns true if setting $element is allowed, false otherwise.
     *
     * This hook is called before calling generateMetaData() with the normalized
     * name of $element and (eventually prepared) value $value. It is called in the
     * generate() method of the processor implementation.
     *
     * @param string $element The name of the element to set
     * @param mixed $value The new value for $element
     * @return bool
     */
    public function processModuleFeedGenerateHook( $element, $value )
    {
        foreach ( $this->modules as $moduleName => $moduleDescription )
        {
            $hookResult = $moduleDescription->moduleObj->feedMetaGenerateHook( $this->getAllModuleMetaData( $moduleName ), $element, $value );
            if ( $hookResult === false )
            {
                return false;
            }
        }
        return true;
    }

    /**
     * Ensures the correct setting of element $element to $value for feed item
     * $item.
     *
     * This hook is called before calling setMetaData() with the $element and $value
     * arguments for the feed item $item.
     *
     * @param ezcFeedItem $feed The feed item object
     * @param string $element The name of the element to set
     * @param mixed $value The new value for $element
     */
    public function processModuleItemSetHook( ezcFeedItem $item, $element, $value )
    {
        foreach ( $this->modules as $moduleName => $moduleDescription )
        {
            $hookResult = $moduleDescription->moduleObj->feedItemSetHook( $element, $value );
            if ( $hookResult === true )
            {
                $this->setModuleItemData( $moduleName, $moduleDescription->moduleObj, $item, $element, $value );
            }
        }
    }

    /**
     * Ensures the correct generation of feed element $element with value
     * $value in item $item. Returns true if setting $element is allowed,
     * false otherwise.
     *
     * This hook is called before calling generateItemData() with the normalized
     * name of $element and (eventually prepared) value $value. It is called in the
     * generate() method of the processor implementation.
     *
     * @param ezcFeedItem $item The feed item object
     * @param string $element The name of the element to set
     * @param mixed $value The new value for $element
     * @return bool
     */
    public function processModuleItemGenerateHook( ezcFeedItem $item, $element, $value )
    {
        foreach ( $this->modules as $moduleName => $moduleDescription )
        {
            $hookResult = $moduleDescription->moduleObj->feedItemGenerateHook( $item->getAllModuleMetaData( $moduleName ), $element, $value );
            if ( $hookResult === false )
            {
                return false;
            }
        }
        return true;
    }

    /**
     * Sets the value of the feed element $element to $value.
     *
     * The hook {@link self::processModuleFeedSetHook()} can be used in the
     * implementation before setting $element.
     *
     * @param string $element The feed element
     * @param mixed $value The new value of $element
     */
    abstract public function setFeedElement( $element, $value );

    /**
     * Sets the value of the feed element $element of feed item $item to $value.
     *
     * The hook {@link self::processModuleItemSetHook()} can be used in the
     * implementation before setting $element.
     *
     * @param ezcFeedItem $item The feed item object
     * @param string $element The feed element
     * @param mixed $value The new value of $element
     */
    abstract public function setFeedItemElement( ezcFeedItem $item, $element, $value );

    /**
     * Returns the value of the feed element $element.
     *
     * @param string $element The feed element
     * @return mixed
     */
    abstract public function getFeedElement( $element );

    /**
     * Returns the value of the element $element of feed item $item.
     *
     * @param ezcFeedItem $item The feed item object
     * @param string $element The feed element
     * @return mixed
     */
    abstract public function getFeedItemElement( ezcFeedItem $item, $element );

    /**
     * Returns an XML string from the feed information contained in this
     * processor.
     *
     * The hooks {@link self::processModuleFeedGenerateHook()} and
     * {@link self::processModuleItemGenerateHook()} can be used in the
     * implementation for each attribute in the feed and in the feed items.
     *
     * @return string
     */
    abstract public function generate();
}
?>
