<?php
/**
 * File containing the ezcFeedModuleContent class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * @package Feed
 * @version //autogentag//
 */
class ezcFeedModuleContent implements ezcFeedModule
{
    private $feedType;
    private $supportedItemElements = array( 'encoded' );

    public function __construct( $feedType )
    {
        $this->feedType = $feedType;
    }

    public static function getModuleName()
    {
        return 'Content';
    }

    public static function getNamespace()
    {
        return 'http://purl.org/rss/1.0/modules/content/';
    }

    public static function getNamespacePrefix()
    {
        return 'content';
    }

    public function isChannelElementAllowed( $element )
    {
        return false;
    }

    public function isItemElementAllowed( $element )
    {
        return in_array( $element, $this->supportedItemElements );
    }

    public function generateMetaData( $feedProcessor, $element, $value )
    {
        die( "SHOUDL NOT BE CALLED" );
        $prefix = $this->getNamespacePrefix();
        switch ( $element )
        {
            default:
                $feedProcessor->generateMetaData( "$prefix:$element", $value );
                break;
        }
    }

    public function generateItemData( $itemTag, $feedProcessor, $element, $value )
    {
        $prefix = $this->getNamespacePrefix();
        switch ( $element )
        {
            default:
                $feedProcessor->generateItemData( $itemTag, "$prefix:$element", $value );
                break;
        }
    }
    
    public function prepareMetaData( $element, $value )
    {
        return $value;
    }

    public function feedMetaSetHook( &$element, &$value )
    {
        return null;
    }

    public function feedMetaGenerateHook( $moduleData, &$element, &$value )
    {
        return true;
    }

    public function feedItemSetHook( &$element, &$value )
    {
        return null;
    }

    public function feedItemGenerateHook( $moduleData, &$element, &$value )
    {
        return true;
    }
}
?>
