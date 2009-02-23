<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Template
 * @subpackage Tests
 */

require_once "invariant_parse_cursor.php";

/**
 * @package Template
 * @subpackage Tests
 */
class ezcTemplateCursorTest extends ezcTestCase
{
    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcTemplateCursorTest" );
    }

    protected function setUp()
    {
        $this->defaultCursor = new Invariant_ezcTemplateCursor( "a simple line\nsecond line" );
        $this->cursor = new Invariant_ezcTemplateCursor( "a simple line\nsecond line", 18, 2, 4 );

    }

    protected function tearDown()
    {
        unset( $this->cursor );
    }

    /**
     * Test default constructor values
     */
    public function testDefault()
    {
        $receiver = $this->readAttribute( $this->defaultCursor, 'receiver' );

        self::assertAttributeSame( "a simple line\nsecond line", 'text', $receiver );
        self::assertAttributeSame( 0, 'position', $receiver );
        self::assertAttributeSame( 1, 'line', $receiver );
        self::assertAttributeSame( 0, 'column', $receiver );
    }

    /**
     * Test passing constructor values
     */
    public function testInit()
    {
        $this->cursor = new Invariant_ezcTemplateCursor( "a simple line\nsecond line", 18, 2, 4 );
        $receiver = $this->readAttribute( $this->cursor, 'receiver' );

        self::assertAttributeSame( "a simple line\nsecond line", 'text', $receiver );
        self::assertAttributeSame( 18, 'position', $receiver );
        self::assertAttributeSame( 2, 'line', $receiver );
        self::assertAttributeSame( 4, 'column', $receiver );

        self::assertSame( false, $this->cursor->atBeginning(), "Function atBeginning() did not return false." );
        self::assertSame( false, $this->cursor->atEnd(), "Function atEnd() did not return false." );
    }

    /**
     * Test hasCode() with code initialised
     */
    public function testGotoBeginning()
    {
        $this->cursor->gotoBeginning();
        $receiver = $this->readAttribute( $this->cursor, 'receiver' );

        self::assertAttributeSame( "a simple line\nsecond line", 'text', $receiver );
        self::assertAttributeSame( 0, 'position', $receiver );
        self::assertAttributeSame( 1, 'line', $receiver );
        self::assertAttributeSame( 0, 'column', $receiver );

        self::assertSame( true, $this->cursor->atBeginning(), "Function atBeginning() did not return true." );
        self::assertSame( false, $this->cursor->atEnd(), "Function atEnd() did not return false." );
    }

    /**
     * Test hasCode() with code initialised
     */
    public function testGotoEnd()
    {
        $this->cursor->gotoEnd();
        $receiver = $this->readAttribute( $this->cursor, 'receiver' );

        self::assertAttributeSame( "a simple line\nsecond line", 'text', $receiver );
        self::assertAttributeSame( 25, 'position', $receiver );
        self::assertAttributeSame( 2, 'line', $receiver );
        self::assertAttributeSame( 11, 'column', $receiver );

        self::assertSame( false, $this->cursor->atBeginning(), "Function atBeginning() did not return false." );
        self::assertSame( true, $this->cursor->atEnd(), "Function atEnd() did not return true." );
    }

    /**
     * Test gotoLineBeginning()
     */
    public function testGotoLineBeginning()
    {
        $this->cursor->gotoLineBeginning();
        $receiver = $this->readAttribute( $this->cursor, 'receiver' );

        self::assertAttributeSame( "a simple line\nsecond line", 'text', $receiver );
        self::assertAttributeSame( 14, 'position', $receiver );
        self::assertAttributeSame( 2, 'line', $receiver );
        self::assertAttributeSame( 0, 'column', $receiver );

        self::assertSame( false, $this->cursor->atBeginning(), "Function atBeginning() did not return false." );
        self::assertSame( false, $this->cursor->atEnd(), "Function atEnd() did not return false." );

        // Second time should not change values
        $this->cursor->gotoLineBeginning();
        $receiver = $this->readAttribute( $this->cursor, 'receiver' );

        self::assertAttributeSame( "a simple line\nsecond line", 'text', $receiver );
        self::assertAttributeSame( 14, 'position', $receiver );
        self::assertAttributeSame( 2, 'line', $receiver );
        self::assertAttributeSame( 0, 'column', $receiver );

        self::assertSame( false, $this->cursor->atBeginning(), "Function atBeginning() did not return false." );
        self::assertSame( false, $this->cursor->atEnd(), "Function atEnd() did not return false." );
    }

    /**
     * Test gotoLineEnd()
     */
    public function testGotoLineEnd()
    {
        $this->cursor->gotoLineEnd();
        $receiver = $this->readAttribute( $this->cursor, 'receiver' );

        self::assertAttributeSame( "a simple line\nsecond line", 'text', $receiver );
        self::assertAttributeSame( 25, 'position', $receiver );
        self::assertAttributeSame( 2, 'line', $receiver );
        self::assertAttributeSame( 11, 'column', $receiver );

        self::assertSame( false, $this->cursor->atBeginning(), "Function atBeginning() did not return false." );
        self::assertSame( true, $this->cursor->atEnd(), "Function atEnd() did not return false." );

        // Second time should not change values
        $this->cursor->gotoLineEnd();
        $receiver = $this->readAttribute( $this->cursor, 'receiver' );

        self::assertAttributeSame( "a simple line\nsecond line", 'text', $receiver );
        self::assertAttributeSame( 25, 'position', $receiver );
        self::assertAttributeSame( 2, 'line', $receiver );
        self::assertAttributeSame( 11, 'column', $receiver );

        self::assertSame( false, $this->cursor->atBeginning(), "Function atBeginning() did not return false." );
        self::assertSame( true, $this->cursor->atEnd(), "Function atEnd() did not return false." );
    }

    /**
     * Test gotoLineBeginning() and gotoLineEnd()
     */
    public function testGotoLines()
    {
        $this->cursor->gotoLineBeginning();
        $receiver = $this->readAttribute( $this->cursor, 'receiver' );

        self::assertAttributeSame( "a simple line\nsecond line", 'text', $receiver );
        self::assertAttributeSame( 14, 'position', $receiver );
        self::assertAttributeSame( 2, 'line', $receiver );
        self::assertAttributeSame( 0, 'column', $receiver );

        self::assertSame( false, $this->cursor->atBeginning(), "Function atBeginning() did not return false." );
        self::assertSame( false, $this->cursor->atEnd(), "Function atEnd() did not return false." );

        $this->cursor->gotoLineEnd();
        $receiver = $this->readAttribute( $this->cursor, 'receiver' );

        self::assertAttributeSame( "a simple line\nsecond line", 'text', $receiver );
        self::assertAttributeSame( 25, 'position', $receiver );
        self::assertAttributeSame( 2, 'line', $receiver );
        self::assertAttributeSame( 11, 'column', $receiver );

        self::assertSame( false, $this->cursor->atBeginning(), "Function atBeginning() did not return false." );
        self::assertSame( true, $this->cursor->atEnd(), "Function atEnd() did not return false." );

        $this->cursor->gotoLineBeginning();
        $receiver = $this->readAttribute( $this->cursor, 'receiver' );

        self::assertAttributeSame( "a simple line\nsecond line", 'text', $receiver );
        self::assertAttributeSame( 14, 'position', $receiver );
        self::assertAttributeSame( 2, 'line', $receiver );
        self::assertAttributeSame( 0, 'column', $receiver );

        self::assertSame( false, $this->cursor->atBeginning(), "Function atBeginning() did not return false." );
        self::assertSame( false, $this->cursor->atEnd(), "Function atEnd() did not return false." );

        $this->cursor->gotoLineEnd();
        $receiver = $this->readAttribute( $this->cursor, 'receiver' );

        self::assertAttributeSame( "a simple line\nsecond line", 'text', $receiver );
        self::assertAttributeSame( 25, 'position', $receiver );
        self::assertAttributeSame( 2, 'line', $receiver );
        self::assertAttributeSame( 11, 'column', $receiver );

        self::assertSame( false, $this->cursor->atBeginning(), "Function atBeginning() did not return false." );
        self::assertSame( true, $this->cursor->atEnd(), "Function atEnd() did not return false." );
    }

    /**
     * Test hasCode() with code initialised
     */
