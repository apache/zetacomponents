<?php

class ezcWebdavClientTestSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct($theClass = '', $name = '')
    {
        $argumentsValid = FALSE;

        if ( is_object($theClass) &&
             $theClass instanceof ReflectionClass)
        {
             $argumentsValid = TRUE;
        }
        else if ( is_string($theClass) && $theClass !== ''
                  && class_exists( $theClass, FALSE ) )
        {
            $argumentsValid = TRUE;

            if ( $name == '' )
            {
                $name = $theClass;
            }

            $theClass = new ReflectionClass( $theClass );
        }
        else if ( is_string( $theClass ) )
        {
            $this->setName( $theClass );
            return;
        }

        if ( !$argumentsValid )
        {
            throw new InvalidArgumentException;
        }

        if ( $name != '' )
        {
            $this->setName( $name );
        }
        else
        {
            $this->setName( $theClass->getName() );
        }

        $constructor = $theClass->getConstructor();

        if ( $constructor !== NULL &&
             !$constructor->isPublic() )
        {
            $this->addTest(
                new PHPUnit_Framework_Warning(
                    sprintf(
                        'Class "%s" has no public constructor.',
                        $theClass->getName()
                        )
                    )
                );

            return;
        }

        $names = array();

        if ( $theClass->getName() != 'ezcWebdavClientTest' && !$theClass->isSubclassOf( 'ezcWebdavClientTest' ) )
        {
            $this->addTest(
                new PHPUnit_Framework_Warning(
                    sprintf(
                        'Class "%s" is not a subclass of ezcWebdavClientTest.',
                        $theClass->getName()
                        )
                    )
                );
        }

        $mainTest = $theClass->newInstance();
        $testSets = $mainTest->getTestSets();

        foreach ( $testSets as $testSet )
        {
            $this->addTestSet( $testSet, $mainTest );
        }

        $tests = $this->tests();
        if ( empty( $tests ) )
        {
            $this->addTest(
                new PHPUnit_Framework_Warning(
                    sprintf(
                        'No client tests found in class "%s".',
                        $theClass->getName()
                        )
                    )
                );
        }
    }

    public function addTestSet( $testSet, $mainTest )
    {
        $test = clone $mainTest;
        $test->setTestSet( $testSet );
        $this->addTest( $test );
    }
}

?>
