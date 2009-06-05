<?php
/**
 * File contaning the ezcTestPrinter class.
 *
 * @package UnitTest
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
require_once 'PHPUnit/TextUI/ResultPrinter.php';
require_once 'PHPUnit/Util/Filter.php';

PHPUnit_Util_Filter::addFileToFilter(__FILE__, 'PHPUNIT');

/**
 * Test printer class.
 *
 * @package UnitTest
 * @version //autogentag//
 */
class ezcTestNewPrinter extends PHPUnit_TextUI_ResultPrinter
{
    protected $depth = 0;

    public function startTestSuite( PHPUnit_Framework_TestSuite $suite )
    {
        if ( empty( $this->numberOfTests ) )
        {
            $this->numberOfTests[0] = 0;
        }

        if ( $this->depth > 0 )
        {
            parent::write( "\n" );
        }

        if ( $this->depth == 1 )
        {
            parent::write( "\n" );
        }

        $name = $suite->getName();

        if ( $name == '' )
        {
            $name = '[No name given]';
        }
        else
        {
            $name = explode( '::', $name );
            $name = array_pop( $name );
        }

        parent::write(
          str_pad(
            str_repeat( '  ', $this->depth++ ) . $name . ': ' ,
            40,
            ' ',
            STR_PAD_RIGHT
          )
        );
    }

    public function endTestSuite( PHPUnit_Framework_TestSuite $suite )
    {
        $this->depth--;
    }

    protected function writeProgress( $progress )
    {
        $this->write( $progress );
    }
}
?>
