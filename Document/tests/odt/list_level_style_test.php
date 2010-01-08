<?php
/**
 * ezcDocumentOdtListLevelStyleTest.
 * 
 * @package Document
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for class.
 * 
 * @package Document
 * @subpackage Tests
 */
class ezcDocumentOdtListLevelStyleTest extends ezcTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testCtor()
    {
        $style = new ezcDocumentOdtListLevelStyleBullet( 23 );

        $this->assertTrue( isset( $style->level ) );
        $this->assertEquals( 23, $style->level );
    }

    public function testPropertiesBulletSuccess()
    {
        $style = new ezcDocumentOdtListLevelStyleBullet( 42 );
        
        $this->assertSetProperty(
            $style,
            'textStyle',
            array(
                new ezcDocumentOdtStyle( ezcDocumentOdtStyle::FAMILY_TEXT, 'foo' )
            )
        );
        $this->assertSetProperty(
            $style,
            'bulletChar',
            array(
                '*',
                '⊕',
            )
        );
        $this->assertSetProperty(
            $style,
            'numPrefix',
            array(
                '.',
                'abc',
                '',
            )
        );
        $this->assertSetProperty(
            $style,
            'numSuffix',
            array(
                '.',
                'abc',
                '',
            )
        );
    }

    public function testPropertiesBulletFailure()
    {
        $style = new ezcDocumentOdtListLevelStyleBullet( 42 );

        $this->assertSetPropertyFails(
            $style,
            'level',
            array(
                23,
                true,
                'foo',
            )
        );
        $this->assertSetPropertyFails(
            $style,
            'textStyle',
            array(
                new ezcDocumentOdtStyle( ezcDocumentOdtStyle::FAMILY_PARAGRAPH, 'foo' ),
                new stdClass(),
                array(),
                23,
                'foo',
            )
        );
        $this->assertSetPropertyFails(
            $style,
            'bulletChar',
            array(
                '**',
                '',
                23,
            )
        );
        $this->assertSetPropertyFails(
            $style,
            'numPrefix',
            array(
                23,
                array(),
            )
        );
        $this->assertSetPropertyFails(
            $style,
            'numSuffix',
            array(
                23,
                array(),
            )
        );

        $this->assertSetPropertyFails(
            $style,
            'fooBar',
            array(
                23
            )
        );

        try
        {
            echo $style->fooBar;
            $this->fail( 'Exception not thronw on get access to not existent property.' );
        }
        catch ( ezcBasePropertyNotFoundException $e ) {}
    }


    public function testPropertiesIssetBullet()
    {
        $style = new ezcDocumentOdtListLevelStyleBullet( 42 );

        $this->assertTrue(
            isset( $style->level )
        );
        $this->assertTrue(
            isset( $style->textStyle )
        );
        $this->assertTrue(
            isset( $style->bulletChar )
        );
        $this->assertTrue(
            isset( $style->numPrefix )
        );
        $this->assertTrue(
            isset( $style->numSuffix )
        );

        $this->assertFalse(
            isset( $style->fooBar )
        );
        $this->assertFalse(
            isset( $style->properties )
        );
    }

    public function testPropertiesNumberSuccess()
    {
        $style = new ezcDocumentOdtListLevelStyleNumber( 42 );
        
        $this->assertSetProperty(
            $style,
            'textStyle',
            array(
                new ezcDocumentOdtStyle( ezcDocumentOdtStyle::FAMILY_TEXT, 'foo' )
            )
        );
        $this->assertSetProperty(
            $style,
            'numFormat',
            array(
                '.f',
                '',
                null,
            )
        );
        $this->assertSetProperty(
            $style,
            'displayLevels',
            array(
                23,
                1,
                0,
            )
        );
        $this->assertSetProperty(
            $style,
            'startValue',
            array(
                23,
                1,
                0,
            )
        );
    }

    public function testPropertiesNumberFailure()
    {
        $style = new ezcDocumentOdtListLevelStyleNumber( 42 );

        $this->assertSetPropertyFails(
            $style,
            'level',
            array(
                23,
                true,
                'foo',
            )
        );
        $this->assertSetPropertyFails(
            $style,
            'textStyle',
            array(
                new ezcDocumentOdtStyle( ezcDocumentOdtStyle::FAMILY_PARAGRAPH, 'foo' ),
                new stdClass(),
                array(),
                23,
                'foo',
            )
        );
        $this->assertSetPropertyFails(
            $style,
            'numFormat',
            array(
                23,
                true,
                array(),
                new stdClass(),
            )
        );
        $this->assertSetPropertyFails(
            $style,
            'displayLevels',
            array(
                'foo',
                true,
                array(),
                new stdClass(),
            )
        );
        $this->assertSetPropertyFails(
            $style,
            'startValue',
            array(
                'foo',
                true,
                array(),
                new stdClass(),
            )
        );

        $this->assertSetPropertyFails(
            $style,
            'fooBar',
            array(
                23
            )
        );

        try
        {
            echo $style->fooBar;
            $this->fail( 'Exception not thronw on get access to not existent property.' );
        }
        catch ( ezcBasePropertyNotFoundException $e ) {}
    }

    public function testPropertiesIssetNumber()
    {
        $style = new ezcDocumentOdtListLevelStyleNumber( 42 );

        $this->assertTrue(
            isset( $style->level )
        );
        $this->assertTrue(
            isset( $style->textStyle )
        );
        $this->assertTrue(
            isset( $style->numFormat )
        );
        $this->assertTrue(
            isset( $style->displayLevels )
        );
        $this->assertTrue(
            isset( $style->startValue )
        );

        $this->assertFalse(
            isset( $style->fooBar )
        );
        $this->assertFalse(
            isset( $style->properties )
        );
    }
}

?>
