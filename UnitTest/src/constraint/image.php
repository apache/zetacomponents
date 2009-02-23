<?php
/**
 * File contaning the ezcTestConstraintSimilarImage class.
 *
 * @package UnitTest
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once 'PHPUnit/Util/Filter.php';

PHPUnit_Util_Filter::addFileToFilter(__FILE__, 'PHPUNIT');

/**
 * Constraint class for image comparison.
 *
 * @package UnitTest
 * @version //autogentag//
 */
class ezcTestConstraintSimilarImage extends PHPUnit_Framework_Constraint
{
    /**
     * Filename of the image to compare against.
     * 
     * @var string
     */
    protected $filename;

    /**
     * Maximum delta between images.
     * 
     * @var int
     */
    protected $delta;

    /**
     * Difference between images.
     * 
     * @var int
     */
    protected $difference;

    /**
     * Constructor.
     * 
     * @param string $filename Filename of the image to compare against.
     * @param int $delta Maximum delta between images.
     * @return ezcConstraintSimilarImage
     */
    public function __construct( $filename, $delta = 0 )
    {
        if ( is_string( $filename ) &&
             is_file( $filename ) &&
             is_readable( $filename ) )
        {
            $this->filename = $filename;
        }
        else
        {
            throw new ezcBaseFileNotFoundException( $filename );
        }

        $this->delta = (int) $delta;
    }

    /**
     * Evaluates the constraint for parameter $other. Returns TRUE if the
     * constraint is met, FALSE otherwise.
     *
     * @param mixed $other Filename of the image to compare.
     * @return bool
     * @abstract
     */
    public function evaluate( $other )
    {
        if ( !is_string( $other ) ||
             !is_file( $other ) ||
             !is_readable( $other ) )
        {
            throw new ezcBaseFileNotFoundException( $other );
        }

        $descriptors = array( 
            array( 'pipe', 'r' ),
            array( 'pipe', 'w' ),
            array( 'pipe', 'w' ),
        );
        $command = sprintf(
            'compare -metric MAE %s %s null:',
            escapeshellarg( $this->filename ),
            escapeshellarg( $other )
        );

        $imageProcess = proc_open( $command, $descriptors, $pipes );
        
        // Close STDIN pipe
        fclose( $pipes[0] );
        
        $errorString = '';
        // Read STDERR 
        do 
        {
            $errorString .= rtrim( fgets( $pipes[2], 1024) , "\n" );
        } while ( !feof( $pipes[2] ) );
        
        $resultString = '';
        // Read STDOUT 
        do 
        {
            $resultString .= rtrim( fgets( $pipes[1], 1024) , "\n" );
        }
        while ( !feof( $pipes[1] ) );
        
        // Wait for process to terminate and store return value
        $return = proc_close( $imageProcess );

        // Some versions output to STDERR
        if ( empty( $resultString) && !empty( $errorString ) )
        {
            $resultString = $errorString;
        }

        // Different versuions of ImageMagick seem to output "dB" or not
        if ( preg_match( '/([\d.,e]+)(\s+dB)?/', $resultString, $match ) )
        {
            $this->difference = (int) $match[1];
            return ( $this->difference <= $this->delta );
        }

        return false;
    }

    /**
     * Creates the appropriate exception for the constraint which can be caught
     * by the unit test system. This can be called if a call to evaluate() fails.
     *
     * @param   mixed   $other The value passed to evaluate() which failed the
     *                         constraint check.
     * @param   string  $description A string with extra description of what was
     *                               going on while the evaluation failed.
     * @param   boolean $not Flag to indicate negation.
     * @throws  PHPUnit_Framework_ExpectationFailedException
     */
    public function fail( $other, $description, $not = false )
    {
        $failureDescription = sprintf(
          'Failed asserting that image "%s" is similar to image "%s".',

           $other,
           $this->filename
        );

        if ($not) {
            $failureDescription = self::negate($failureDescription);
        }

        if (!empty($description)) {
            $failureDescription = $description . "\n" . $failureDescription;
        }

        if (!$not) {
            throw new PHPUnit_Framework_ExpectationFailedException(
              $failureDescription,
              PHPUnit_Framework_ComparisonFailure::diffEqual(
                $this->delta,
                $this->difference
              )
            );
        } else {
            throw new PHPUnit_Framework_ExpectationFailedException(
              $failureDescription
            );
        }
    }

    /**
     * Provide test text
     * 
     * @return string Test description
     */
    public function toString()
    {
        return sprintf(
          'is similar to "%s"', 
          $this->filename
        );
    }
}
?>
