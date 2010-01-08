<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PhpGenerator
 * @subpackage Tests
 */

/**
 * Including the tests
 */
require_once( "php_generator_test.php" );

/**
 * @package PhpGenerator
 * @subpackage Tests
 */
class ezcPhpGeneratorSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName("PhpGenerator");

        $this->addTest( ezcPhpGeneratorTest::suite() );
    }

    public static function suite()
    {
        return new ezcPhpGeneratorSuite();
    }
}
?>
