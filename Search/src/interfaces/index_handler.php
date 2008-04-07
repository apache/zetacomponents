<?php
/**
 * File containing the ezcSearchIndexHandler interface.
 *
 * @package Search
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Defines interface for all the search backend implementations.
 *
 * @version //autogentag//
 * @package Search
 */
interface ezcSearchIndexHandler
{
    /**
     * Starts a transaction for indexing.
     *
     * When using a transaction, the amount of processing that the search
     * backend does decreases, increasing indexing performance. Without this,
     * the component sends a commit after every document that is indexed.
     * Transactions can be nested, when commit() is called the same number of
     * times as beginTransaction(), the component sends a commit.
     */
    public function beginTransaction();

    /**
     * Ends a transaction and calls commit.
     *
     * @throws ezcSearchTransactionException if no transaction is active.
     */
    public function commit();

    /**
     * Indexes the document $document using definition $definition
     *
     * @param ezcSearchDocumentDefinition $definition
     * @param mixed $document
     */
    public function index( ezcSearchDocumentDefinition $definition, $document );
    public function createDeleteQuery();
    public function delete( ezcSearchDeleteQuery $query );
}
?>