/*    public function testGotoPosition()
    {
        $this->cursor->gotoPosition( 14 );
        $receiver = $this->readAttribute( $this->cursor, 'receiver' );

        self::assertAttributeSame( "a simple line\nsecond line", 'text', $receiver );
        self::assertAttributeSame( 14, 'position', $receiver );
        self::assertAttributeSame( 2, 'line', $receiver );
        self::assertAttributeSame( 0, 'column', $receiver );

        $this->cursor->gotoPosition( 4 );
        $receiver = $this->readAttribute( $this->cursor, 'receiver' );

        self::assertAttributeSame( "a simple line\nsecond line", 'text', $receiver );
        self::assertAttributeSame( 4, 'position', $receiver );
        self::assertAttributeSame( 1, 'line', $receiver );
        self::assertAttributeSame( 4, 'column', $receiver );

        // test moving to the start
        $this->cursor->gotoPosition( 0 );
        $receiver = $this->readAttribute( $this->cursor, 'receiver' );

        self::assertAttributeSame( "a simple line\nsecond line", 'text', $receiver );
        self::assertAttributeSame( 0, 'position', $receiver );
        self::assertAttributeSame( 1, 'line', $receiver );
        self::assertAttributeSame( 0, 'column', $receiver );

        // same again
        $this->cursor->gotoPosition( 0 );
        $receiver = $this->readAttribute( $this->cursor, 'receiver' );

        self::assertAttributeSame( "a simple line\nsecond line", 'text', $receiver );
        self::assertAttributeSame( 0, 'position', $receiver );
        self::assertAttributeSame( 1, 'line', $receiver );
        self::assertAttributeSame( 0, 'column', $receiver );
    }*/

    /**
     * Test hasCode() with code initialised
     */
    public function testSubstring()
    {
        $subText = $this->cursor->substring();
        $current = $this->cursor->current();
        $receiver = $this->readAttribute( $this->cursor, 'receiver' );

        self::assertAttributeSame( "a simple line\nsecond line", 'text', $receiver );
        self::assertAttributeSame( 18, 'position', $receiver );
        self::assertAttributeSame( 2, 'line', $receiver );
        self::assertAttributeSame( 4, 'column', $receiver );

        self::assertSame( "nd line", $subText );
        self::assertSame( "n", $current );

        $this->cursor->gotoEnd();
        $subText = $this->cursor->substring();
        $current = $this->cursor->current();
        $receiver = $this->readAttribute( $this->cursor, 'receiver' );

        self::assertAttributeSame( "a simple line\nsecond line", 'text', $receiver );
        self::assertAttributeSame( 25, 'position', $receiver );
        self::assertAttributeSame( 2, 'line', $receiver );
        self::assertAttributeSame( 11, 'column', $receiver );

        self::assertSame( false, $subText );
        self::assertSame( false, $current );

        $this->cursor->gotoBeginning();
        $subText = $this->cursor->substring();
        $current = $this->cursor->current();
        $receiver = $this->readAttribute( $this->cursor, 'receiver' );

        self::assertAttributeSame( "a simple line\nsecond line", 'text', $receiver );
        self::assertAttributeSame( 0, 'position', $receiver );
        self::assertAttributeSame( 1, 'line', $receiver );
        self::assertAttributeSame( 0, 'column', $receiver );

        self::assertSame( "a simple line\nsecond line", $subText );
        self::assertSame( "a", $current );
    }
}
?>
