<?php

require_once 'PHPUnit2/Util/Filter.php';
PHPUnit2_Util_Filter::addFileToFilter(__FILE__);

/**
 * Test case which contains functions for building expectations.
 *
 * To control the number of times a method is invoked use once() and exactly().
 *
 * To define specific constraints to method names and parameters use equalTo()
 * and identicalTo().
 *
 * To define stub use returnValue().
 */
abstract class ezcMockCase extends ezcTestCase
{

    /**
     * Expects the invocation to happen at least one time
     */
    public function atLeastOnce()
    {
        return new ezcMockInvokedAtLeastOnceMatcher();
    }

    /**
     * Expects the invocation to a certain amount of times, no more, no less.
     */
    public function once()
    {
        return new ezcMockInvokedCountMatcher( 1 );
    }

    /**
     * Expects the invocation to a certain amount of times, no more, no less.
     * @param int $count The number of times the invocations must occur.
     */
    public function exactly( $count )
    {
        return new ezcMockInvokedCountMatcher( $count );
    }

    /**
     * Expects the invocation to a occur at a specific count, no method or
     * parameter matching/verification is done before that time.
     * @param int $index The index the invocation must occur at.
     */
    public function at( $index )
    {
        return new ezcMockInvokedAtIndexMatcher( $index );
    }

    /**
     * Returns a constraint which accepts all values.
     */
    public function anything()
    {
        return new ezcMockIsAnythingConstraint();
    }

    /**
     * Returns a constraint which checks if it is equal (==) to another value.
     * @param mixed $value The expected value.
     */
    public function equalTo( $value )
    {
        return new ezcMockIsEqualConstraint( $value );
    }

    /**
     * Returns a constraint which checks if it is identical (===) to another value.
     * @param mixed $value The expected value.
     */
    public function identicalTo( $value )
    {
        return new ezcMockIsIdenticalConstraint( $value );
    }

    /**
     * Returns a constraint which checks if other value is less than $value.
     * @param mixed $value The value to check.
     */
    public function lessThan( $value )
    {
        return new ezcMockLessThanConstraint( $value );
    }

    /**
     * Returns a constraint which checks if other value is greater than $value.
     * @param mixed $value The value to check.
     */
    public function greaterThan( $value )
    {
        return new ezcMockGreaterThanConstraint( $value );
    }

    /**
     * Returns a constraint which checks if the input value is a given type.
     * @param string $type The expected type.
     * @see ezcMockIsTypeConstraint for valid type strings.
     */
    public function isType( $className )
    {
        return new ezcMockIsTypeConstraint( $className );
    }

    /**
     * Returns a constraint which checks if an object is an instance of a given class.
     * @param mixed $className The name of the class the object must be and instance of.
     */
    public function isInstanceOf( $className )
    {
        return new ezcMockIsInstanceOfConstraint( $className );
    }

    /**
     * Returns a constraint which checks for a given sub-string in the input string.
     * @param string $string The sub-string to look for.
     *
     * @note Use stringContaining() for expectations.
     */
    public function stringContains( $string, $case )
    {
        return new ezcMockStringContainsConstraint( $string, $case );
    }

    /**
     * Returns a constraint which checks for a given sub-string in the input string.
     * @param string $string The sub-string to look for.
     *
     * @note Use stringContains() for asserts.
     */
    public function stringContaining( $string, $case )
    {
        return new ezcMockStringContainsConstraint( $string, $case );
    }

    /**
     * Returns a constraint which checks for a given value in the input array.
     * @param mixed $value The value to look for.
     *
     * @note Use arrayContaining() for expectations.
     */
    public function arrayContains( $value )
    {
        return new ezcMockArrayContainsConstraint( $value );
    }

    /**
     * Returns a constraint which checks for a given value in the input array.
     * @param mixed $value The value to look for.
     *
     * @note Use arrayContains() for asserts.
     */
    public function arrayContaining( $value )
    {
        return new ezcMockArrayContainsConstraint( $value );
    }

    /**
     * Returns a constraint which checks for a given key in the input array.
     * @param mixed $key The key to look for.
     *
     * @note Use arrayContainingKey() for expectations.
     */
    public function hasArrayKey( $key )
    {
        return new ezcMockArrayHasKeyConstraint( $key );
    }

    /**
     * Returns a constraint which checks for a given key in the input array.
     * @param mixed $key The key to look for.
     *
     * @note Use hasArrayKey() for asserts.
     */
    public function arrayContainingKey( $key )
    {
        return new ezcMockArrayHasKeyConstraint( $key );
    }


