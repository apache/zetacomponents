<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Feed
 */
/**
 * Container for module data
 *
 * @package Feed
 * @version //autogentag//
 */
class ezcFeedItemModuleData
{
    private $moduleName;
    public $moduleObj;
    private $item;
    
    function __construct( $moduleName, $moduleObj, $item )
    {
        $this->moduleName = $moduleName;
        $this->moduleObj = $moduleObj;
        $this->item = $item;
    }

    function __set( $element, $value )
    {
        if ( !$this->moduleObj->isElementAllowed( $element ) )
        {
            throw new ezcFeedUnsupportedModuleElementException( $this->moduleName, $element );
        }
        else
        {
            $this->item->feedProcessor->setModuleItemData( $this->moduleName, $this->moduleObj, $this->item, $element, $value );
        }
    }

    function __get( $element )
    {
        return $this->item->feedProcessor->getModuleItemData( $this->moduleName, $this->moduleObj, $this->item, $element );
    }
}
?>
