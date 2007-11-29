<?php
/**
 * ezcImageConversionSuite
 *
 * @package ImageConversion
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Require test suite for ezcImageConverter class.
 */
require_once 'converter_test.php';

/**
 * Require test suite for ezcImageTransformation class.
 */
require_once 'transformation_test.php';

/**
 * Require test suite for ImageHandlerGd class.
 */
require_once 'handlergd_test.php';
/**
 * Require test suite for ImageFiltersGd class.
 */
require_once 'filtersgd_test.php';

/**
 * Require test suite for ImageHandlerShell class.
 */
require_once 'handlershell_test.php';
/**
 * Require test suite for ImageFiltersShell class.
 */
require_once 'filtersshell_test.php';

class ezcImageConversionSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName( "ImageConversion" );

        $this->addTest( ezcImageConversionConverterTest::suite() );
        $this->addTest( ezcImageConversionTransformationTest::suite() );

        $this->addTest( ezcImageConversionHandlerGdTest::suite() );
        $this->addTest( ezcImageConversionFiltersGdTest::suite() );

        $this->addTest( ezcImageConversionHandlerShellTest::suite() );
        $this->addTest( ezcImageConversionFiltersShellTest::suite() );
    }

    public static function suite()
    {
        return new ezcImageConversionSuite( "ezcImageConversionSuite" );
    }
}
?>
