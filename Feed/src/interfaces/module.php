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
abstract class ezcFeedModule
{
    abstract public function getNamespace();
    abstract public function getNamespacePrefix();
    abstract public function feedMetaHook( $element, $value );

    public function isElementAllowed( $element )
    {
        return in_array( $element, $this->supportedElements );
    }
}
?>
