<?php
/**
 * File containing the ezcDocumentPdfTransactionalDriverWrapperState class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * PDF driver proxy, which records write calls to proxied driver, wraps them
 * into transactions to optionally revert or commit them later.
 *
 * Since page layouting algorithms are basically always backtracking algorithms
 * they always try to render something, and need to recursively revert already
 * "rendered" stuff. This proxy class for all driver classes records calls,
 * optionally assiciates them with transaction identifies and allows to
 * selectively revert or commint groups of such calls to the backend. Only when
 * comitting or calling save() on the driver proxy any modifying (write)
 * operations are actually issued on the proxied driver.
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
class ezcDocumentPdfTransactionalDriverWrapperState extends ezcBaseStruct
{
    /**
     * Recorded calls in the current transaction
     * 
     * @var array
     */
    public $calls = array();

    /**
     * Page creations, performed in the current transaction
     * 
     * @var array
     */
    public $pageCreations = array();

    /**
     * Current page, in this transaction
     * 
     * @var int
     */
    public $currentPage = 0;
}
?>
