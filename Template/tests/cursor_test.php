<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
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
         return new ezcTestSuite( "ezcTemplateCursorTest" );
    }

    public function setUp()
    {
        $this->defaultCursor = new Invariant_ezcTemplateCursor( "a simple line\nsecond line" );
        $this->cursor = new Invariant_ezcTemplateCursor( "a simple line\nsecond line", 18, 2, 4 );

    }

    public function tearDown()
    {
        unset( $this->cursor );
    }

    /**
     * Test default constructor values
     */
    public function testDefault()
    {
        self::assertPropertySame( $this->defaultCursor, 'text', "a simple line\nsecond line" );
        self::assertPropertySame( $this->defaultCursor, 'position', 0 );
        self::assertPropertySame( $this->defaultCursor, 'line', 1 );
        self::assertPropertySame( $this->defaultCursor, 'column', 0 );
    }

    /**
     * Test passing constructor values
     */
    public function testInit()
    {
        $this->cursor = new Invariant_ezcTemplateCursor( "a simple line\nsecond line", 18, 2, 4 );

        self::assertPropertySame( $this->cursor, 'text', "a simple line\nsecond line" );
        self::assertPropertySame( $this->cursor, 'position', 18 );
        self::assertPropertySame( $this->cursor, 'line', 2 );
        self::assertPropertySame( $this->cursor, 'column', 4 );
        self::assertSame( false, $this->cursor->atBeginning(), "Function atBeginning() did not return false." );
        self::assertSame( false, $this->cursor->atEnd(), "Function atEnd() did not return false." );
    }

    /**
     * Test hasCode() with code initialised
     */
    public function testGotoBeginning()
    {
        $this->cursor->gotoBeginning();

        self::assertPropertySame( $this->cursor, 'text', "a simple line\nsecond line" );
        self::assertPropertySame( $this->cursor, 'position', 0 );
        self::assertPropertySame( $this->cursor, 'line', 1 );
        self::assertPropertySame( $this->cursor, 'column', 0 );
        self::assertSame( true, $this->cursor->atBeginning(), "Function atBeginning() did not return true." );
        self::assertSame( false, $this->cursor->atEnd(), "Function atEnd() did not return false." );
    }

    /**
     * Test hasCode() with code initialised
     */
    public function testGotoEnd()
    {
        $this->cursor->gotoEnd();

        self::assertPropertySame( $this->cursor, 'text', "a simple line\nsecond line" );
        self::assertPropertySame( $this->cursor, 'position', 25 );
        self::assertPropertySame( $this->cursor, 'line', 2 );
        self::assertPropertySame( $this->cursor, 'column', 11 );
        self::assertSame( false, $this->cursor->atBeginning(), "Function atBeginning() did not return false." );
        self::assertSame( true, $this->cursor->atEnd(), "Function atEnd() did not return true." );
    }

    /**
     * Test gotoLineBeginning()
     */
    public function testGotoLineBeginning()
    {
        $this->cursor->gotoLineBeginning();

        self::assertPropertySame( $this->cursor, 'text', "a simple line\nsecond line" );
        self::assertPropertySame( $this->cursor, 'position', 14 );
        self::assertPropertySame( $this->cursor, 'line', 2 );
        self::assertPropertySame( $this->cursor, 'column', 0 );
        self::assertSame( false, $this->cursor->atBeginning(), "Function atBeginning() did not return false." );
        self::assertSame( false, $this->cursor->atEnd(), "Function atEnd() did not return false." );

        // Second time should not change values
        $this->cursor->gotoLineBeginning();

        self::assertPropertySame( $this->cursor, 'text', "a simple line\nsecond line" );
        self::assertPropertySame( $this->cursor, 'position', 14 );
        self::assertPropertySame( $this->cursor, 'line', 2 );
        self::assertPropertySame( $this->cursor, 'column', 0 );
        self::assertSame( false, $this->cursor->atBeginning(), "Function atBeginning() did not return false." );
        self::assertSame( false, $this->cursor->atEnd(), "Function atEnd() did not return false." );
    }

    /**
     * Test gotoLineEnd()
     */
    public function testGotoLineEnd()
    {
        $this->cursor->gotoLineEnd();

        self::assertPropertySame( $this->cursor, 'text', "a simple line\nsecond line" );
        self::assertPropertySame( $this->cursor, 'position', 25 );
        self::assertPropertySame( $this->cursor, 'line', 2 );
        self::assertPropertySame( $this->cursor, 'column', 11 );
        self::assertSame( false, $this->cursor->atBeginning(), "Function atBeginning() did not return false." );
        self::assertSame( true, $this->cursor->atEnd(), "Function atEnd() did not return false." );

        // Second time should not change values
        $this->cursor->gotoLineEnd();

        self::assertPropertySame( $this->cursor, 'text', "a simple line\nsecond line" );
        self::assertPropertySame( $this->cursor, 'position', 25 );
        self::assertPropertySame( $this->cursor, 'line', 2 );
        self::assertPropertySame( $this->cursor, 'column', 11 );
        self::assertSame( false, $this->cursor->atBeginning(), "Function atBeginning() did not return false." );
        self::assertSame( true, $this->cursor->atEnd(), "Function atEnd() did not return false." );
    }

    /**
     * Test gotoLineBeginning() and gotoLineEnd()
     */
    public function testGotoLines()
    {
        $this->cursor->gotoLineBeginning();

        self::assertPropertySame( $this->cursor, 'text', "a simple line\nsecond line" );
        self::assertPropertySame( $this->cursor, 'position', 14 );
        self::assertPropertySame( $this->cursor, 'line', 2 );
        self::assertPropertySame( $this->cursor, 'column', 0 );
        self::assertSame( false, $this->cursor->atBeginning(), "Function atBeginning() did not return false." );
        self::assertSame( false, $this->cursor->atEnd(), "Function atEnd() did not return false." );

        $this->cursor->gotoLineEnd();

        self::assertPropertySame( $this->cursor, 'text', "a simple line\nsecond line" );
        self::assertPropertySame( $this->cursor, 'position', 25 );
        self::assertPropertySame( $this->cursor, 'line', 2 );
        self::assertPropertySame( $this->cursor, 'column', 11 );
        self::assertSame( false, $this->cursor->atBeginning(), "Function atBeginning() did not return false." );
        self::assertSame( true, $this->cursor->atEnd(), "Function atEnd() did not return false." );

        $this->cursor->gotoLineBeginning();

        self::assertPropertySame( $this->cursor, 'text', "a simple line\nsecond line" );
        self::assertPropertySame( $this->cursor, 'position', 14 );
        self::assertPropertySame( $this->cursor, 'line', 2 );
        self::assertPropertySame( $this->cursor, 'column', 0 );
        self::assertSame( false, $this->cursor->atBeginning(), "Function atBeginning() did not return false." );
        self::assertSame( false, $this->cursor->atEnd(), "Function atEnd() did not return false." );

        $this->cursor->gotoLineEnd();

        self::assertPropertySame( $this->cursor, 'text', "a simple line\nsecond line" );
        self::assertPropertySame( $this->cursor, 'position', 25 );
        self::assertPropertySame( $this->cursor, 'line', 2 );
        self::assertPropertySame( $this->cursor, 'column', 11 );
        self::assertSame( false, $this->cursor->atBeginning(), "Function atBeginning() did not return false." );
        self::assertSame( true, $this->cursor->atEnd(), "Function atEnd() did not return false." );
    }

    /**
     * Test hasCode() with code initialised
     */
