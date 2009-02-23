<?php
/**
 * File containing the ezcAuthenticationOpenidDbStoreHelper class.
 *
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
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
