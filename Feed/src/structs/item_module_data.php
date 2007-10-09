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
 * Container for module data in feed items.
 *
 * @package Feed
 * @version //autogentag//
 * @access private
 */
class ezcFeedItemModuleData
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
     * Holds the feed item object.
     *
     * @var ezcFeedItem
     */
    protected $item;

    /**
     * Constructs a new ezcFeedItemModuleData object.
     *
     * @param string $moduleName The module name (eg. 'DublinCore')
     * @param ezcFeedModule $moduleObj The module object
     * @param ezcFeedItem $item The feed item object
     */
    public function __construct( $moduleName, ezcFeedModule $moduleObj, ezcFeedItem $item )
    {
        $this->moduleName = $moduleName;
        $this->moduleObj = $moduleObj;
        $this->item = $item;
    }

    /**
     * Sets the property $element to $value.
     *
     * @throws ezcFeedUnsupportedModuleItemElementException
     *         If $element is not allowed in the module of the item.
     *
     * @param string $element The property name
     * @param mixed $value The property value
     * @ignore
     */
    public function __set( $element, $value )
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

    /**
     * Returns the value of property $element.
     *
     * @param string $element The property name
     * @return mixed
     * @ignore
     */
    public function __get( $element )
    {
        return $this->item->feedProcessor->getModuleItemData( $this->moduleName, $this->moduleObj, $this->item, $element );
    }
}
?>
