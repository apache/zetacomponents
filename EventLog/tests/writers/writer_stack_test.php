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
 * @package EventLog
 * @subpackage Tests
 */
class ezcLogStackWriterTest extends ezcTestCase
{
    protected $writer;

    protected $messages = array( 
        array(
            'message' => 'Alien alert',
            'severity' => 'critical',
            'source' => 'UFO report',
            'category' => 'fake warning',
            'optional' => array( 1, 2, 3 )
        ),
        array(
            'message' => 'Alien greeting',
            'severity' => 'uncritical',
            'source' => 'Alien News',
            'category' => 'real warning',
            'optional' => 'hi'
        ),
    );

    protected function setUp()
    {
        $this->writer = new ezcLogStackWriter;
    }

    public function testWriteOneLogMessage()
    {
        $m = $this->messages[0];

        $this->writer->writeLogMessage( $m['message'], $m['severity'], $m['source'], $m['category'], $m['optional']);

        foreach ( $this->writer as $entry )
        {
            $this->assertEquals( $entry->message, $m['message'] );
            $this->assertEquals( $entry->source, $m['source'] );
            $this->assertEquals( $entry->severity, $m['severity'] );
            $this->assertEquals( $entry->category, $m['category'] );
            $this->assertEquals( $entry->optional, $m['optional'] );

            return;
        }
        // should return in the foreach
        $this->fail();
    }

    public function testWriteMultipleLogMessages()
    {
        foreach ( $this->messages as $m )
        {
            $this->writer->writeLogMessage( $m['message'], $m['severity'], $m['source'], $m['category'], $m['optional']);
        }

        $i = 0;
        foreach ( $this->writer as $entry )
        {
            $m = $this->messages[$i];
            ++$i;

            $this->assertEquals( $entry->message, $m['message'] );
            $this->assertEquals( $entry->source, $m['source'] );
            $this->assertEquals( $entry->severity, $m['severity'] );
            $this->assertEquals( $entry->category, $m['category'] );
            $this->assertEquals( $entry->optional, $m['optional'] );
        }
        $this->assertEquals( count( $this->messages ), $i );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite(__CLASS__);
    }
}
?>
