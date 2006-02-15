<?php
/**
 * Constraint which performas a PCRE pattern match with another value.
 *
 * Checks a given value using the Perl Compatible Regular Expression extension
 * in PHP. The pattern is matched by executing preg_match().
 *
 * The pattern string passed in the constructor.
 *
 * @see {@url http://www.php.net/manual/en/ref.pcre.php}
 */
class ezcMockPcreMatchConstraint implements ezcMockConstraint
{
    /**
     * The PCRE pattern to match with.
     */
    private $pattern;

    /**
     * Initialise constraint with the PCRE pattern.
     * @param string $pattern PCRE pattern string.
     */
    public function __construct( $pattern )
    {
        $this->pattern = $pattern;
    }

    public function generateDescription()
    {
        return "matches PCRE pattern <" . var_export( $this->pattern, true ) . ">";
    }

    public function evaluate( $other )
    {
        return preg_match( $this->pattern, $other );
    }

    public function fail( $other, $description )
    {
        throw new ezcMockExpectationFailedException( $description . "\n" .
                                                     "PCRE pattern <" . var_export( $this->pattern, true ) . "> did not find a match in value <" . gettype( $other ) . ":" . var_export( $other, true ) . ">" );
    }
}
?>