    /**
     * Returns a constraint which checks if the input object has the given property.
     * @param string $property The name of the property to look for.
     */
    public function hasProperty( $property )
    {
        return new ezcMockHasPropertyConstraint( $property );
    }

    /**
     * Returns a constraint which performs a PCRE match with the input string.
     * @param string $pattern The string containing the PCRE pattern.
     * @see {@url http://www.php.net/manual/en/ref.pcre.php}
     */
    public function matchesRegularExpression( $pattern )
    {
        return new ezcMockPcreMatchConstraint( $pattern );
    }

    /**
     * Returns a constraint which checks if all the sub-constraints evaluates to true.
     *
     * @note All parameters will be passed as sub-constraints.
     */
    public function logicalAnd()
    {
        $constraints = func_get_args();
        $constraint = new ezcMockAndConstraint();
        $constraint->setConstraints( $constraints );
        return $constraint;
    }

    /**
     * Returns a constraint which checks if at least one of the sub-constraints evaluates to true.
     *
     * @note All parameters will be passed as sub-constraints.
     */
    public function logicalOr()
    {
        $constraints = func_get_args();
        $constraint = new ezcMockOrConstraint();
        $constraint->setConstraints( $constraints );
        return $constraint;
    }

    /**
     * Returns a constraint which inverts the result of the sub-constraint.
     *
     * @param mixed $constraint The value or constraint to evalute and invert the result of.
     * @return ezcMockNotConstraint
     */
    public function not( $constraint )
    {
        return new ezcMockNotConstraint( $constraint );
    }

    /**
     * Returns a constraint which checks if the input path exist on the filesystem.
     *
     * @return ezcMockFileExistsConstraint
     */
    public function existsOnDisk()
    {
        return new ezcMockFileExistsConstraint();
    }

    /**
     * Returns a stub which returns the specific value $value.
     * @param mixed $value The returned value.
     */
    public function returnValue( $value )
    {
        return new ezcMockReturnStub( $value );
    }

    /**
     * Asserts that the constraint $constraint evaluates the value $value
     * successfully. If it doesn't it will throw an exception.
     * A description is pulled from the constraint which should provide
     * sufficient of what was tried and why it failed
     *
     * @note This can be used to build more elaborate assertions without having
     *       to create multiple assert() methods.
     *
     * @param mixed $value The value which is passed to the constraint.
     * @param ezcMockConstraint $constraint The constraint which will match $value against its constraint rules.
     * @throw ezcMockExpectationFailed when the constraint evaulation fails.
     */
    static public function assertThat( $value, $constraint )
    {
        if ( !( $constraint instanceof ezcMockConstraint ) )
            throw new Exception( "assertThat() requires the $constraint variable to be an object of class ezcMockConstraint." );

        if ( !$constraint->evaluate( $value ) )
            $constraint->fail( $value, "failed asserting that <" . gettype( $value )  . ":" . var_export( $value, true ) . "> " . $constraint->generateDescription() );
    }

    /**
     * Asserts that the value $expected is equal to the value $actual. If they
     * are not an exception is thrown with $comment included.
     * They are considered equal if the PHP operator == returns true.
     *
     * @note Reimplementation of PHPUnit2's assert method which does not require
     *       a $comment value to explain what is going on. The constraint should
     *       be able to describe it better.
     */
    static public function assertEquals( $expected, $actual, $comment = '', $delta = 0 )
    {
        $constraint = new ezcMockIsEqualConstraint( $expected );

        if ( !$constraint->evaluate( $actual ) )
            $constraint->fail( $actual, $comment . "failed asserting that <{$actual}> " . $constraint->generateDescription() );
    }

    /**
     * Asserts that the value $expected is identifical to the value $actual. If they
     * are not an exception is thrown with $comment included.
     * They are considered identical if the PHP operator === returns true.
     *
     * @note Reimplementation of PHPUnit2's assert method which does not require
     *       a $comment value to explain what is going on. The constraint should
     *       be able to describe it better.
     */
    static public function assertSame( $expected, $actual, $comment = '' )
    {
        $constraint = new ezcMockIsIdenticalConstraint( $expected );

        if ( !$constraint->evaluate( $actual ) )
            $constraint->fail( $actual, $comment . "failed asserting that <" . gettype( $actual )  . ":" . var_export( $actual, true ) . "> " . $constraint->generateDescription() );
    }

