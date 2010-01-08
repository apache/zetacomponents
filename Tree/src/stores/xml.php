<?php
/**
 * File containing the ezcTreeXmlDataStore interface.
 *
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Tree
 */

/**
 * ezcTreeXmlDataStore is an interface defining common methods for XML based
 * data stores.
 *
 * @package Tree
 * @version //autogentag//
 */
interface ezcTreeXmlDataStore extends ezcTreeDataStore
{
    /**
     * Associates the DOM tree for which this data store stores data for with
     * this store.
     *
     * @param DOMDocument $dom
     */
    public function setDomTree( DOMDocument $dom );
}
?>
