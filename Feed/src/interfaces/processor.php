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
     * A list of modules which are loaded.
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

    public function addItemModule( $moduleName, $moduleObj, $item )
    {
        if ( !$this->isModuleSupported( $moduleName ) )
        {
            throw new ezcFeedUnsupportedModuleException( $moduleName );
        }
        return new ezcFeedItemModuleData( $moduleName, $moduleObj, $item );
    }

    public function getAllModuleMetaData( $module )
    {
        if ( isset( $this->moduleMetaData[$module] ) )
        {
            return $this->moduleMetaData[$module];
        }
        return array();
    }

    public function getModuleMetaData( $moduleName, $moduleObj, $element )
    {
        if ( isset( $this->moduleMetaData[$moduleName][$element] ) )
        {
            return $this->moduleMetaData[$moduleName][$element];
        }
        return null;
    }

    public function getModuleItemData( $moduleName, $moduleObj, $item, $element )
    {
        return $item->getModuleMetaData( $moduleName, $element );
    }

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

    public function getSupportedModules()
    {
        return $this->supportedModules;
    }

    public function getModules()
    {
        return $this->modules;
    }

    public function processModuleFeedSetHook( $feed, $element, $value )
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

    public function processModuleItemSetHook( $item, $element, $value )
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

    public function processModuleItemGenerateHook( $item, $element, $value )
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

    abstract public function getFeedElement( $element );
    abstract public function getFeedItemElement( $item, $element );
    abstract public function setFeedElement( $element, $value );
    abstract public function setFeedItemElement( $item, $element, $value );
    abstract public function generate();
}
?>
