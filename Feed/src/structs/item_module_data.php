<?php
/**
 * File containing the ezcFeedItemModuleData class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
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
        if ( !$this->moduleObj->isItemElementAllowed( $element ) )
        {
            throw new ezcFeedUnsupportedModuleItemElementException( $this->moduleName, $element );
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
