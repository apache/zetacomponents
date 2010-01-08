<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package EventLog
 * @subpackage Tests
 */

/**
 * Test file for ezcLogFileWriterTest.
 *
 * @package EventLog
 * @subpackage Tests
 */
class TempImplementation2 extends ezcLogFileWriter
{
    public function __construct($dir, $file = null, $maxSize = 1, $maxFiles = 1 )
    {
        parent::__construct($dir, $file, $maxSize, $maxFiles);
        // close the open files in order to see if an exception is thrown
        foreach ( $this->openFiles as $fh )
        {
            fclose( $fh );
        }
    }

    public function writeLogMessage( $message, $type, $source, $category, $extraInfo = array() )
    {
        $res = print_r( array( "message" => $message, "type" => $type, "source" => $source, "category" => $category ), true );
        @$this->write( $type, $source, $category, $res );
    }

    public function __destruct()
    {
    }
}
?>
