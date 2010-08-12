<?php

/**
 * This class carries a set of client tests for a ezcWebdavClientTest.
 * 
 * @package PersistentObject
 * @version //autogen//
 * @author  
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
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
