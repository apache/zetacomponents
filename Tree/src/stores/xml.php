<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Tree
 */

/**
 * ezcTreeXmlDataStore is an abstract class defining and implementing common
 * methods for XML based data stores.
 *
 * @package Tree
 * @version //autogentag//
 */
abstract class ezcTreeXmlDataStore implements ezcTreeDataStore
{
    /**
     * Contains the DOM representing this tree this data store stores data for.
     *
     * @var DomDocument
     */
    protected $dom;

    /**
     * Associates the DOM tree for which this data store stores data for with
     * this store.
     *
     * @param DOMDocument $dom
     */
    public function setDomTree( DOMDocument $dom )
    {
        $this->dom = $dom;
    }
}
?>
