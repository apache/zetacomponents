<?php
/**
 * File containing the ezcDocument test suite
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * 
 * A base class for document type handlers.
 *
 */

/**
* Required test suites.
*/
require 'tokenizer_tests.php';

class ezcDocumentBBCodeSuite extends PHPUnit_Framework_TestSuite
{
    public static function suite()
    {
        return new ezcDocumentBBCodeSuite( __CLASS__ );
    }

    public function __construct()
    {
        parent::__construct();
        $this->setName( "Document BBCode tests" );

        $this->addTest( ezcDocumentBBCodeTokenizerTests::suite() );
    }
}

?>
