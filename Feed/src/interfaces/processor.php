<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Feed
 * @access private
 */
/**
 * @package Feed
 * @version //autogentag//
 * @access private
 */
abstract class ezcFeedProcessor
{
    /**
     * A list of modules which are loaded
     *
     * @var array(string=>ezcFeedModule)
     */
    private $modules = array();
    private $moduleMetaData = array();

    public function isModuleSupported( $moduleName )
    {
        return in_array( $moduleName, $this->supportedModules );
    }

    public function addModule( $moduleName, $moduleObj )
    {
        if ( !$this->isModuleSupported( $moduleName ) )
        {
            throw new ezcFeedUnsupportedModuleException( $moduleName, 'RSS' );
        }
        $this->modules[$moduleName] = new ezcFeedModuleData( $moduleName, $moduleObj, $this );
        return $this->modules[$moduleName];
    }

    public function addItemModule( $moduleName, $moduleObj, $item )
    {
        if ( !$this->isModuleSupported( $moduleName ) )
        {
            throw new ezcFeedUnsupportedModuleException( $moduleName, 'RSS' );
        }
        return new ezcFeedItemModuleData( $moduleName, $moduleObj, $item );
    }

    public function getModuleMetaData( $module )
    {
        if ( isset( $this->moduleMetaData[$module] ) )
        {
            return $this->moduleMetaData[$module];
        }
        return array();
    }

    public function setModuleMetaData( $moduleName, $moduleObj, $element, $value )
    {
        $value = $moduleObj->prepareMetaData( $element, $value );
        $this->moduleMetaData[$moduleName][$element] = $value;
    }

    public function setModuleItemData( $moduleName, $moduleObj, $item, $element, $value )
    {
        $value = $moduleObj->prepareMetaData( $element, $value );
        $item->moduleMetaData[$moduleName][$element] = $value;
    }

    public function getSupportedModules()
    {
        return $this->supportedModules;
    }

    public function getModules()
    {
        return $this->modules;
    }

    public function processModuleFeedHook( $feed, $element, $value )
    {
        foreach ( $this->modules as $moduleName => $moduleDescription )
        {
            $moduleValue = $moduleDescription->moduleObj->feedMetaHook( $element, $value );
            if ( !is_null( $moduleValue ) )
            {
                list( $feedElementName, $feedValue ) = $moduleValue;
                $feed->setModuleMetaData( $moduleName, $feedElementName, $value );
            }
        }
    }

    abstract public function getFeedElement( $element );
    abstract public function getFeedItemElement( $item, $element );
    abstract public function setFeedElement( $element, $value );
    abstract public function setFeedItemElement( $item, $element, $value );
    abstract public function generate();
}
?>
