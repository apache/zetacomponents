<?php
/**
 * File containing the ezcDbUtilitiesMysql class.
 *
 * @package Database
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 * @access private
 */

/**
 * Various database methods.
 *
 * This implementation is MySQL specific.
 *
 * This class inherits most of its database handling functionality from
 * PDO ({@link http://php.net/PDO}) -- an object-oriented database abstraction
 * layer that is going to become a new standard for PHP applications.
 *
 * @package Database
 * @todo this class must be renamed
 * @access private
 */
class ezcDbUtilitiesMysql extends ezcDbUtilities
{
    public function __construct( $db )
    {
        parent::__construct( $db );
    }

    public function cleanup()
    {
        $this->db->beginTransaction();
        $rslt = $this->db->query( 'SHOW TABLES' );
        $rslt->setFetchMode( PDO::FETCH_NUM );
        $rows = $rslt->fetchAll();
        foreach ( $rows as $row )
        {
            $table = $row[0];
            $this->db->exec( "DROP TABLE `$table`" );
        }
        $this->db->commit();
    }
}

?>
