<?php

function __autoload( $className )
{
    $path = strtolower( preg_replace( '/([A-Z])/', '/\\1', $className ) );
    $path = str_replace( 'ezc/', '', $path ) . '.php';
    require_once( $path );
}

/**
 * Test script that is meant to give some clue on how to use the component.
 *
 * @ignore
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */

/**
 * @ignore
 * @package DatabaseSchema
 */
class MyOracleHandler extends ezcDbSchemaHandler
{
    public function __construct( $params )
    {
        parent::_construct( $params );
    }

    public function getSupportedSchemaTypes()
    {
        return array( 'oracle-db, oracle-file' );
    }

    public function loadSchema( mixed $src )
    {
    }

    public function saveSchema( $schema, $dst )
    {
    }

    public function saveDelta ( $delta, $dst )
    {
    }
}

/**
 * @ignore
 * @package DatabaseSchema
 */
class MyAppSchema extends ezcDbSchema
{
    public function __construct()
    {
        parent::__construct( array( 'pre-save-hooks'  => array( 'MyAppSchema::expandTablesNames' ),
                                    'post-load-hooks' => array( 'MyAppSchema::detectAutoIncrements' ),
                                    'user-handlers'   => array( 'MyOracleHandler' ) ) );
    }

    public static function expandTablesNames()
    {
        // ... do smth with schema here ...
    }

    public static function detectAutoIncrements()
    {
        // ... do smth with schema here ...
    }
}

/**
 * a stub, just to prevent PHP errors
 * @ignore
 * @package DatabaseSchema
 */
class Database { function instance() {} }

/**
 * @ignore
 */
function main()
{
    $schema1 = new MyAppSchema;
    $schema2 = new MyAppSchema;

    $schema1->load( 'file1.xml', 'xml-file' );
    $schema2->load( Database::instance(), 'oracle-db' );

    $diff = $schema1->compare( $schema2 );
    $schema1->saveDelta( $diff, 'delta.sql', 'mysql-file' );

    $schema2->save( 'schema2.sql', 'oracle-file' );

    var_dump( $schema1 );
    var_dump( $schema2 );

}

main();

?>
