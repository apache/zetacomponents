<?php
/**
 * Exceptions for expectations which failed their check.
 *
 * The exception contains the error message and optionally a diff object
 * which is used to generate diff output of the failed expectations.
 */
class ezcMockExpectationFailedException extends PHPUnit2_Framework_AssertionFailedError
{
    /**
     * The diff object which can display the reason why an expectation failed.
     * Is null if no diff is available.
     *
     * @var ezcMockDiff
     */
    public $diff;

    /**
     * The description text without the diff result attached.
     * @var string
     */
    public $description;

    /**
     * Initialises the exception with the description and the differ.
     *
     * @param string $message Description of expectation which failed.
     * @param ezcMockDiff $diff Diff object which contains details on why it failed.
     */
    public function __construct( $message, /*ezcMockDiff*/ $diff = null )
    {
        $this->diff = $diff;
        $this->description = $message;
        if ( $diff instanceof ezcMockDiff )
        {
            $message .= "\n";
            $message .= $diff->generateDifference();
        }
        parent::__construct( $message );
    }
}
?>