/*    public function testGotoPosition()
    {
        $this->cursor->gotoPosition( 14 );

        self::assertPropertySame( $this->cursor, 'text', "a simple line\nsecond line" );
        self::assertPropertySame( $this->cursor, 'position', 14 );
        self::assertPropertySame( $this->cursor, 'line', 2 );
        self::assertPropertySame( $this->cursor, 'column', 0 );

        $this->cursor->gotoPosition( 4 );

        self::assertPropertySame( $this->cursor, 'text', "a simple line\nsecond line" );
        self::assertPropertySame( $this->cursor, 'position', 4 );
        self::assertPropertySame( $this->cursor, 'line', 1 );
        self::assertPropertySame( $this->cursor, 'column', 4 );

        // test moving to the start
        $this->cursor->gotoPosition( 0 );

        self::assertPropertySame( $this->cursor, 'text', "a simple line\nsecond line" );
        self::assertPropertySame( $this->cursor, 'position', 0 );
        self::assertPropertySame( $this->cursor, 'line', 1 );
        self::assertPropertySame( $this->cursor, 'column', 0 );

        // same again
        $this->cursor->gotoPosition( 0 );

        self::assertPropertySame( $this->cursor, 'text', "a simple line\nsecond line" );
        self::assertPropertySame( $this->cursor, 'position', 0 );
        self::assertPropertySame( $this->cursor, 'line', 1 );
        self::assertPropertySame( $this->cursor, 'column', 0 );
    }*/

    /**
     * Test hasCode() with code initialised
     */
    public function testSubstring()
    {
        $subText = $this->cursor->substring();
        $current = $this->cursor->current();

        self::assertPropertySame( $this->cursor, 'text', "a simple line\nsecond line" );
        self::assertPropertySame( $this->cursor, 'position', 18 );
        self::assertPropertySame( $this->cursor, 'line', 2 );
        self::assertPropertySame( $this->cursor, 'column', 4 );
        self::assertSame( "nd line", $subText );
        self::assertSame( "n", $current );

        $this->cursor->gotoEnd();
        $subText = $this->cursor->substring();
        $current = $this->cursor->current();

        self::assertPropertySame( $this->cursor, 'text', "a simple line\nsecond line" );
        self::assertPropertySame( $this->cursor, 'position', 25 );
        self::assertPropertySame( $this->cursor, 'line', 2 );
        self::assertPropertySame( $this->cursor, 'column', 11 );
        self::assertSame( false, $subText );
        self::assertSame( false, $current );

        $this->cursor->gotoBeginning();
        $subText = $this->cursor->substring();
        $current = $this->cursor->current();

        self::assertPropertySame( $this->cursor, 'text', "a simple line\nsecond line" );
        self::assertPropertySame( $this->cursor, 'position', 0 );
        self::assertPropertySame( $this->cursor, 'line', 1 );
        self::assertPropertySame( $this->cursor, 'column', 0 );
        self::assertSame( "a simple line\nsecond line", $subText );
        self::assertSame( "a", $current );
    }
}


?>
