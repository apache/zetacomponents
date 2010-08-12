<?php
/**
 * File containing the ezcAuthenticationOpenidDbStoreHelper class.
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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @filesource
 * @package AuthenticationDatabaseTiein
 * @version //autogentag//
 * @subpackage Tests
 */

/**
 * Class which exposes the protected functions from ezcAuthenticationOpenidDbStore
 * and contains other needed methods for OpenID database store tests.
 *
 * For testing purposes only.
 *
 * @package AuthenticationDatabaseTiein
 * @version //autogentag//
 * @subpackage Tests
 * @access private
 */
class ezcAuthenticationOpenidDbStoreHelper extends ezcAuthenticationOpenidDbStore
{
    public static function getNonces( ezcDbHandler $db )
    {
        $options = new ezcAuthenticationOpenidDbStoreOptions();
        $table = $options->tableNonces;

        $query = new ezcQuerySelect( $db );
        $query->select( '*' )
              ->from( $db->quoteIdentifier( $table['name'] ) );

        $query = $query->prepare();
        $query->execute();
        $rows = $query->fetchAll();

        $result = array();
        foreach ( $rows as $row )
        {
            $result[] = $row['nonce'];
        }
        return $result;
    }

    public static function getAssociations( ezcDbHandler $db, $url )
    {
        $options = new ezcAuthenticationOpenidDbStoreOptions();
        $table = $options->tableAssociations;

        $query = new ezcQuerySelect( $db );
        $e = $query->expr;
        $query->select( '*' )
              ->from( $db->quoteIdentifier( $table['name'] ) )
              ->where(
                  $e->eq( $db->quoteIdentifier( $table['fields']['url'] ), $query->bindValue( $url ) )
                     );

        $query = $query->prepare();
        $query->execute();
        $rows = $query->fetchAll();

        if ( count( $rows ) > 0 )
        {
            $rows = $rows[0];
            $data = $rows[$table['fields']['association']];

            return $data;
        }
    }

    public static function deleteNonce( ezcDbHandler $db, $nonce )
    {
        $options = new ezcAuthenticationOpenidDbStoreOptions();
        $nonces = $options->tableNonces;

        $query = new ezcQueryDelete( $db );
        $e = $query->expr;
        $query->deleteFrom( $db->quoteIdentifier( $nonces['name'] ) )
              ->where(
                  $e->eq( $db->quoteIdentifier( $nonces['fields']['nonce'] ), $query->bindValue( $nonce ) )
                     );
        $query = $query->prepare();
        $query->execute();
    }
}
?>