    /**
     * Asserts that the value $expected is not equal to the value $actual. If they
     * are an exception is thrown with $comment included.
     * They are considered not equal if the PHP operator != returns true.
     *
     * @note Reimplementation of PHPUnit2's assert method which does not require
     *       a $comment value to explain what is going on. The constraint should
     *       be able to describe it better.
     */
    static public function assertNotEquals( $expected, $actual, $comment = '', $delta = 0 )
    {
        $constraint = new ezcMockNotConstraint( new ezcMockIsEqualConstraint( $expected ) );

        if ( !$constraint->evaluate( $actual ) )
            $constraint->fail( $actual, $comment . "failed asserting that <{$actual}> " . $constraint->generateDescription() );
    }

    /**
     * Asserts that the value $expected is not identical to the value $actual. If they
     * are an exception is thrown with $comment included.
     * They are considered not identical if the PHP operator !== returns true.
     *
     * @note Reimplementation of PHPUnit2's assert method which does not require
     *       a $comment value to explain what is going on. The constraint should
     *       be able to describe it better.
     */
    static public function assertNotSame( $expected, $actual, $comment = '' )
    {
        $constraint = new ezcMockNotConstraint( new ezcMockIsIdenticalConstraint( $expected ) );

        if ( !$constraint->evaluate( $actual ) )
            $constraint->fail( $actual, $comment . "failed asserting that <" . gettype( $actual )  . ":" . var_export( $actual, true ) . "> " . $constraint->generateDescription() );
    }

    /**
     * Asserts that the value $actual has the boolean value true. If it does
     * not an exception is thrown with $comment included.
     *
     * @note Reimplementation of PHPUnit2's assert method which does not require
     *       a $comment value to explain what is going on. The constraint should
     *       be able to describe it better.
     */
    static public function assertTrue( $actual, $comment = '' )
    {
        $constraint = new ezcMockIsIdenticalConstraint( true );

        if ( !$constraint->evaluate( $actual ) )
            $constraint->fail( $actual, $comment . "failed asserting that <" . gettype( $actual )  . ":" . var_export( $actual, true ) . "> " . $constraint->generateDescription() );
    }

    /**
     * Asserts that the value $actual has the boolean value false. If it does
     * not an exception is thrown with $comment included.
     *
     * @note Reimplementation of PHPUnit2's assert method which does not require
     *       a $comment value to explain what is going on. The constraint should
     *       be able to describe it better.
     */
    static public function assertFalse( $actual, $comment = '' )
    {
        $constraint = new ezcMockIsIdenticalConstraint( false );

        if ( !$constraint->evaluate( $actual ) )
            $constraint->fail( $actual, $comment . "failed asserting that <" . gettype( $actual )  . ":" . var_export( $actual, true ) . "> " . $constraint->generateDescription() );
    }

    /**
     * Asserts that the value $actual is null. If it does not an exception is
     * thrown with $comment included.
     *
     * @note Reimplementation of PHPUnit2's assert method which does not require
     *       a $comment value to explain what is going on. The constraint should
     *       be able to describe it better.
     */
    static public function assertNull( $actual, $comment = '' )
    {
        $constraint = new ezcMockIsIdenticalConstraint( null );

        if ( !$constraint->evaluate( $actual ) )
            $constraint->fail( $actual, $comment . "failed asserting that <" . gettype( $actual )  . ":" . var_export( $actual, true ) . "> " . $constraint->generateDescription() );
    }

    /**
     * Asserts that the value $actual is not null. If it does not an exception
     * is thrown with $comment included.
     *
     * @note Reimplementation of PHPUnit2's assert method which does not require
     *       a $comment value to explain what is going on. The constraint should
     *       be able to describe it better.
     */
    static public function assertNotNull( $actual, $comment = '' )
    {
        $constraint = new ezcMockNotConstraint( new ezcMockIsIdenticalConstraint( null ) );

        if ( !$constraint->evaluate( $actual ) )
            $constraint->fail( $actual, $comment . "failed asserting that <" . gettype( $actual )  . ":" . var_export( $actual, true ) . "> " . $constraint->generateDescription() );
    }

    /**
     * Asserts that the PCRE pattern $pattern matches the string $string. If it
     * does not an exception is thrown with $comment included.
     *
     * @param $pattern PCRE string pattern, the value is passed directly to preg_match().
     * @param $string Input string to check pattern on.
     * @note Reimplementation of PHPUnit2's assert method which does not require
     *       a $comment value to explain what is going on. The constraint should
     *       be able to describe it better.
     */
    static public function assertRegexp( $pattern, $string, $comment = '' )
    {
        $constraint = new ezcMockPcreMatchConstraint( $pattern );

        if ( !$constraint->evaluate( $string ) )
            $constraint->fail( $string, $comment . "failed asserting that string <" . var_export( $string, true ) . "> " . $constraint->generateDescription() );
    }
}
?>
