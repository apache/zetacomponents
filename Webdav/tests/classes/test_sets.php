<?php

/**
 * This class carries a set of client tests for a ezcWebdavClientTest.
 * 
 * @package PersistentObject
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @author  
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcWebdavTestSetContainer extends ArrayObject
{
    protected $testSetFile;

    protected $sets;

    public function __construct( $testSetFile )
    {
        if ( !file_exists( $testSetFile ) )
        {
            throw new PHPUnit_Framework_ExpectationFailedException(
                "Test set file '{$testSetFile}' not found."
            );
        }
        $this->testSetFile = $testSetFile;
        $this->sets        = require $testSetFile;
        parent::__construct( $this->sets );
    }

    public function getKeys()
    {
        return array_keys( $this->sets );
    }
}

?>
