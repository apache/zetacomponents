<?php
/**
 * Constraint which checks if a certain string is found in the input string.
 *
 * Uses strpos() to find the position of the string in the input, if not found
 * the evaluaton fails.
 *
 * The sub-string is passed in the constructor.
 */
class ezcMockStringContainsConstraint implements ezcMockConstraint
{
    /**
     * The string which should be found in evaluated values.
     * @var string
     */
    private $string;

    /**
     * Controls case-sensitivty of string searching, if true it searches
     * case-sensitive and false searches case-insensitive.
     * @var bool
     */
    private $case;

    /**
     * Initialise constraint with string to find.
     * @param string $string The sub-string to find in input string.
     * @param bool $case Whether to search case-sensitive (true) or not (false).
     */
    public function __construct( $string, $case = true )
    {
        $this->string = $string;
        $this->case = $case;
    }

    public function generateDescription()
    {
        if ( $this->case )
            $string = var_export( $this->string, true );
        else
            $string = var_export( strtolower( $this->string ), true );
        return "contains string <{$string}>";
    }

    public function evaluate( $other )
    {
        if ( $this->case )
            return strpos( $other, $this->string ) !== false;
        else
            return stripos( $other, $this->string ) !== false;
    }

    public function fail( $other, $description )
    {
        if ( $this->case )
        {
            $string = var_export( $this->string, true );
            $otherString = var_export( $other, true );
        }
        else
        {
            $string = var_export( strtolower( $this->string ), true );
            $otherString = var_export( strtolower( $other ), true );
        }
        throw new ezcMockExpectationFailedException( $description . "\n" .
                                                     "expected string <{$string}> not found in string <{$otherString}>" );
    }
}
?>
