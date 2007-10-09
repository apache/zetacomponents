<?php
/**
 * File containing the ezcFeedModuleData class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Container for module data.
 *
 * @package Feed
 * @version //autogentag//
 * @access private
 */
class ezcFeedModuleData
{
    /**
     * Holds the module name (eg. 'DublinCore').
     *
     * @var string
     */
    public $moduleName;

    /**
     * Holds the module object.
     *
     * @var ezcFeedModule
     */
    public $moduleObj;

    /**
     * Holds the feed processor object.
     *
     * @var ezcFeedProcessor
     */
    protected $feedProcessor;
    
    /**
     * Constructs a new ezcFeedModuleData object.
     *
     * @param string $moduleName The module name (eg. 'DublinCore')
     * @param ezcFeedModule $moduleObj The module object
     * @param ezcFeedProcessor $feedProcessor The feed processor object
     */
    public function __construct( $moduleName, ezcFeedModule $moduleObj, ezcFeedProcessor $feedProcessor )
    {
        $this->moduleName = $moduleName;
        $this->moduleObj = $moduleObj;
        $this->feedProcessor = $feedProcessor;
    }

    /**
     * Sets the property $element to $value.
     *
     * @throws ezcFeedUnsupportedModuleElementException
     *         If $element is not allowed in the module.
     *
     * @param string $element The property name
     * @param mixed $value The property value
     * @ignore
     */
    public function __set( $element, $value )
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

    /**
     * Returns the value of property $element.
     *
     * @param string $element The property name
     * @return mixed
     * @ignore
     */
    public function __get( $element )
    {
        return $this->feedProcessor->getModuleMetaData( $this->moduleName, $this->moduleObj, $element );
    }
}
?>
