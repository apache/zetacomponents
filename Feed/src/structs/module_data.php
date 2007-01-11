<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
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
class ezcFeedModuleData
{
    private $moduleName;
    public $moduleObj;
    private $feedProcessor;
    
    function __construct( $moduleName, $moduleObj, $feedProcessor )
    {
        $this->moduleName = $moduleName;
        $this->moduleObj = $moduleObj;
        $this->feedProcessor = $feedProcessor;
    }

    function __set( $element, $value )
    {
        if ( !$this->moduleObj->isChannelElementAllowed( $element ) )
        {
            throw new ezcFeedUnsupportedModuleElementException( $this->moduleName, $element );
        }
        else
        {
            $this->feedProcessor->setModuleMetaData( $this->moduleName, $this->moduleObj, $element, $value );
        }
    }

    function __get( $element )
    {
        return $this->feedProcessor->getModuleMetaData( $this->moduleName, $this->moduleObj, $element );
    }
}
?>
