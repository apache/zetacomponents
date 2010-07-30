<?php
/**
 * File containing the ezcDbSchemaHandlerDataTransfer interface.
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Bulk data transfer functionality.
 *
 * This interface declares methods common for handlers that support
 * bulk data transfers.
 *
 * <b>Description</b>:
 *
 * There are two handler participating in bulk data transfer: source and destination.
 * Each of the handlers must implement ezcDbSchemaHandlerDataTransfer interface.
 *
 * The source handler implements transfer() method.
 * This method transfers all the tables in storage one-by-one.
 *
 * For each of the tables we transfer data of, the source handler calls
 * setTableBeingTransferred() method on the destination handler.
 *
 * For each row being transferred, the source handler calls saveRow() method on the destination handler.
 *
 * Besides, when the transfer starts, we call destination handler's openTransferDestination() method,
 * and when the transfer finishes, we call destination handler's closeTransferDestination() method.
 *
 * Here is a typical implementation of transfer() method:
 *
 * <code>
 * class SomeSchemaHandler
 * {
 *     public function transfer(  $storage, $storageType, $dstHandler )
 *     {
 *         $tables = $this->getTablesList();

 *         foreach ( $tables as $tableName )
 *         {
 *             $tableFields = $this->getTableFields( $tableName );
 *             $dstHandler->setTableBeingTransferred( $tableName, $tableFields );
 *
 *             $tableData = $this->getTableData( $tableName );
 *             foreach ( $tableData as $row )
 *                 $dstHandler->saveRow( $row );
 *         }
 *     }
 * }
 *
 * </code>
 *
 * The destination handler should implement the following methods:
 * - openTransferDestination()
 * - setTableBeingTransferred()
 * - saveRow()
 * - closeTransferDestination()
 *
 * If you want your handler to be able to act both as source and destination
 * for bulk data transfers, then you should implement all the interface's
 * methods in the handler.
 *
 * @package DatabaseSchema
 */

interface ezcDbSchemaHandlerDataTransfer
{
    /**
     * Actually transfer data [source].
     */
    public function transfer( $storage, $storageType, $dstHandler );

    /**
     * Prepare destination handler for transfer [destination].
     */
    public function openTransferDestination( $storage, $storageType );

    /**
     * Tell destination handler that there is no more data to transfer. [destination]
     */
    public function closeTransferDestination();

    /**
     * Start to transfer data of the next table. [destination]
     */
    public function setTableBeingTransferred( $tableName, $tableFields = null );

    /**
     *  Save given row. [destination]
     */
    public function saveRow( $row );
}
?>
